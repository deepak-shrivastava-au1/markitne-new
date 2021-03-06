"use strict";
/* jshint node: true */
/* global Promise */
/* jshint browser: true */
/* global am4maps */
/* global am4core */
/* global iMapsData */
/* global geocluster */
/* global iMapsRouter */
/* jshint esversion:5 */

/*
Model Object with methods and helpers to build the maps
*/
var iMapsManager = {};

iMapsManager.maps = {};

iMapsManager.init = function (i) {
	var im = this;
	im.addMap(i);
};

/**
 * Adds maps based on data index
 *
 */
iMapsManager.addMap = function (index) {
	var im = this,
		data = iMapsData.data[index],
		id = data.id,
		map,
		regionSeries,
		markerSeries,
		labelSeries,
		lineSeries,
		clusters,
		mapContainer,
		seriesColumn,
		legendHover,
		legendActive,
		imageSeries,
		iconSeries,
		graticuleSeries,
		clusterSeries,
		mapVar,
		bgSeries,
		bgImage,
		container = document.getElementById(data.container);

	if (data.disabled) {
		return;
	}

	if (container === null) {
		return;
	}

	// if map was already built
	if (typeof im.maps[id] !== 'undefined') {
		im.maps[id].map.dispose();
	}

	// map container size adjustment
	container.closest(".map_aspect_ratio").style.paddingTop = String(data.visual.paddingTop) + "%";

	if (data.visual.maxWidth !== "") {
		//container.closest(".map_box").style.maxWidth = String(data.visual.maxWidth) + "px";
	}

	if (data.visual.fontFamily !== "" && data.visual.fontFamily !== "inherit") {
		container.closest(".map_box").style.fontFamily = data.visual.fontFamily;
	}

	// create map and a shorter reference to it
	im.maps[id] = {
		map: am4core.create(data.container, am4maps.MapChart),
		series: [],
		clusterSeries: {},
		seriesIndex: {},
		data: data,
		allBaseSeries: [],
		baseRegionSeries: {}
	};

	map = im.maps[id].map;
	clusterSeries = im.maps[id].clusterSeries;

	// ready event
	map.events.on("ready", function (ev) {
		var event = new Event("mapready");
		container.dispatchEvent(event);
	});

	// enable small map
	if (data.zoom && data.zoom.smallMap && im.bool(data.zoom.smallMap)) {
		map.smallMap = new am4maps.SmallMap();
	}

	// load map geodata
	if (data.map === "custom" || im.bool(data.useGeojson)) {
		map.geodataSource.url = data.mapURL;
	} else {
		mapVar = iMapsRouter.getVarByName(data.map);
		map.geodata = window[mapVar];
	}



	// projection - moved to the end of the function to fix issue with Albers not rendering correctly
	map.projection = new am4maps.projections[data.projection]();

	map.fontFamily = data.visual.fontFamily;

	// export menu
	if (data.exportMenu && im.bool(data.exportMenu.enable)) {
		map.exporting.menu = new am4core.ExportMenu();
	}

	// different map center
	//map.deltaLongitude = -10;

	// pan behaviours
	// map.panBehavior = "rotateLongLat";
	// map.panBehavior = "rotateLong";
	// map.deltaLatitude = -20;
	// map.padding(20, 20, 20, 20);

	// visual settings
	map.background.fill = data.visual.backgroundColor;
	map.background.fillOpacity = data.visual.backgroundOpacity;

	// backgroud image
	if (typeof data.visual.bgImage !== 'undefined' && typeof data.visual.bgImage.url !== 'undefined' && data.visual.bgImage.url !== '') {
		bgSeries = map.series.push(new am4maps.MapImageSeries());
		bgSeries.toBack();
		bgImage = bgSeries.mapImages.template.createChild(am4core.Image);
		bgImage.propertyFields.href = "src";
		bgImage.width = map.width;
		bgImage.height = map.height;
		bgSeries.data = [{
			src: data.visual.bgImage.url
		}];
	}

	map.exporting.backgroundColor = data.visual.backgroundColor;
	map.exporting.filePrefix = "interactive_map";
	map.exporting.useWebFonts = false;

	// graticulate - grid lines
	if (data.projection === "Orthographic" && data.grid) {
		graticuleSeries = map.series.push(new am4maps.GraticuleSeries());
		graticuleSeries.mapLines.template.line.stroke = data.grid.color;
		graticuleSeries.mapLines.template.line.strokeOpacity = 1;
		graticuleSeries.fitExtent = false;
		map.backgroundSeries.mapPolygons.template.polygon.fillOpacity = 1;
		map.backgroundSeries.mapPolygons.template.polygon.fill =
			data.grid.projectionBackgroundColor;
	}

	im.handleZoom(id);

	// Legend
	if (data.legend && im.bool(data.legend.enabled)) {
		map.legend = new am4maps.Legend();

		// positioing
		if (data.legend.position === "top" || data.legend.position === "bottom") {
			map.legend.contentAlign = data.legend.align;
			map.legend.valign = data.legend.valign;
		} else {
			map.legend.position = data.legend.position;
			map.legend.align = data.legend.position;
			map.legend.valign = data.legend.valign;
		}

		// interactive
		if (data.legend.clickable === "false") {
			map.legend.itemContainers.template.interactionsEnabled = false;
		}

		if (data.legend.clickable === "toggle") {
			// do nothing, it's the default event
		}

		if (data.legend.clickable === "select") {
			map.legend.itemContainers.template.togglable = false;
			map.legend.itemContainers.template.events.on("hit", function (ev) {
				iMapsManager.clearSelected(id);
				var select = [];
				ev.target.dataItem.dataContext.mapPolygons.each(function (polygon) {
					if (!polygon.dataItem.dataContext.madeFromGeoData) {
						polygon.setState("active");
						polygon.isActive = true;
						polygon.isHover = false;
						select.push(polygon);
					}
				});

				im.maps[id].selected = select;
			});

			map.legend.itemContainers.template.events.on("over", function (ev) {
				ev.target.dataItem.dataContext.mapPolygons.each(function (polygon) {
					if (!polygon.dataItem.dataContext.madeFromGeoData) {
						polygon.setState("highlight");
					}
				});
			});

			map.legend.itemContainers.template.events.on("out", function (ev) {
				ev.target.dataItem.dataContext.mapPolygons.each(function (polygon) {
					if (!polygon.isActive) {
						polygon.setState("default");
					}
				});
			});
		}
	}

	// Create Main Series
	regionSeries = im.pushRegionSeries(id, data);
	im.maps[id].baseRegionSeries = regionSeries;

	// Check for grouped regions
	if (Array.isArray(data.regionGroups) && data.regionGroups.length) {
		data.regionGroups.forEach(function (group) {
			im.pushGroupSeries(id, group);
		});
	}


	// Overlay collections - we can add all series in the preset order
	if (Array.isArray(data.overlay) && data.overlay.length) {
		data.overlay.forEach(function (mapObj) {
			im.pushSeries(id, mapObj);
		});
	}

	// Create Other Series - we create them after the overlay to avoid overlap
	if (Array.isArray(data.lines) && data.lines.length) {
		lineSeries = im.pushLineSeries(id, data);
	}

	if (Array.isArray(data.roundMarkers) && data.roundMarkers.length) {
		markerSeries = im.pushRoundMarkerSeries(id, data);

		if (data.clusterMarkers && im.bool(data.clusterMarkers.enabled)) {
			markerSeries.hidden = true;
			clusters = im.setupClusters(data, id);
			clusterSeries[data.clusterMarkers.zoomLevel] = markerSeries;

			// we setup the main index series (zoom=1) to be visible
			// when doing it inside setupClusters function, there was a bug
			clusterSeries[1].hidden = false;
		}
	}

	if (Array.isArray(data.imageMarkers) && data.imageMarkers.length) {
		imageSeries = im.pushImageMarkerSeries(id, data);

		//imageSeries.hiddenInLegend = true;
		im.maps[id].allBaseSeries.push(imageSeries);
	}

	if (Array.isArray(data.iconMarkers) && data.iconMarkers.length) {
		iconSeries = im.pushIconMarkerSeries(id, data);

		//iconSeries.hiddenInLegend = true;
		im.maps[id].allBaseSeries.push(iconSeries);
	}

	if (Array.isArray(data.labels) && data.labels.length) {
		labelSeries = im.pushLabelSeries(id, data);

		//labelSeries.hiddenInLegend = true;
		im.maps[id].allBaseSeries.push(labelSeries);
	}

	// checks if we should display info and creates events.
	im.handleInfoBox(id);

	// map.projection = new am4maps.projections[data.projection]();

};

