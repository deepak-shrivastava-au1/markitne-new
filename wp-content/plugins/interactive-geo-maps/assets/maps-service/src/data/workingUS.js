var iMapsData = [
	{
		description: "World map done in the new plugin",
		map: "usaLow",
		mapURL: "https://www.amcharts.com/lib/4/geodata/json/usaLow.json",
		projection: "Miller",
		grid: { color: "#cccccc", projectionBackgroundColor: "#cccccc" },
		zoom: {
			enabled: "0",
			controls: "1",
			controlsPosition: { align: "left", valign: "bottom" },
			doubleHitZoom: "1",
			draggable: "1",
			wheelable: "1",
			zoomOnClick: "1"
		},
		viewport: {
			zoomLevel: "1",
			homeGeoPoint: { title: "", latitude: "", longitude: "" },
			offset: { latitude: "0", longitude: "0" }
		},
		legend: {
			enabled: "",
			clickable: "",
			position: "bottom",
			align: "left",
			valign: "bottom"
		},
		exportMenu: { enable: "" },
		visual: {
			backgroundColor: "#0984e3",
			borderColor: "#dd9933",
			borderWidth: "1",
			fontFamily: "inherit"
		},
		tooltip: {
			enabled: "1",
			fixed: "",
			backgroundColor: "#FFFFFF",
			color: "#000000",
			fontFamily: "inherit",
			fontSize: "",
			fontWeight: "normal",
			cornerRadius: "20",
			template: "{tooltipContent}"
		},
		regions: [
			{
				title: "Cali",
				id: "US-CA",
				tooltipContent: "California",
				useDefaults: "1",
				fill: "",
				hover: "",
				action: "default",
				content: "",
				value: ""
			},
			{
				title: "Texas",
				id: "US-TX",
				tooltipContent: "tes",
				useDefaults: "1",
				fill: "",
				hover: "",
				action: "default",
				content: "",
				value: ""
			}
		],
		regionDefaults: {
			fill: "#dd3333",
			hover: "#81d742",
			inactiveColor: "#eeee22",
			action: "none",
			customAction: ""
		},
		heatMapRegions: {
			enabled: "",
			minColor: "#f5f5f5",
			maxColor: "#333333",
			legend: "",
			minLabel: "Min",
			maxLabel: "Max",
			source: "value"
		},
		include: "",
		exclude: "AQ,US",
		showRegionsInLegend: "0",
		regionLegendTitle: "",
		autoRegionLabels: "{id}",
		roundMarkers: [
			{
				id: "Alaska ",
				coordinates: {
					title: "Alaska",
					latitude: "64.2008413",
					longitude: "-149.4936733"
				},
				tooltipContent: "hey you! ",
				useDefaults: "1",
				radius: "10",
				fill: "",
				hover: "",
				action: "default",
				content: "",
				value: ""
			}
		],
		markerDefaults: {
			radius: "10",
			fill: "#dd3333",
			hover: "#dd3333",
			action: "none"
		},
		heatMapMarkers: {
			enabled: "",
			minRadius: "8",
			maxRadius: "25",
			minColor: "#f5f5f5",
			maxColor: "#333333",
			legend: "",
			minLabel: "Min",
			maxLabel: "Max",
			source: "value"
		},
		clusterMarkers: { enabled: "", zoomLevel: "5", maxBias: "0.5" },
		showRoundMarkersInLegend: "",
		roundMarkersLegendTitle: "",
		imageMarkerDefaults: {
			image: {
				url: "",
				id: "",
				width: "",
				height: "",
				thumbnail: "",
				alt: "",
				title: "",
				description: ""
			},
			size: "20",
			horizontalCenter: "left",
			verticalCenter: "top",
			action: "none"
		},
		showImageMarkersInLegend: "",
		imageMarkersLegendTitle: "",
		iconMarkerDefaults: {
			icon: "fa fa-star",
			horizontalCenter: "left",
			verticalCenter: "top",
			scale: "1",
			fill: "",
			hover: "",
			action: "none"
		},
		showIconMarkersInLegend: "",
		iconMarkersLegendTitle: "",
		labelDefaults: { fontSize: "15", fill: "", hover: "", action: "none" },
		labelPosition: { horizontalCenter: "middle", verticalCenter: "middle" },
		labelStyle: { fontFamily: "inherit", fontWeight: "normal" },
		showLabelsInLegend: "",
		labelsLegendTitle: "",
		lineDefaults: {
			stroke: "#CCC",
			strokeDash: "2",
			strokeWidth: "6",
			curvature: "0"
		},
		showLinesInLegend: "",
		linesLegendTitle: "",
		drillDownOnClick: "",
		groupHover: "",
		custom_css: "",
		custom_js: "",
		regions_info: "",
		roundMarkers_info: "",
		imageMarkers_info: "",
		imageMarkers: "",
		iconMarkers_info: "",
		iconMarkers: "",
		labels: "",
		lines_info: "",
		lines: "",
		overlay: "",
		id: "169",
		container: "map_169",
		title: "US Map",
		urls: { usaLow: "https://www.amcharts.com/lib/4/geodata/usaLow.js" }
	}
];
