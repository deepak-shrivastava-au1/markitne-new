/**
 * File that contains functions to prepare raw data that arrives in a javascript variable.
 * 1) Convert color strings to color objects
 * */

var iMapsModel = {};

iMapsModel.prepareData = function (fullData) {

	if (!fullData) {
		return fullData;
	}

	if (!Array.isArray(fullData)) {
		return fullData;
	}

	fullData.forEach(function (data, index) {
		fullData[index] = iMapsModel.iterateData(data);

		if (
			Array.isArray(fullData[index].overlay) &&
			fullData[index].overlay.length > 0
		) {
			fullData[index].overlay.forEach(function (odata, ind) {
				if (fullData[index].overlay[ind].map === fullData[index].map) {
					fullData[index].overlay[
						ind
					].include = iMapsModel.prepareOverlayInclude(odata);
				}

				fullData[index].overlay[ind] = iMapsModel.iterateData(odata);
			});
		}
	});

	return fullData;
};

iMapsModel.prepareOverlayInclude = function (data) {
	var includes = data.includes || "";
	if (data.regions) {
		data.regions.forEach(function (region, index) {
			includes += "," + region.id;
		});
	}
	return includes;
};

iMapsModel.iterateData = function (data) {
	// create color objects
	data = iMapsModel.prepareColor(data);
	// convert exclude and includes to array
	data = iMapsModel.prepareExcludeIncludes(data);
	// convert coordinates to int
	data = iMapsModel.coordinatesToInt(data);
	// prepare entries that use defaults
	data = iMapsModel.prepareEntriesData(data);
	// prepare grouped regions
	data = iMapsModel.prepareGroupedRegions(data);
	//extract image source from imageMarkers
	data = iMapsModel.prepareImageFields(data);
	//prepare lines multiGeoLine format
	data = iMapsModel.prepareMultiGeoLine(data);

	return data;
};

iMapsModel.prepareMultiGeoLine = function (data) {
	if (Array.isArray(data.lines) && data.lines.length) {
		data.lines.map(function (line) {
			line.multiGeoLine.map(function (geoLine) {
				Object.assign(geoLine, geoLine.coordinates);
				delete geoLine.coordinates;
			});
		});
	}

	return data;
};

iMapsModel.prepareImageFields = function (data) {
	// image markers
	if (Array.isArray(data.imageMarkers) && data.imageMarkers.length) {
		data.imageMarkers.map(function (marker) {
			if (marker.image) {
				marker.href = marker.image.url;
			}
			return marker;
		});
	}

	return data;
};

iMapsModel.prepareGroupedRegions = function (data) {
	var regions, tempRegion, group;

	// regions
	if (Array.isArray(data.regions) && data.regions.length) {
		data.regions.map(function (region, index) {
			if (region.id && region.id.includes(",")) {

				// remove this region form the default regions data set
				data.regions.splice(index, 1);

				group = [];

				regions = region.id.split(",");
				regions.forEach(function (reg, index) {
					// let's just keep the first in this current region index
					/*
					if (index === 0) {
						region.id = reg.trim();
						return region;
					}*/
					tempRegion = Object.assign({}, region);
					tempRegion.id = reg.trim();
					tempRegion.originalID = region.id;
					group.push(tempRegion);
				});

				//to add it normally as the other regions
				//data.regions.push(tempRegion);

				//or add it to a specific array to be handled in a specific way


				// add group to main data object, but check if it's defined
				if (typeof data.regionGroups === 'undefined') {
					data.regionGroups = [];
				}
				// finally add it to the main data object
				data.regionGroups.push(group);

			} else {
				return region;
			}

		});
	}
	return data;
};