iMapsManager.handleZoom = function (id) {
	var im = this,
		map = im.maps[id].map,
		data = im.maps[id].data,
		allCurrentSeries = im.maps[id].series,
		allBaseSeries = im.maps[id].allBaseSeries;

	// Viewport settings

	// Zoom Level
	if (typeof data.viewport !== "undefined" && parseInt(data.viewport.zoomLevel) >= 1) {
		map.homeZoomLevel = parseInt(data.viewport.zoomLevel);

		// to make sure everything else is disabled by default
		map.seriesContainer.resizable = false;
		map.seriesContainer.draggable = false;
		map.chartContainer.wheelable = false;
	}

	// Home center point
	if (
		typeof data.viewport !== "undefined" &&
		data.viewport.homeGeoPoint &&
		data.viewport.homeGeoPoint.latitude !== 0 &&
		data.viewport.homeGeoPoint.longitude !== 0
	) {
		map.homeGeoPoint = data.viewport.homeGeoPoint;
	}



	// delta Coordinates Offset
	if (typeof data.viewport !== "undefined" && data.viewport.offset) {
		// only change if there are values, otherwise we might messup projections (Albers)
		if (data.viewport.offset.longitude !== '' && data.viewport.offset.longitude !== '0') {
			map.deltaLongitude = data.viewport.offset.longitude;
		}
		if (data.viewport.offset.latitude !== '' && data.viewport.offset.latitude !== '0') {
			map.deltaLatitude = data.viewport.offset.latitude;
		}

	}

	// default zoom behaviour
	if (typeof data.zoom === "undefined") {
		// default zoom behaviour when we can't find zoom settings

		if (typeof data.zoomMaster !== "undefined" && im.bool(data.zoomMaster)) {
			map.seriesContainer.draggable = true;
			map.seriesContainer.resizable = true;
			// display zoom controls by default
			map.zoomControl = new am4maps.ZoomControl();
			map.zoomControl.exportable = false;
			map.zoomControl.align = "right";
			map.zoomControl.valign = "bottom";
		} else {
			map.seriesContainer.resizable = false;
			map.seriesContainer.draggable = false;
		}

		map.seriesContainer.events.disableType("doublehit");
		map.chartContainer.background.events.disableType("doublehit");
		map.chartContainer.wheelable = false;
		return;
	}



	// disable drag in Ortographic and leave default for the rest
	if (data.projection !== "Orthographic") {
		map.seriesContainer.draggable = data.zoom ? im.bool(data.zoom.draggable) : false;
		map.seriesContainer.resizable = data.zoom ? im.bool(data.zoom.draggable) : false;

		// don't zoom out to center
		map.centerMapOnZoomOut = false;

		// zoom is enabled, only allowdrag on mobile
		if (
			im.bool(data.zoom.enabled) &&
			!im.bool(data.zoom.draggable) &&
			im.bool(data.zoom.mobileResizable) &&
			(/Mobi|Android/i.test(navigator.userAgent))
		) {
			map.seriesContainer.draggable = true;
			map.seriesContainer.resizable = true;
		}
	} else {
		map.seriesContainer.draggable = false;
		map.seriesContainer.resizable = false;
		map.panBehavior = "rotateLongLat";
	}

	// disable zoom
	if (!im.bool(data.zoom.enabled)) {
		map.maxZoomLevel = parseInt(data.viewport.zoomLevel);
		map.seriesContainer.events.disableType("doublehit");
		map.chartContainer.background.events.disableType("doublehit");
		map.seriesContainer.draggable = false;
		map.seriesContainer.resizable = false;
	} else {
		// mouse wheel zoom
		map.chartContainer.wheelable = im.bool(data.zoom.wheelable);

		// double click zoom
		if (!im.bool(data.zoom.doubleHitZoom)) {
			map.seriesContainer.events.disableType("doublehit");
			map.chartContainer.background.events.disableType("doublehit");
		}

		// Zoom Controls
		if (im.bool(data.zoom.controls)) {
			map.zoomControl = new am4maps.ZoomControl();
			map.zoomControl.exportable = false;

			map.zoomControl.align = data.zoom.controlsPositions ? data.zoom.controlsPositions.align : "right";
			map.zoomControl.valign = data.zoom.controlsPositions ? data.zoom.controlsPositions.valign : "bottom";

			if (
				typeof data.zoom.homeButton === "undefined" ||
				im.bool(data.zoom.homeButton)
			) {
				// home button
				var homeButton = new am4core.Button();
				homeButton.events.on("hit", function () {
					map.goHome();
					// in case drillDown is enabled, we hide everything else
					if (im.bool(data.drillDownOnClick)) {
						for (var i = 0, len = allCurrentSeries.length; i < len; i++) {
							allCurrentSeries[i].hide();
							//map.deltaLongitude = 0;
						}
						for (var ib = 0, lenb = allBaseSeries.length; ib < lenb; ib++) {
							im.maps[id].allBaseSeries[ib].show();
						}

						iMapsManager.maps[id].isDrilling = false;
					}
				});

				homeButton.icon = new am4core.Sprite();
				homeButton.padding(7, 5, 7, 5);
				homeButton.width = 30;
				homeButton.icon.path =
					"M16,8 L14,8 L14,16 L10,16 L10,10 L6,10 L6,16 L2,16 L2,8 L0,8 L8,0 L16,8 Z M16,8";
				homeButton.marginBottom = 3;
				homeButton.parent = map.zoomControl;
				homeButton.insertBefore(map.zoomControl.plusButton);
			}
		}
	}



	map.events.on("zoomlevelchanged", function (ev) {
		var clusterSeries = im.maps[id].clusterSeries,
			closest,
			zlevel = ev.target.zoomLevel,
			isDrilling = im.maps[id].isDrilling;

		if (isDrilling) {
			return;
		}

		if (clusterSeries && Object.keys(clusterSeries).length) {
			closest = Object.keys(clusterSeries).reduce(function (prev, curr) {
				prev = parseInt(prev);
				curr = parseInt(curr);
				return Math.abs(curr - zlevel) < Math.abs(prev - zlevel) ? curr : prev;
			});

			Object.keys(clusterSeries).forEach(function (key) {
				clusterSeries[key].hide();
				if (parseFloat(key) === closest) {
					clusterSeries[key].show();
				} else {
					clusterSeries[key].hide();
				}
			});
		}
	});
};

/**
 * Push region series that are grouped together
 */
iMapsManager.pushGroupSeries = function (id, data) {

	var im = this,
		originalData = im.maps[id].data,
		newData = {},
		include = data.map(function (a) { return a.id; });

	// let's get all the options from the main map and change the group option to true
	newData = Object.assign({}, originalData);
	newData.regionsGroupHover = true;
	newData.regions = data;
	newData.include = include;

	// include only the regions we're grouping

	iMapsManager.pushRegionSeries(id, newData);

	return;
};

/**
 * Push different series of overlay/child maps
 * int i - index of the map data
 * data - object with map data to push
 */
