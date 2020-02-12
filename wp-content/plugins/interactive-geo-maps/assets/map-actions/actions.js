/**
 * Display content below the map
 */
function igm_display_below(id, data) {
	iMapsActions.contentBelow(id, data, false);
}

/**
 * Display content below the map and scroll
 */
function igm_display_below_scroll(id, data) {
	iMapsActions.contentBelow(id, data, true);
}

/**
 * Display content above the map
 */
function igm_display_above(id, data) {
	iMapsActions.contentAbove(id, data, false);
}

/**
 * Display post or page below
 */
function igm_display_post_below(id, data) {
	iMapsActions.postBelow(id, data, false);
}

/**
 * Display content to the right of the map with 1/3 space
 */
function igm_display_right_1_3(id, data) {
	iMapsActions.contentRight(
		id,
		data,
		"igm_content_left_2_3",
		"igm_content_right_1_3"
	);
}

/**
 * lightbox functions
 */
function igm_lightbox(id, data) {
	iMapsActions.lightboxAction(id, data, "inline");
}

function igm_lightbox_image(id, data) {
	iMapsActions.lightboxAction(id, data, "image");
}

function igm_lightbox_iframe(id, data) {
	iMapsActions.lightboxAction(id, data, "external");
}

iMapsActions = {};
iMapsActions.lightbox = false;
iMapsActions.lightboxAction = function (id, data, type) {
	var elements = [],
		width = iMapsActionOptions.lightboxWidth,
		height = iMapsActionOptions.lightboxHeight;

	if (type === "inline") {

		data.content = iMapsActions.getIDfromData(data);

		elements.push({
			href: data.content,
			type: type,
			width: width,
			height: height
		});
	} else if (type === "external") {

		// iframe
		if (height === 'auto') {
			height = window.innerHeight * 0.8;
		}

		elements.push({
			href: data.content,
			type: type,
			width: width,
			height: height
		});
	} else {
		elements.push({
			href: data.content,
			type: type,
			width: width,
			height: height
		});
	}

	if (!iMapsActions.lighbox) {
		iMapsActions.lightbox = GLightbox({
			touchNavigation: true,
			loopAtEnd: true,
			elements: elements,
			closeButton: true,
		});
	}

	iMapsActions.lightbox.open();
};
iMapsActions.contentBelow = function (id, data, scroll) {
	// go 2 steps up to find map wrapper.
	var originalTop,
		what2display,
		what2hide,
		mapContainer = document.getElementById("map_" + id).parentNode.parentNode
			.parentNode,
		mapContentContainer = mapContainer.parentNode.querySelector(
			".igm_content_below"
		),
		footerContent = document.getElementById("igm-hidden-footer-content");

	data.content = iMapsActions.getIDfromData(data);

	if (mapContentContainer === null) {
		mapContentContainer = document.createElement("div");
		mapContentContainer.classList.add("igm_content_below");

		mapContainer.parentNode.insertBefore(
			mapContentContainer,
			mapContainer.nextSibling
		);
	}

	// hide
	what2hide = mapContentContainer.firstChild;
	if (what2hide) {
		what2hide.style.display = 'none';
		footerContent.appendChild(what2hide);
	}

	// display this
	what2display = document.querySelector(data.content);
	console.log('what2display', what2display, data.content);
	if (what2display) {

		mapContentContainer.appendChild(what2display);
		what2display.style.display = 'block';
	}

	if (scroll) {
		originalTop = Math.floor(
			mapContentContainer.getBoundingClientRect().top - 100
		);
		window.scrollBy({ top: originalTop, left: 0, behavior: "smooth" });
	}
};

iMapsActions.contentAbove = function (id, data, scroll) {
	// go 2 steps up to find map wrapper.
	var mapContainer = document.getElementById("map_" + id).parentNode.parentNode
		.parentNode,
		mapContentContainer = mapContainer.parentNode.querySelector(
			".igm_content_above"
		),
		what2display,
		what2hide,
		footerContent = document.getElementById("igm-hidden-footer-content");

	iMapsActions.getIDfromData(data)


	if (mapContentContainer === null) {
		mapContentContainer = document.createElement("div");
		mapContentContainer.classList.add("igm_content_above");

		mapContainer.parentNode.insertBefore(
			mapContentContainer,
			mapContainer.parentNode.childNodes[0]
		);
	}

	// hide
	what2hide = mapContentContainer.firstChild;
	if (what2hide) {
		what2hide.style.display = 'none';
		footerContent.appendChild(what2hide);
	}

	// display this
	what2display = document.querySelector(data.content);
	if (what2display) {
		mapContentContainer.appendChild(what2display);
		what2display.style.display = 'block';
	}

	if (scroll) {
		originalTop = Math.floor(
			mapContentContainer.getBoundingClientRect().top - 100
		);
		window.scrollBy({ top: originalTop, left: 0, behavior: "smooth" });
	}
};
iMapsActions.contentRight = function (id, data, mapClass, contentClass) {
	// go 2 steps up to find map wrapper.
	var what2display,
		what2hide,
		mapContainer = document.getElementById("map_" + id).parentNode.parentNode
			.parentNode,
		mapContentContainer = mapContainer.parentNode.querySelector(
			"." + contentClass
		),
		mapBox = mapContainer.parentNode.querySelector("." + mapClass),
		footerContent = document.getElementById("igm-hidden-footer-content");

	data.content = iMapsActions.getIDfromData(data);

	if (mapBox === null) {
		mapBox = mapContainer.parentNode.querySelector(".map_box");
		mapBox.classList.add(mapClass);
	}

	if (mapContentContainer === null) {
		mapContentContainer = document.createElement("div");
		mapContentContainer.classList.add(contentClass);

		mapContainer.parentNode.insertBefore(
			mapContentContainer,
			mapContainer.nextSibling
		);
	}

	// hide
	what2hide = mapContentContainer.firstChild;
	if (what2hide) {
		what2hide.style.display = 'none';
		footerContent.appendChild(what2hide);
	}

	// display this
	what2display = document.querySelector(data.content);
	if (what2display) {
		mapContentContainer.appendChild(what2display);
		what2display.style.display = 'block';
	}

};

iMapsActions.postBelow = function (id, data) {
	//https://saltus.local/wp-json/wp/v2/posts/1
};

iMapsActions.getIDfromData = function (data) {

	if (typeof data.originalID !== 'undefined') {
		var id = data.originalID.replace(/,/g, "_");
		data.content = "#" + id + '_' + data.mapID;
	} else {
		data.content = "#" + data.id + '_' + data.mapID;
	}
	return data.content.toLowerCase();
};