iMapsModel.prepareTooltip = function (tooltipContent, options) {

	var maxWidth, isIE11, images, tooltipNode, range, tempDiv;

	if (typeof options === 'undefined' || typeof tooltipContent === 'undefined') {
		return tooltipContent;
	}

	maxWidth = typeof options.maxWidth !== "undefined" && options.maxWidth !== '' ? parseInt(options.maxWidth) : false;
	isIE11 = !!window.MSInputMethodContext && !!document.documentMode;

	// remove html tags for IE
	if (isIE11) {
		return iMapsModel.removeHTMLtags(tooltipContent);
	}

	// check for images
	if (tooltipContent.includes("<img")) {
		// images
		range = document.createRange();
		// Make the parent of the first div in the document becomes the context node
		range.selectNode(document.getElementsByTagName("div").item(0));
		var tooltipNode = range.createContextualFragment(tooltipContent);

		images = tooltipNode.querySelectorAll('img');

		if (images.length > 0) {

			images.forEach(function (img) {

				if (img.width !== 0 && img.style.width === '') {
					img.style.width = img.width + 'px';
				}

				if (img.height !== 0 && img.style.height === '') {
					img.style.height = img.height + 'px';
				}

			});

			tempDiv = document.createElement('div');
			tempDiv.appendChild(tooltipNode.cloneNode(true));
			tooltipContent = tempDiv.innerHTML;

		}
	}

	// tooltip
	if (maxWidth && tooltipContent !== '' && !isIE11) {
		tooltipContent = '<div class="imapsInnerTooltip" style="max-width:' + maxWidth + 'px">' + tooltipContent + '</div>';
	}

	return tooltipContent;

};

iMapsModel.removeHTMLtags = function (str) {

	if ((str === null) || (str === ''))
		return false;
	else
		str = str.toString();
	return str.replace(/<[^>]*>/g, '');
};

iMapsModel.prepareEntriesData = function (data) {

	if (data.heatMapMarkers && data.heatMapMarkers.enabled === "1") {
		data.heatMapMarkers.minRadius = parseInt(data.heatMapMarkers.minRadius);
		data.heatMapMarkers.maxRadius = parseInt(data.heatMapMarkers.maxRadius);
	}

	var mapID = data.id;

	// regions
	if (Array.isArray(data.regions) && data.regions.length) {
		data.regions.map(function (region) {
			if (
				typeof region.useDefaults === "undefined" ||
				region.useDefaults === "1"
			) {
				Object.assign(region, data.regionDefaults);
			}

			if (data.heatMapRegions && data.heatMapRegions.enabled === "1") {
				region.value = parseInt(region.value);
				delete region.fill;
			}

			// default action
			if (region.action === "default") {
				region.action = data.regionDefaults.action;
			}

			// border hover - currently doesn't exist
			if (
				typeof data.visual.borderColorHover !== "undefined" &&
				data.visual.borderColorHover !== data.visual.borderColor
			) {
				region.borderColorHover = data.visual.borderColorHover;
			}

			// border width on hover - currently doesn't exist
			if (
				typeof data.visual.borderWidthHover !== "undefined" &&
				data.visual.borderWidthHover !== data.visual.borderWidth
			) {
				region.borderWidthHover = data.visual.borderWidthHover;
			}

			region.tooltipContent = iMapsModel.prepareTooltip(region.tooltipContent, data.tooltip);
			region.mapID = mapID;

			return region;
		});
	}

	// round markers
	if (Array.isArray(data.roundMarkers) && data.roundMarkers.length) {
		data.roundMarkers.map(function (marker) {
			if (
				typeof marker.useDefaults === "undefined" ||
				marker.useDefaults === "1"
			) {
				Object.assign(marker, data.markerDefaults);
			}

			if (marker.coordinates) {
				Object.assign(marker, marker.coordinates);
				delete marker.coordinates;
			}

			// set name to be id
			marker.name = marker.id;

			if (data.heatMapRegions && data.heatMapMarkers.enabled === "1") {
				marker.value = parseInt(marker.value);
				delete marker.fill;
				delete marker.radius;
			}

			// default action
			if (marker.action === "default") {
				marker.action = data.markerDefaults.action;
			}

			marker.tooltipContent = iMapsModel.prepareTooltip(marker.tooltipContent, data.tooltip);
			marker.mapID = mapID;

			return marker;
		});
	}

	// icon markers
	if (Array.isArray(data.iconMarkers) && data.iconMarkers.length) {
		data.iconMarkers.map(function (marker) {
			if (
				typeof marker.useDefaults === "undefined" ||
				marker.useDefaults === "1"
			) {
				Object.assign(marker, data.iconMarkerDefaults);
			}
			if (marker.coordinates) {
				Object.assign(marker, marker.coordinates);
				delete marker.coordinates;
			}

			// set name to be id
			marker.name = marker.id;

			// default action
			if (marker.action === "default") {
				marker.action = data.iconMarkerDefaults.action;
			}

			marker.tooltipContent = iMapsModel.prepareTooltip(marker.tooltipContent, data.tooltip);
			marker.mapID = mapID;

			return marker;
		});
	}

	// image markers
	if (Array.isArray(data.imageMarkers) && data.imageMarkers.length) {
		data.imageMarkers.map(function (marker) {
			if (
				typeof marker.useDefaults === "undefined" ||
				marker.useDefaults === "1"
			) {
				Object.assign(marker, data.imageMarkerDefaults);
			}
			if (marker.coordinates) {
				Object.assign(marker, marker.coordinates);
				delete marker.coordinates;
			}

			// set name to be id
			marker.name = marker.id;

			if (marker.action === "default") {
				marker.action = data.imageMarkerDefaults.action;
			}
			marker.tooltipContent = iMapsModel.prepareTooltip(marker.tooltipContent, data.tooltip);
			marker.mapID = mapID;

			return marker;

		});
	}

	// labels
	if (Array.isArray(data.labels) && data.labels.length) {
		data.labels.map(function (label) {
			var region, partialRegion;

			if (
				typeof label.useDefaults === "undefined" ||
				label.useDefaults === "1"
			) {
				Object.assign(label, data.labelDefaults);
			}
			if (label.coordinates) {
				Object.assign(label, label.coordinates);
				delete label.coordinates;
			}

			if (label.action === "default") {
				label.action = data.labelDefaults.action;
			}

			label.tooltipContent = iMapsModel.prepareTooltip(label.tooltipContent, data.tooltip);
			marker.mapID = mapID;

			return label;
		});
	}

	// lines
	if (Array.isArray(data.lines) && data.lines.length) {
		data.lines.map(function (line) {
			if (typeof line.useDefaults === "undefined" || line.useDefaults === "1") {
				Object.assign(line, data.lineDefaults);
			}
			line.curvature = parseFloat(line.curvature);
			return line;
		});
	}

	return data;
};