iMapsManager.pushSeries = function (id, data) {
	var im = this,
		regionSeries,
		markerSeries,
		labelSeries,
		lineSeries,
		iconSeries,
		imageSeries,
		seriesIndex = im.maps[id].seriesIndex,
		isDrill = im.bool(im.maps[id].data.drillDownOnClick),
		cleanMapName = iMapsRouter.getCleanMapName(data.map);

	if (false === cleanMapName) {
		return;
	}

	// setup series index
	if (!Array.isArray(im.maps[id].seriesIndex[data.map])) {
		im.maps[id].seriesIndex[cleanMapName] = [];
	}

	// to allow empty maps to overlay, we removed the check
	if ((Array.isArray(data.regions) && data.regions.length) || isDrill) {
		regionSeries = iMapsManager.pushRegionSeries(id, data);
		seriesIndex[cleanMapName].push(regionSeries);
		if (isDrill) {
			regionSeries.hidden = true;
		}
	}

	if (Array.isArray(data.roundMarkers) && data.roundMarkers.length) {
		markerSeries = iMapsManager.pushRoundMarkerSeries(id, data);
		seriesIndex[cleanMapName].push(markerSeries);
		if (isDrill) {
			markerSeries.hidden = true;
		}
	}

	if (Array.isArray(data.iconMarkers) && data.iconMarkers.length) {
		iconSeries = iMapsManager.pushIconMarkerSeries(id, data);
		seriesIndex[cleanMapName].push(iconSeries);
		if (isDrill) {
			iconSeries.hidden = true;
		}
	}

	if (Array.isArray(data.imageMarkers) && data.imageMarkers.length) {
		imageSeries = iMapsManager.pushImageMarkerSeries(id, data);
		seriesIndex[cleanMapName].push(imageSeries);
		if (isDrill) {
			imageSeries.hidden = true;
		}
	}

	if (Array.isArray(data.labels) && data.labels.length) {
		labelSeries = iMapsManager.pushLabelSeries(id, data);
		seriesIndex[cleanMapName].push(labelSeries);
		if (isDrill) {
			labelSeries.hidden = true;
		}
	}

	if (Array.isArray(data.lines) && data.lines.length) {
		lineSeries = iMapsManager.pushLineSeries(id, data);
		seriesIndex[cleanMapName].push(lineSeries);
		if (isDrill) {
			lineSeries.hidden = true;
		}
	}
};

iMapsManager.pushRegionSeries = function (id, data) {
	var im = this,
		map = im.maps[id].map, // shorter reference for the map
		regionSeries,
		tooltipConfig = data.tooltip || {},
		regionTemplate,
		hover,
		active,
		highlight,
		mapVar,
		groupHover = im.bool(data.regionsGroupHover);

	data = data || {};

	regionSeries = map.series.push(new am4maps.MapPolygonSeries());

	if (data.map === "custom" || im.bool(data.useGeojson)) {
		regionSeries.geodataSource.url = data.mapURL;
	} else {
		mapVar = iMapsRouter.getVarByName(data.map);
		regionSeries.geodata = window[mapVar];
	}

	regionSeries.name =
		data.regionLegend && data.regionLegend.title !== "" ? data.regionLegend.title : data.title;
	regionSeries.hiddenInLegend = data.regionsLegend ? !im.bool(data.regionsLegend.enabled) : true;

	// if it's a base series
	if (id === data.id) {
		// add it as the baseSeries
		im.maps[id].baseSeries = regionSeries;
		im.maps[id].allBaseSeries.push(regionSeries);
	}

	// Make map load polygon (like country names) data from GeoJSON
	regionSeries.useGeodata = true;

	// Exclude
	if (Array.isArray(data.exclude) && data.exclude.length) {
		regionSeries.exclude = data.exclude;
	}

	// Include
	if (Array.isArray(data.include) && data.include.length) {
		regionSeries.include = data.include;
	}

	// Setup Heatmap rules
	if (data.heatMapRegions && im.bool(data.heatMapRegions.enabled)) {
		im.setupHeatMap(regionSeries, id);
	}

	// Data
	// if (Array.isArray(data.regions)) {
	regionSeries.data = data.regions;

	// Configure series
	regionTemplate = regionSeries.mapPolygons.template;

	im.setupTooltip(regionSeries, id);

	// tooltip content
	regionTemplate.tooltipText = tooltipConfig.template ? tooltipConfig.template : "{tooltipContent}";
	regionTemplate.tooltipHTML = tooltipConfig.template ? tooltipConfig.template : "{tooltipContent}";

	regionTemplate.adapter.add("tooltipHTML", function (value, target, key) {
		if (typeof target.dataItem.dataContext === 'object' && typeof tooltipConfig.onlyWithData !== 'undefined') {
			// check if we don't return tooltip on empty regions
			if (im.bool(tooltipConfig.onlyWithData)) {
				if (target.dataItem.dataContext.madeFromGeoData === true) {
					target.tooltip.tooltipText = undefined;
					target.tooltip.tooltipHTML = undefined;
					return '';
				}
			}
		}
		if (value === "") {
			return value;
		}
		return value.replace(/\\/g, "");
	});

	regionTemplate.adapter.add("tooltipText", function (value, target, key) {
		if (typeof target.dataItem.dataContext === 'object' && typeof tooltipConfig.onlyWithData !== 'undefined') {
			// check if we don't return tooltip on empty regions
			if (im.bool(tooltipConfig.onlyWithData)) {
				if (target.dataItem.dataContext.madeFromGeoData === true) {
					target.tooltip.tooltipText = undefined;
					target.tooltip.tooltipHTML = undefined;
					return '';
				}
			}
		}
		if (value === "") {
			return value;
		}
		return value.replace(/\\/g, "");
	});

	// For legend color
	regionSeries.fill = data.regionDefaults.fill;

	regionTemplate.fill = data.regionDefaults.inactiveColor;
	regionTemplate.stroke = data.visual.borderColor;
	regionTemplate.strokeWidth = data.visual.borderWidth;

	// fill
	regionTemplate.propertyFields.fill = "fill";

	// exploring adapter
	/*
		regionTemplate.adapter.add("fill", function(fill, target) {
			return chart.colors.getIndex(Math.round(Math.random() * 4)).saturate(0.3);
		});*/

	// hover - only create if it's not a group hover series
	if (!groupHover) {
		hover = regionTemplate.states.create("hover");
		hover.propertyFields.fill = "hover";
		//hover.propertyFields.strokeWidth = "borderWidthHover";
		//hover.propertyFields.stroke = "borderColorHover";
	}

	// active
	//active = regionTemplate.states.create("active");
	//active.propertyFields.fill = "hover";

	// highlight - for group hover
	highlight = regionTemplate.states.create("highlight");
	highlight.properties.fill = data.regionDefaults.hover;

	// Events
	regionTemplate.events.on("hit", function (ev) {
		im.setupHitEvents(id, ev);
	});

	if (groupHover) {

		regionTemplate.events.on("out", function (ev) {
			im.groupHoverOut(id, ev);
		});
		regionTemplate.events.on("over", function (ev) {
			im.groupHover(id, ev);
		});
		regionTemplate.events.on("hit", function (ev) {
			im.groupHit(id, ev);
		});
	} else {
		regionTemplate.events.on("hit", function (ev) {
			im.singleHit(id, ev);
		});
		regionTemplate.events.on("over", function (ev) {
			im.setupHoverEvents(id, ev);
		});
	}

	// enable small map
	if (im.bool(data.smallMap)) {
		map.smallMap.series.push(regionSeries);
	}

	// auto Labels in progress
	if (im.bool(data.regionLabels)) {
		regionSeries.calculateVisualCenter = true;

		// Configure label series
		var labelSeries = map.series.push(new am4maps.MapImageSeries());
		var labelTemplate = labelSeries.mapImages.template.createChild(
			am4core.Label
		);

		labelTemplate.horizontalCenter = data.regionLabels.horizontalCenter;
		labelTemplate.verticalCenter = data.regionLabels.verticalCenter;
		labelTemplate.fontSize = data.regionLabels.fontSize;
		labelTemplate.fill = data.regionLabels.fill;

		// let's set a listener to the hide event of main series to hide this one also
		regionSeries.events.on("hidden", function (ev) {
			labelSeries.hide();
		});

		regionSeries.events.on("shown", function (ev) {
			labelSeries.show();
		});

		// label events
		labelTemplate.events.on("hit", function (ev) {
			iMapsManager.select(id, ev.target.parent.LabelForRegion);
		});
		labelTemplate.events.on("over", function (ev) {
			iMapsManager.hover(id, ev.target.parent.LabelForRegion);
		});
		labelTemplate.events.on("out", function (ev) {
			iMapsManager.clearHovered(id, ev.target.parent.LabelForRegion);
		});

		im.setupTooltip(labelSeries, id);

		labelTemplate.interactionsEnabled = true;
		labelTemplate.nonScaling = im.bool(data.regionLabels.nonScaling);
		labelSeries.hiddenInLegend = true;

		// fix initially hidden series - for example drilldown overlay
		regionSeries.events.on("inited", function () {
			if (regionSeries.hidden) {
				labelSeries.hide();
				labelSeries.hidden = true;
			}
		});

		// set labels drag listener
		// allow labels to be dragged if in admin
		if (im.bool(data.admin)) {

			labelTemplate.draggable = true;
			labelTemplate.cursorOverStyle = am4core.MouseCursorStyle.grab;
			labelTemplate.events.on("dragstop", function (ev) {



				var svgPoint = am4core.utils.spritePointToSvg({
					x: 0,
					y: 0
				}, ev.target);

				console.log(svgPoint);

				svgPoint = am4core.utils.spritePointToSvg({
					x: 0 - ev.target.maxLeft,
					y: 0 - ev.target.maxTop
				}, ev.target);

				console.log(svgPoint);


				var geo = map.svgPointToGeo(svgPoint);

				console.log('left', ev.target.maxLeft);
				console.log('left', ev.target.maxRight);
				console.log('top', ev.target.maxTop);
				console.log('bottom', ev.target.maxBottom);

				// check if field to add json object with adjustments exists
				var adjField = document.querySelector(
					"[data-depend-id=" + data.regionLabelCustomCoordinates + "]"
				);
				if (adjField) {

					var jsonAdjustments;

					if (iMapsManager.isJSON(adjField.value)) {
						jsonAdjustments = JSON.parse(adjField.value);
					} else {
						jsonAdjustments = {};
					}

					jsonAdjustments[ev.target.parent.LabelForRegion] = {
						latitude: geo.latitude,
						longitude: geo.longitude
					};

					adjField.value = JSON.stringify(jsonAdjustments);
				}

				map.seriesContainer.draggable = im.bool(data.zoom.draggable);
				ev.target.cursorOverStyle = am4core.MouseCursorStyle.grab;
			});

			labelTemplate.events.on("down", function (ev) {
				map.seriesContainer.draggable = false;
				ev.target.cursorOverStyle = am4core.MouseCursorStyle.grabbing;
			});
		}

		// end dragevent

		// convert custom json position string to object
		var regionLabelCustomCoordinates = im.isJSON(data.regionLabels.regionLabelCustomCoordinates) ? JSON.parse(data.regionLabels.regionLabelCustomCoordinates) : false;

		regionSeries.events.on("inited", function () {
			regionSeries.mapPolygons.each(function (polygon) {
				var label = labelSeries.mapImages.create(),
					text;

				// if we're only adding labels to active regions
				if (
					im.bool(data.regionLabels.activeOnly) &&
					typeof polygon.dataItem.dataContext.tooltipContent === "undefined"
				) {
					return;
				}

				if (data.regionLabels.source === "code") {
					text = polygon.dataItem.dataContext.id.split("-").pop();
				}
				if (data.regionLabels.source === "{name}") {
					text = polygon.dataItem.dataContext.name;
				}
				if (data.regionLabels.source === "{id}") {
					text = polygon.dataItem.dataContext.id;
				}

				label.LabelForRegion = polygon.dataItem.dataContext.id;

				// tooltip content
				label.tooltipDataItem = polygon.tooltipDataItem;
				label.tooltip = polygon.tooltip;
				label.tooltipHTML = polygon.tooltipHTML;
				label.tooltipPosition = im.bool(data.tooltip.fixed) ? "fixed" : "pointer";

				// cursor style
				if (
					polygon.dataItem.dataContext.action &&
					polygon.dataItem.dataContext.action !== "none"
				) {
					label.cursorOverStyle = am4core.MouseCursorStyle.pointer;
				}

				// use custom coordinates adjustments or use auto position
				if (
					regionLabelCustomCoordinates &&
					regionLabelCustomCoordinates.hasOwnProperty(
						polygon.dataItem.dataContext.id
					)
				) {
					label.latitude =
						regionLabelCustomCoordinates[
							polygon.dataItem.dataContext.id
						].latitude;
					label.longitude =
						regionLabelCustomCoordinates[
							polygon.dataItem.dataContext.id
						].longitude;
				} else {
					label.latitude = polygon.visualLatitude;
					label.longitude = polygon.visualLongitude;
				}
				if (label.children.getIndex(0)) {
					label.children.getIndex(0).text = text;
				}

			});
		});
	}

	// add this series to map series to reference it later if needed
	im.maps[id].series.push(regionSeries);

	return regionSeries;
};

iMapsManager.pushRoundMarkerSeries = function (id, data) {
	var im = this,
		map = im.maps[id].map, // shorter reference for the map
		markerSeries,
		markerSeriesTemplate,
		circle,
		label,
		hoverState;

	if (Array.isArray(data.roundMarkers) && data.roundMarkers.length) {
		// Create image series
		markerSeries = map.series.push(new am4maps.MapImageSeries());
		markerSeries.name = data.roundMarkersLegend && data.roundMarkersLegend.title !== "" ? data.roundMarkersLegend.title : data.title;
		markerSeries.hiddenInLegend = data.roundMarkersLegend ? !im.bool(data.roundMarkersLegend.enabled) : false;

		im.setupTooltip(markerSeries, id);

		// Create a circle image in image series template so it gets replicated to all new images
		markerSeriesTemplate = markerSeries.mapImages.template;
		circle = markerSeriesTemplate.createChild(am4core.Circle);
		// default values

		circle.radius = data.markerDefaults.radius;
		circle.fill = data.markerDefaults.fill;
		circle.stroke = am4core.color("#FFFFFF");
		circle.strokeWidth = 1;
		circle.nonScaling = true;

		// label
		label = markerSeriesTemplate.createChild(am4core.Label);
		label.text = "{label}";
		label.fill = am4core.color("#fff");
		label.verticalCenter = "middle";
		label.horizontalCenter = "middle";
		label.nonScaling = true;
		label.fontSize = data.markerDefaults.radius;
		label.clickable = false;
		label.focusable = false;
		label.hoverable = false;

		// custom fields

		circle.tooltipText = data.tooltip && data.tooltip.template ? data.tooltip.template : "{tooltipContent}";
		circle.tooltipHTML = data.tooltip && data.tooltip.template ? data.tooltip.template : "{tooltipContent}";

		// fill can only be set if heatmap is not enabled
		if (data.heatMapMarkers && im.bool(data.heatMapMarkers.enabled)) {
			im.setupHeatMap(markerSeries, id);
		} else {
			circle.propertyFields.radius = "radius";
			circle.propertyFields.fill = "fill";
		}

		// Set property fields
		markerSeriesTemplate.propertyFields.radius = "radius";

		markerSeriesTemplate.propertyFields.latitude = "latitude";
		markerSeriesTemplate.propertyFields.longitude = "longitude";

		// hover & active
		hoverState = circle.states.create("hover");
		hoverState.properties.fill = data.hover;
		hoverState.propertyFields.fill = "hover";

		// not working
		//activeState = circle.states.create("active");
		//activeState.properties.fill = config.hoverColor;
		//activeState.propertyFields.fill = "hoverColor";

		// Add data
		markerSeries.data = data.roundMarkers;
		// For legend color
		markerSeries.fill = data.markerDefaults.fill;

		// Events
		markerSeriesTemplate.events.on("hit", function (ev) {
			im.setupHitEvents(id, ev);
			im.singleHit(id, ev);
		});
		markerSeriesTemplate.events.on("over", function (ev) {
			im.setupHoverEvents(id, ev);
		});
	}

	// enable small map
	if (data.zoom && data.zoom.smallMap && im.bool(data.zoom.smallMap)) {
		map.smallMap.series.push(markerSeries);
	}

	// add this series to map series to reference it later if needed
	im.maps[id].series.push(markerSeries);

	// if part of the parent map
	if (id === data.id) {
		// only add as base if not a cluster
		if (data.clusterMarkers && !im.bool(data.clusterMarkers.enabled)) {
			im.maps[id].allBaseSeries.push(markerSeries);
		} else if (data.clusterMarkers && im.bool(data.clusterMarkers.enabled)) {
			// it's a cluster, so the main series with all markers
			// markerSeries.hidden = true;
		}
	}
	return markerSeries;
};