iMapsModel.prepareExcludeIncludes = function (data) {
	if (
		data.exclude &&
		typeof data.exclude === "string" &&
		data.exclude.trim().length
	) {
		data.exclude = data.exclude.split(",").map(function (item) {
			return item.trim();
		});
	}

	if (data.include && data.include.length) {
		data.include = data.include.split(",").map(function (item) {
			return item.trim();
		});
	}

	return data;
};

iMapsModel.coordinatesToInt = function (data) {
	var convertCoordinates = function (key, obj) {
		obj[key].latitude = Number(obj[key].latitude);
		obj[key].longitude = Number(obj[key].longitude);
	},
		iterateObj = function (Obj) {
			if (typeof Obj !== "object" || Obj === null) {
				return;
			}
			Object.keys(Obj).map(function (key, index) {
				if (typeof Obj[key] === "object") {
					if (key === "coordinates" || key === "homeGeoPoint") {
						convertCoordinates(key, Obj);
					} else {
						iterateObj(Obj[key]);
					}
				}
			});
		};

	iterateObj(data);
	return data;
};

iMapsModel.prepareColor = function (data) {
	// prepare color fields
	var colorFields = [
		"inactiveColor",
		"activeColor",
		"hoverColor",
		"hover",
		"inactiveHoverColor",
		"backgroundColor",
		"color",
		"minColor",
		"maxColor",
		"fill",
		"projectionBackgroundColor",
		"borderColor",
		"borderColorHover"
	],
		checkColor = function (key, obj) {
			if (colorFields.includes(key)) {
				if (obj[key] === "transparent") {
					obj[key] = am4core.color("#f00", 0);
				} else {
					obj[key] = am4core.color(obj[key]);
				}
			}
		},
		iterateObj = function (Obj) {
			if (typeof Obj !== "object" || Obj === null) {
				return;
			}
			Object.keys(Obj).map(function (key, index) {
				if (typeof Obj[key] === "object") {
					iterateObj(Obj[key]);
				} else {
					checkColor(key, Obj);
				}
			});
		};

	iterateObj(data);

	return data;
};

/**
 * Retrives object with region codes and names from geojson
 */
iMapsModel.extractCodes = function (data) {
	var obj = {};
	for (var i = 0; i < data.features.length; i++) {
		obj[data.features[i].properties.id] = data.features[i].properties.name;
	}
	return obj;
};