iMapsManager.pushImageMarkerSeries = function (id, data) {
	var im = this,
		map = im.maps[id].map, // shorter reference for the map
		markerSeries,
		markerSeriesTemplate,
		imageMarker;

	if (Array.isArray(data.imageMarkers) && data.imageMarkers.length) {
		// Create image series
		markerSeries = map.series.push(new am4maps.MapImageSeries());
		markerSeries.name = data.imageMarkersLegend && data.imageMarkersLegend.title !== "" ? data.imageMarkersLegend.title : data.title;
		markerSeries.hiddenInLegend = data.imageMarkersLegend ? !im.bool(data.imageMarkersLegend.enabled) : false;

		im.setupTooltip(markerSeries, id);

		// Create a circle image in image series template so it gets replicated to all new images
		markerSeriesTemplate = markerSeries.mapImages.template;
		imageMarker = markerSeriesTemplate.createChild(am4core.Image);
		imageMarker.propertyFields.href = "href";
		imageMarker.propertyFields.width = "size";
		imageMarker.propertyFields.height = "size";
		//imageMarker.propertyFields.height = "height";
		imageMarker.propertyFields.horizontalCenter = "horizontalCenter";
		imageMarker.propertyFields.verticalCenter = "verticalCenter";
		imageMarker.nonScaling = true;
		imageMarker.tooltipText = data.tooltip.template ? data.tooltip.template : "{titleContent}";
		imageMarker.tooltipHTML = data.tooltip.template ? data.tooltip.template : "{titleContent}";

		// Set property fields
		markerSeriesTemplate.propertyFields.latitude = "latitude";
		markerSeriesTemplate.propertyFields.longitude = "longitude";

		// Add data for the three cities
		markerSeries.data = data.imageMarkers;

		// Events
		markerSeriesTemplate.events.on("hit", function (ev) {
			im.setupHitEvents(id, ev);
			im.singleHit(id, ev);
		});
		markerSeriesTemplate.events.on("over", function (ev) {
			im.setupHoverEvents(id, ev);
		});
	}

	// enable small map
	if (data.zoom && data.zoom.smallMap && im.bool(data.zoom.smallMap)) {
		map.smallMap.series.push(markerSeries);
	}

	// add this series to map series to reference it later if needed
	im.maps[id].series.push(markerSeries);

	return markerSeries;
};

iMapsManager.pushIconMarkerSeries = function (id, data) {
	var im = this,
		map = im.maps[id].map, // shorter reference for the map
		markerSeries,
		markerSeriesTemplate,
		icon,
		hover,
		active,
		label,
		clickableOverlay;

	if (Array.isArray(data.iconMarkers) && data.iconMarkers.length) {
		// Create image series
		markerSeries = map.series.push(new am4maps.MapImageSeries());
		markerSeries.hiddenInLegend = data.iconMarkersLegend ? !im.bool(data.iconMarkersLegend.enabled) : false;
		markerSeries.name = data.iconMarkersLegend && data.iconMarkersLegend.title !== "" ? data.iconMarkersLegend.title : data.title;
		markerSeriesTemplate = markerSeries.mapImages.template;
		markerSeriesTemplate.nonScaling = true;

		markerSeriesTemplate.setStateOnChildren = true; //apply parent's current state to children
		markerSeriesTemplate.states.create('hover'); //create dummy state for hover

		im.setupTooltip(markerSeries, id);

		// Create a circle image in image series template so it gets replicated to all new images
		icon = markerSeriesTemplate.createChild(am4core.Sprite);
		icon.propertyFields.scale = "scale";
		icon.propertyFields.path = "path";

		icon.tooltipText = data.tooltip.template ? data.tooltip.template : "{tooltipContent}";
		icon.tooltipHTML = data.tooltip.template ? data.tooltip.template : "{tooltipContent}";
		icon.propertyFields.horizontalCenter = "horizontalCenter";
		icon.propertyFields.verticalCenter = "verticalCenter";
		icon.propertyFields.fill = "fill";

		// For legend color
		markerSeries.fill = data.iconMarkerDefaults.fill;

		// clickable overlay
		clickableOverlay = markerSeriesTemplate.createChild(am4core.Sprite);
		clickableOverlay.propertyFields.scale = "scale";
		clickableOverlay.path = "M-10,0a10,10 0 1,0 20,0a10,10 0 1,0 -20,0";
		clickableOverlay.opacity = 0;
		clickableOverlay.propertyFields.horizontalCenter = "horizontalCenter";
		clickableOverlay.propertyFields.verticalCenter = "verticalCenter";
		clickableOverlay.tooltipText = data.tooltip.template
			? data.tooltip.template
			: "{tooltipContent}";
		clickableOverlay.tooltipHTML = data.tooltip.template
			? data.tooltip.template
			: "{tooltipContent}";

		// hover & active
		hover = icon.states.create("hover");
		hover.propertyFields.fill = "hover";
		active = icon.states.create("active");
		active.propertyFields.fill = "hover";

		// Set property fields
		markerSeriesTemplate.propertyFields.latitude = "latitude";
		markerSeriesTemplate.propertyFields.longitude = "longitude";

		// Add data for the three cities
		markerSeries.data = data.iconMarkers;

		// Events
		markerSeriesTemplate.events.on("hit", function (ev) {
			im.setupHitEvents(id, ev);
			im.singleHit(id, ev);
		});
		markerSeriesTemplate.events.on("over", function (ev) {
			im.setupHoverEvents(id, ev);
		});
	}

	// enable small map
	if (data.zoom && data.zoom.smallMap && im.bool(data.zoom.smallMap)) {
		map.smallMap.series.push(markerSeries);
	}
	// add this series to map series to reference it later if needed
	im.maps[id].series.push(markerSeries);

	return markerSeries;
};

iMapsManager.pushLineSeries = function (id, data) {
	var im = this,
		map = im.maps[id].map, // shorter reference for the map
		lineSeries = {},
		lineData = [];

	// Lines
	if (Array.isArray(data.lines) && data.lines.length) {
		// Add line series

		if (data.projection === "Orthographic") {
			lineSeries = map.series.push(new am4maps.MapLineSeries());
			lineSeries.mapLines.template.propertyFields.shortestDistance = true;
		} else {
			lineSeries = map.series.push(new am4maps.MapArcSeries());
			lineSeries.mapLines.template.line.propertyFields.controlPointDistance =
				"curvature";
			lineSeries.mapLines.template.line.controlPointPosition = 0.5;
		}

		lineSeries.name = data.linesLegend && data.linesLegend.title !== "" ? data.linesLegend.title : data.title;
		lineSeries.hiddenInLegend = data.linesLegend ? !im.bool(data.linesLegend.enabled) : false;

		lineSeries.mapLines.template.nonScalingStroke = true;
		lineSeries.mapLines.template.propertyFields.strokeWidth = "strokeWidth";
		lineSeries.mapLines.template.propertyFields.strokeDasharray = "strokeDash";

		lineSeries.mapLines.template.propertyFields.stroke = "stroke";

		//lineObj.multiGeoLine = [lineObj.multiGeoLine];
		//lineSeries.data = [lineObj];

		data.lines.forEach(function (lineObj) {
			// make sure multiGeoLine is array of arrays:
			lineObj.multiGeoLine = [lineObj.multiGeoLine];
			lineData.push(lineObj);
		});

		lineSeries.data = lineData;

		// enable small map
		if (data.zoom && data.zoom.smallMap && im.bool(data.zoom.smallMap)) {
			map.smallMap.series.push(lineSeries);
		}

		//let's hide this from legend, since they don't group in the same Series
		//lineSeries.hiddenInLegend = true;

		// add this series to map series to reference it later if needed
		im.maps[id].series.push(lineSeries);

		// For legend color
		lineSeries.fill = data.lineDefaults.stroke;

		// if it's part of the parent map
		if (id === data.id) {
			im.maps[id].allBaseSeries.push(lineSeries);
		}
	}

	return lineSeries;
};

iMapsManager.pushLabelSeries = function (id, data) {
	var im = this,
		map = im.maps[id].map, // shorter reference for the map
		labelSeries,
		labelTemplate,
		label,
		hover,
		active;

	if (Array.isArray(data.labels) && data.labels.length) {
		// Create label series
		labelSeries = map.series.push(new am4maps.MapImageSeries());
		labelSeries.name = data.labelsLegend && data.labelsLegend.title !== "" ? data.labelsLegend.title : data.title;
		labelSeries.hiddenInLegend = data.labelsLegend ? !im.bool(data.labelsLegend.enabled) : false;

		labelSeries.isLabels = true;

		labelTemplate = labelSeries.mapImages.template;

		im.setupTooltip(labelSeries, id);

		label = labelTemplate.createChild(am4core.Label);

		if (data.labelStyle) {
			label.horizontalCenter = data.labelStyle.horizontalCenter;
			label.verticalCenter = data.labelStyle.verticalCenter;
			label.fontFamily = data.labelStyle.fontFamily;
			label.fontWeight = data.labelStyle.fontWeight;
		}

		label.nonScaling = true;

		label.tooltipText = data.tooltip.template ? data.tooltip.template : "{tooltipContent}";
		label.tooltipHTML = data.tooltip.template ? data.tooltip.template : "{tooltipContent}";

		label.tooltipPosition = im.bool(data.tooltip.fixed) ? "fixed" : "pointer";

		label.propertyFields.fill = "fill";
		label.propertyFields.fontSize = "fontSize";
		label.propertyFields.text = "id";

		// For legend color
		labelSeries.fill = data.labelDefaults.fill;

		// hover & active
		hover = label.states.create("hover");
		hover.propertyFields.fill = "hover";
		active = label.states.create("active");
		active.propertyFields.fill = "hover";

		// Set property fields
		labelTemplate.propertyFields.latitude = "latitude";
		labelTemplate.propertyFields.longitude = "longitude";

		labelSeries.data = data.labels;

		// Events
		labelSeries.events.on("hit", function (ev) {
			im.setupHitEvents(id, ev);
			im.singleHit(id, ev);
		});
		labelSeries.events.on("over", function (ev) {
			im.setupHoverEvents(id, ev);
		});

		// enable small map
		if (data.zoom && data.zoom.smallMap && im.bool(data.zoom.smallMap)) {
			map.smallMap.series.push(labelSeries);
		}
	}

	im.maps[id].series.push(labelSeries);
	return labelSeries;
};

iMapsManager.setupTooltip = function (regionSeries, id) {
	var im = this,
		data = im.maps[id].data,
		tooltip = data.tooltip,
		shadow;

	// don't include it in export
	// regionSeries.tooltip.exportable = false;

	// default behaviour
	if (typeof data.tooltip === "undefined") {
		regionSeries.tooltip.disabled = false;
		regionSeries.tooltip.getFillFromObject = false;
		regionSeries.tooltip.getStrokeFromObject = false;
		regionSeries.tooltip.label.fill = am4core.color("#000000");
		regionSeries.tooltip.background.fill = am4core.color("#FFFFFF");
		return;
	}

	if (!im.bool(data.tooltip.enabled)) {
		regionSeries.tooltip.disabled = true;
		return regionSeries;
	}

	//if it's overlay, it might have a custom config

	// tooltip settings from map config
	regionSeries.tooltip.label.interactionsEnabled = im.bool(tooltip.fixed);
	regionSeries.tooltip.background.cornerRadius = tooltip.cornerRadius;
	regionSeries.tooltip.getFillFromObject = false;
	regionSeries.tooltip.getStrokeFromObject = false;
	regionSeries.tooltip.label.fill = tooltip.color;
	regionSeries.tooltip.background.fill = tooltip.backgroundColor;
	regionSeries.tooltip.fontFamily = tooltip.fontFamily;
	regionSeries.tooltip.fontSize = tooltip.fontSize;
	regionSeries.tooltip.fontWeight = tooltip.fontWeight;

	// box-shadow

	if (typeof tooltip.customShadow !== 'undefined' && im.bool(tooltip.customShadow)) {
		shadow = regionSeries.tooltip.background.filters.getIndex(0);
		shadow.dx = tooltip.customShadowOpts.dx;
		shadow.dy = tooltip.customShadowOpts.dy;
		shadow.blur = tooltip.customShadowOpts.blur;
		shadow.opacity = tooltip.customShadowOpts.opacity;
		shadow.color = tooltip.customShadowOpts.color;
	}

	// Set up fixed tooltips
	if (im.bool(tooltip.fixed)) {
		if (regionSeries.mapPolygons) {
			regionSeries.calculateVisualCenter = true;
			regionSeries.mapPolygons.template.tooltipPosition = "fixed";
			regionSeries.tooltip.keepTargetHover = true;
		}
	}

	return regionSeries;
};

iMapsManager.setupHitEvents = function (id, ev) {
	var im = this,
		data = im.maps[id].data,
		dataContext,
		map = im.maps[id],
		customActionName,
		targetType = im.getTargetSeriesType(ev.target);

	if (ev.target.isLabels) {
		dataContext = ev.target.dataItems.first.dataContext;
	} else {
		dataContext = ev.target.dataItem.dataContext;
	}

	// for admin log
	im.populateClickInfo(dataContext);

	console.log(dataContext);

	// Zoom on click
	if (
		data.zoom &&
		im.bool(data.zoom.enabled) &&
		im.bool(data.zoom.zoomOnClick)
	) {
		ev.zooming = true;
		im.zoomToRegion(ev, id);
	}

	// drill down
	if (targetType === "MapPolygon" && im.bool(data.drillDownOnClick)) {
		im.drillDown(id, ev);
	}

	if (dataContext.madeFromGeoData) {
		iMapsManager.clearSelected(id);
		return;
	}

	// if admin, we don't trigger the actions
	if (im.bool(data.admin)) {
		return;
	}

	if (dataContext.action === "none") {
		// do nothing
	}
	// open new url
	else if (dataContext.action === "open_url" && dataContext.content !== "") {
		document.location = dataContext.content;
	} else if (
		dataContext.action === "open_url_new" &&
		dataContext.content !== ""
	) {
		window.open(dataContext.content);
	}

	// custom
	else if (dataContext.action && dataContext.action.includes("custom")) {
		customActionName = dataContext.action + "_" + id;

		if (typeof window[customActionName] !== "undefined") {
			window[customActionName](dataContext);
		}
	} else {

		if (typeof window[dataContext.action] !== "undefined") {
			window[dataContext.action](id, dataContext);
		}

	}
};

iMapsManager.zoomToRegion = function (ev, id) {
	var im = this,
		seriesType = im.getTargetSeriesType(ev.target),
		data = im.maps[id].data,
		dataContext;

	// do nothing if we clicked a label
	if (ev.target.isLabels) {
		return;
	}

	dataContext = ev.target.dataItem.dataContext;

	// if it's a marker, handle it differently
	if (seriesType == "MapImage") {
		// if it's a cluster marker, zoom to the max
		if (dataContext.cluster) {
			ev.target.series.chart.zoomToMapObject(
				ev.target,
				data.clusterMarkers.zoomLevel
			);
		} else {
			ev.target.series.chart.zoomToMapObject(ev.target);
		}
	} else {
		if (dataContext.id === "asia") {
			ev.target.series.chart.deltaLongitudeOriginal = ev.target.series.chart.deltaLongitude;
			ev.target.series.chart.deltaLongitude = -10;
			ev.target.series.chart.zoomToGeoPoint(
				{
					latitude: 34.076842,
					longitude: 100.693068
				},
				1.7,
				true
			);
		} else {
			if (typeof ev.target.series.chart.deltaLongitudeOriginal !== 'undefined') {
				ev.target.series.chart.deltaLongitude = ev.target.series.chart.deltaLongitude;
			}
			ev.target.series.chart.zoomToMapObject(
				ev.target,
				ev.target.zoomLevel * 2
			);
		}
	}
};

iMapsManager.setupHoverEvents = function (id, ev) {

	var im = this,
		selected = im.maps[id].selected || false,
		dataContext;

	if (ev.target.isLabels) {
		dataContext = ev.target.dataItems.first.dataContext;
	} else {
		dataContext = ev.target.dataItem.dataContext;
	}

	if (dataContext.action && dataContext.action != "none") {
		ev.target.cursorOverStyle = am4core.MouseCursorStyle.pointer;
	}

	if (Array.isArray(selected) && !selected.includes(ev.target)) {
		selected.forEach(function (sel, index) {
			sel.isHover = false;
		});
	}
};

iMapsManager.singleHit = function (id, ev) {
	var im = this,
		selected = im.maps[id].selected || false,
		dataContext;

	if (ev.target.isLabels) {
		dataContext = ev.target.dataItems.first.dataContext;
	} else {
		dataContext = ev.target.dataItem.dataContext;
	}

	if (dataContext.madeFromGeoData) {
		return;
	}

	iMapsManager.clearSelected(id);

	ev.target.isActive = true;
	ev.target.isHover = true;
	ev.target.setState("active");

	im.maps[id].selected = [ev.target];
};

iMapsManager.groupHit = function (id, ev) {
	var im = this,
		selected = im.maps[id].selected || false;

	if (ev.target.dataItem.dataContext.madeFromGeoData) {
		return;
	}

	iMapsManager.clearSelected(id);

	selected = [];

	ev.target.parent.mapPolygons.each(function (polygon) {
		if (!polygon.dataItem.dataContext.madeFromGeoData) {
			// toggle active state
			polygon.setState("active");
			polygon.isActive = true;
			polygon.isHover = true;
			selected.push(polygon);
		}
	});

	im.maps[id].selected = selected;
};

iMapsManager.groupHover = function (id, ev) {
	if (ev.target.dataItem.dataContext.madeFromGeoData) {
		return;
	}

	// set mouse hover pointer cursor
	if (ev.target.dataItem.dataContext.action && ev.target.dataItem.dataContext.action != "none") {
		ev.target.cursorOverStyle = am4core.MouseCursorStyle.pointer;
	}

	// hilight all polygons from this group
	ev.target.parent.mapPolygons.each(function (polygon) {
		if (!polygon.dataItem.dataContext.madeFromGeoData) {
			polygon.setState("highlight");
		}
	});
};

iMapsManager.groupHoverOut = function (id, ev) {
	if (ev.target.dataItem.dataContext.madeFromGeoData) {
		return;
	}

	ev.target.parent.mapPolygons.each(function (polygon) {
		if (!polygon.isActive) {
			polygon.setState("default");
		}
	});
};

/**
 * Selects a element in the map
 * id - id of the map
 * elID - id of the element to select
 */
iMapsManager.select = function (id, elID) {
	var im = this,
		map = im.maps[id],
		selected = map.selected || false,
		series = map.series,
		select;

	if (Array.isArray(selected)) {
		selected.forEach(function (sel, index) {
			sel.isHover = false;
			sel.isActive = false;
			sel.setState("default");
		});
	}

	if (Array.isArray(series)) {
		for (var i = 0, len = series.length; i < len; i++) {
			// regionSeries
			if (series[i].mapPolygons) {
				select = series[i].getPolygonById(elID);
				if (select) {
					select.dispatchImmediately("hit");
				}
			}
			// imageSeries
			if (series[i].mapImages) {
				select = series[i].getImageById(elID);
				if (select) {
					select.dispatchImmediately("hit");
				}
			}
		}
	}

	return select;
};

iMapsManager.setupHeatMap = function (series, id) {
	var im = this,
		map = im.maps[id].map,
		data = im.maps[id].data,
		heatLegend,
		minRange,
		maxRange,
		target,
		minProp,
		maxProp,
		propTargets,
		dataSource,
		seriesType = im.getTargetSeriesType(series);

	// setup target
	if (seriesType === "MapImageSeries") {
		target = series.mapImages.template.children.values[0];
		propTargets = ["fill", "radius"];
		dataSource = data.heatMapMarkers;
	} else if (seriesType === "MapPolygonSeries") {
		target = series.mapPolygons.template;
		propTargets = ["fill"];
		dataSource = data.heatMapRegions;
	} else {
		return;
	}

	if (!Array.isArray(propTargets)) {
		propTargets = [propTargets];
	}

	propTargets.map(function (prop) {
		// setup min/max sources
		if (prop === "fill") {
			minProp = dataSource.minColor;
			maxProp = dataSource.maxColor;
		} else if (prop === "radius") {
			minProp = dataSource.minRadius;
			maxProp = dataSource.maxRadius;
		}

		series.heatRules.push({
			property: prop,
			target: target,
			min: minProp,
			max: maxProp,
			dataField: dataSource.source
		});
	});

	if (im.bool(dataSource.legend)) {
		heatLegend = map.createChild(am4maps.HeatLegend);
		heatLegend.series = series;
		heatLegend.align = "right";
		heatLegend.valign = "bottom";
		heatLegend.width = am4core.percent(20);
		heatLegend.marginRight = am4core.percent(4);
		heatLegend.minValue = 0;
		heatLegend.maxValue = 999999;

		// Set up custom heat map legend labels using axis ranges
		minRange = heatLegend.valueAxis.axisRanges.create();
		minRange.value = heatLegend.minValue;
		minRange.label.text = dataSource.minLabel;
		maxRange = heatLegend.valueAxis.axisRanges.create();
		maxRange.value = heatLegend.maxValue;
		maxRange.label.text = dataSource.maxLabel;

		// Blank out internal heat legend value axis labels
		heatLegend.valueAxis.renderer.labels.template.adapter.add(
			"text",
			function () {
				return "";
			}
		);
	}
};

iMapsManager.drillDown = function (id, ev) {
	var im = iMapsManager,
		mapName = iMapsRouter.iso2cleanName(ev.target.dataItem.dataContext.id),
		targetID = ev.target.dataItem.dataContext.id,
		allCurrentSeries = iMapsManager.maps[id].series,
		currentRegion = iMapsManager.maps[id].seriesIndex[mapName],
		baseSeries = iMapsManager.maps[id].baseSeries,
		allBaseSeries = iMapsManager.maps[id].allBaseSeries,
		i,
		len;

	console.log(mapName);
	console.log(iMapsManager.maps[id].seriesIndex);

	// check if geofile info exists or return if the id is numeric
	if (!mapName || !isNaN(targetID)) {
		return false;
	}

	if (ev.target.polygon) {
		// check if series exists for this map
		if (Array.isArray(iMapsManager.maps[id].seriesIndex[mapName])) {
			// hide all others except this one and baseSeries
			for (i = 0, len = allCurrentSeries.length; i < len; i++) {
				if (baseSeries === allCurrentSeries[i]) {
					allCurrentSeries[i].opacity = 0.3;
				} else {
					allCurrentSeries[i].hide();
				}
			}
			for (i = 0, len = currentRegion.length; i < len; i++) {
				currentRegion[i].show();
			}

			// is drilling
			iMapsManager.maps[id].isDrilling = true;

			// zoom to region
			if (!ev.zooming) {
				im.zoomToRegion(ev, id);
			}
		} else {
			// if the target is part of current series, do nothing
			if (currentRegion === ev.target.series) {
				iMapsManager.maps[id].isDrilling = false;
				return;
			}
			// if target is base series, show it
			if (ev.target.series === baseSeries) {
				iMapsManager.maps[id].isDrilling = false;
				// hide all except baseSeries
				for (i = 0, len = allCurrentSeries.length; i < len; i++) {
					if (allBaseSeries.includes(allCurrentSeries[i])) {
						allCurrentSeries[i].show();
					} else {
						allCurrentSeries[i].hide();
					}
				}
			}
		}
	}
};

/*HELPERS*/
iMapsManager.getSelected = function (id) {
	var im = this,
		map = im.maps[id],
		selected = map.selected || false;
	if (selected) {
		return selected.dataItem.dataContext;
	} else {
		return false;
	}
};

iMapsManager.clearSelected = function (id) {
	var im = this,
		map = im.maps[id],
		selected = map.selected || [];

	if (Array.isArray(selected) && selected.length > 0) {
		selected.forEach(function (polygon, index) {
			polygon.isHover = false;
			polygon.isActive = false;
			polygon.setState("default");
		});

		selected = [];
	}

	return selected;
};

/*
 * setup hover events
 * id - id of the map
 * eID - hovered element ID
 */
iMapsManager.hover = function (id, eID) {
	var im = this,
		map = im.maps[id],
		data = map.data,
		series = map.series,
		hovered = map.hovered || false,
		hover;

	if (hovered) {
		hovered.isHover = false;
		hovered.setState("default");
	}

	if (Array.isArray(series)) {
		for (var i = 0, len = series.length; i < len; i++) {
			// regionSeries
			if (series[i].mapPolygons) {
				hover = series[i].getPolygonById(eID);
				if (hover) {
					map.hovered = hover;
					hover.dispatchImmediately("over");
					hover.isHover = true;
				}
			}
			// imageSeries
			if (series[i].mapImages) {
				hover = series[i].getImageById(eID);
				if (hover) {
					map.hovered = hover;
					hover.dispatchImmediately("over");
					hover.isHover = true;
				}
			}
		}
	}

	return hover;
};

iMapsManager.clearHovered = function (id, eID) {
	var im = this,
		map = im.maps[id],
		hovered = map.hovered || false,
		series = map.series,
		hover;

	eID = eID || false;

	if (eID) {
		if (Array.isArray(series)) {
			for (var i = 0, len = series.length; i < len; i++) {
				// regionSeries
				if (series[i].mapPolygons) {
					hover = series[i].getPolygonById(eID);
					if (hover) {
						hover.dispatchImmediately("out");
						hover.isHover = false;
					}
				}
				// imageSeries
				if (series[i].mapImages) {
					hover = series[i].getImageById(eID);
					if (hover) {
						hover.dispatchImmediately("out");
						hover.isHover = false;
					}
				}
			}
		}
	}

	if (hovered) {
		hovered.isHover = false;
		hovered = false;

		return true;
	}

	return false;
};

iMapsManager.getTargetSeriesType = function (el) {
	var className = el.className;
	return className;
};

/**
 * Setups clustered series based on coordinate values from data
 */
iMapsManager.setupClusters = function (data, id) {
	var im = this,
		map = im.maps[id],
		series = [],
		markerSeries,
		tempData = {},
		biasLevels = [],
		zoomLevels = [],
		biasSteps = 4,
		i = 0,
		prevBias = parseFloat(data.clusterMarkers.maxBias),
		maxZoomLevel = parseFloat(data.clusterMarkers.zoomLevel) || 20;

	while (i <= biasSteps) {
		biasLevels.push(prevBias);
		prevBias = prevBias / 2;

		zoomLevels.push(maxZoomLevel);
		maxZoomLevel = Math.ceil(maxZoomLevel / 2);

		i++;
	}

	// reverse array to match detail level
	zoomLevels.reverse().pop();
	biasLevels.pop();

	if (Array.isArray(data.roundMarkers)) {
		biasLevels.forEach(function (item, index) {
			series = geocluster(data.roundMarkers, item, data.markerDefaults);

			tempData = Object.assign({}, data);
			tempData.roundMarkers = series;

			markerSeries = im.pushRoundMarkerSeries(id, tempData);

			markerSeries.name = tempData.title || "Map";
			markerSeries.hiddenInLegend = true;
			map.clusterSeries[zoomLevels[index]] = markerSeries;

			if (index === 0) {
				im.maps[id].allBaseSeries.push(markerSeries);
			}
			markerSeries.hidden = true;
		});
	}
	return true;
};

/**
 * Adds a new region Series currently not loaded, adding the script to the body of the page and creating a new series after
 * id - map id to attach series
 * dataContent - object with data that would tipically be a polygon dataContent, like name and id
 * config - config object for the new series being added
 *
 * @return newSeries - the new created series object
 */
iMapsManager.addGeoFileSeries = function (id, dataContext, data) {
	var newSeries,
		geoFiles = iMapsRouter.getGeoFiles(dataContext);
	var scriptPromise = new Promise(function (resolve, reject) {
		var script = document.createElement("script");
		document.body.appendChild(script);
		script.onload = resolve;
		script.onerror = reject;
		script.async = true;
		script.src = geoFiles.src;
	});

	scriptPromise.then(function () {
		var data = {
			title: geoFiles.title,
			map: geoFiles.map,
			regions: [],
			config: data // not working, we changed the config to be at parent level with data
		};

		iMapsManager.maps[id].seriesIndex[geoFiles.map] = [];
		newSeries = iMapsManager.pushRegionSeries(id, data);
		iMapsManager.maps[id].seriesIndex[geoFiles.map].push(newSeries);

		return newSeries;
	});

	return false;
};

iMapsManager.handleInfoBox = function (id) {
	var im = this,
		map = im.maps[id].map,
		events = ["ready", "mappositionchanged", "zoomlevelchanged"],
		container = document.getElementById("map_tech_info"),
		coordinatesc = document.getElementById("map_click_events_coordinates"),
		series = im.maps[id].series;

	if (container) {
		iMapsManager.populateInfo(id, container);

		// zoom, etc
		events.forEach(function (event) {
			map.events.on(
				event,
				function (ev) {
					iMapsManager.populateInfo(id, container);
				},
				this
			);
		});
	}

	if (coordinatesc) {
		map.events.on(
			"hit",
			function (ev) {

				var coordinates = map.svgPointToGeo(ev.svgPoint);
				var lat = Number(coordinates.latitude).toFixed(6);
				var long = Number(coordinates.longitude).toFixed(6);

				// latitude
				var latEl = document.createElement('div');
				var latLabelEl = document.createElement('span');
				var latValueEl = document.createElement('span');
				latValueEl.classList.add('map_clicked_lat');
				latLabelEl.innerHTML = 'LAT: ';
				latValueEl.innerHTML = lat;
				latEl.appendChild(latLabelEl);
				latEl.appendChild(latValueEl);

				// longitude
				var longEl = document.createElement('div');
				var longLabelEl = document.createElement('span');
				var longValueEl = document.createElement('span');
				longValueEl.classList.add('map_clicked_long');
				longLabelEl.innerHTML = 'LON: ';
				longValueEl.innerHTML = long;
				longEl.appendChild(longLabelEl);
				longEl.appendChild(longValueEl);

				coordinatesc.innerHTML = '';
				coordinatesc.appendChild(latEl);
				coordinatesc.appendChild(longEl);


				var event = new CustomEvent("mapPointClicked", { detail: { latitude: lat, longitude: long } });

				document.dispatchEvent(event);

			},
			this
		);
	}
};

iMapsManager.populateInfo = function (id, container) {
	var im = this,
		map = im.maps[id].map,
		info = "";

	info +=
		"Zoom Level: " + parseFloat(Number(map.zoomLevel).toFixed(2)) + "<br>";
	info +=
		"Center Coordinates: <br>" +
		"LAT " +
		Number(map.zoomGeoPoint.latitude).toFixed(6) +
		"<br>" +
		"LONG " +
		Number(map.zoomGeoPoint.longitude).toFixed(6) +
		"<br>";

	container.innerHTML = info;
};

iMapsManager.populateClickInfo = function (data) {
	var container = document.getElementById("map_click_events_info"),
		info = "";

	if (container && data) {
		info += "ID: " + data.id + "<br>";
		if (data.name) {
			info += "Name: " + data.name + "<br>";
		}
		if (data.latitude) {
			info += "LAT: " + Number(data.latitude).toFixed(6) + "<br>";
			info += "LONG: " + Number(data.longitude).toFixed(6) + "<br>";
		}

		if (data.action) {
			info += "Action: " + data.action.replace("igm_", "") + "<br>";
		}

		container.innerHTML = info;
	}
};

/** Util function to return boolean value of string */
iMapsManager.bool = function (string) {
	var bool = Number(string) === 0 || string === "false" || typeof string === "undefined" ? false : true;
	return bool;
};

iMapsManager.isJSON = function (str) {
	try {
		JSON.parse(str);
	} catch (e) {
		return false;
	}
	return true;
};

/* Closest Polyfill */
if (!Element.prototype.matches) {
	Element.prototype.matches = Element.prototype.msMatchesSelector ||
		Element.prototype.webkitMatchesSelector;
}

if (!Element.prototype.closest) {
	Element.prototype.closest = function (s) {
		var el = this;

		do {
			if (el.matches(s)) return el;
			el = el.parentElement || el.parentNode;
		} while (el !== null && el.nodeType === 1);
		return null;
	};
}


