=== Interactive Geo Maps ===
Contributors: carlosmoreirapt
Tags: maps, interactive maps, world map, travel map, us map
Requires at least: 5.0
Tested up to: 5.3.2
Requires PHP: 7.0
Stable tag: 1.1.1
Donate link: https://interactivegeomaps.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Create interactive vector maps of the world, continents, any country in the world and specific regions, including individual US state county maps.

== Description ==

Create interactive maps with regions and coloured markers. You can display the world map, continent maps and single country maps.

[Demo](https://interactivegeomaps.com/features) | [Available Maps](https://interactivegeomaps.com/maps/) | [Documentation](https://interactivegeomaps.com/documentation/) | [Pro Version](https://interactivegeomaps.com/pricing/)

= More than 200 maps available =
- World map (with and without Antarctica)
- World map divided by continents (different variations)
- Maps of continents and regions (Africa, Asia, Caribbean, Central America, Europe, Latin America, Middle East, North America, Oceania, South America )
- US States divided by counties (California, Texas, Florida, New York and all the others)
- Most countries in the world, including United States of America (USA), Germany, France, United Kingdom (UK), Netherlands, Spain, Australia, Italy, Poland, South Africa, Brazil, India, Japan and many others.
- Some countries with different variations like France, divided by regions or departments, Portugal divided by districts or municipalities, among others.

Create your first interactive map in minutes! Use it to display your visited countries map, travel map, office locations, projects map, representatives map, statistics map, data visualization map or any other thing!

[Browse Full List of Maps](https://interactivegeomaps.com/maps/)

= Features =
- Responsive and cross-device
- Color countries
- Add round coloured markers
- Set hover color change
- Set click actions, like open a new window
- Choose from different map projections (Mercator, Miller, NaturalEarth1, among others)
- Select which regions to display in a map
- Exclude specific regions from a map
- Display HTML tooltips on hover
- Zoom controls and Pan

= Pro only Features =
- Colour regions and markers individually
- Change initial zoom and center
- Cluster markers
- Add Legend
- Custom images as markers
- Vector icons as markers
- Text Labels
- Display content on click outside the map
- Display content in a lightbox
- Group regions
- Create heatmaps (choropleth maps)
- Add lines connecting markers
- Overlay different maps (have US states map on world map for example)
- Populate map automatically from existing categories or Tags
- Advanced zoom options

[Features Examples](https://interactivegeomaps.com/features/) | [Go Pro](https://interactivegeomaps.com/pricing/)


= Privacy Information & External Services =
This plugin will build the maps using the [amcharts visualization library](https://www.amcharts.com/javascript-charts/) which provides hundreds of different maps. The plugin loads some files from their CDN to build the map and display it on your page. You won't need to have a amcharts account for the maps to work. More information about their [amcharts Privacy Policy](https://www.amcharts.com/privacy-policy/).
When you first install the plugin, you can choose to [opt-in to share non-sensitive data with Freemius](https://interactivegeomaps.com/docs/opt-in-to-non-sensitive-diagnostic-tracking/), a framework we use to collect data about your WordPress installation that will help us improve the plugin. This is optional and the plugin will still work if you don't opt-in. It will not collect any data from your visitors.

== Frequently Asked Questions ==
= Do I need an amcharts account or license for the plugin to work? =
No, you won't need any license or specific account. The plugin will work out of the box.

= Do I need a Google Maps API Key for the plugin to work? =
No, you won't need one. The plugin will not use the Google Maps API. However you can add a Google Maps API Key in the settings of the plugin to enable geocoding when adding markers and therefore get the latitude and longitude directly in the plugin's administration.

= Where can I get coordinates for a marker? =
You can get the latitude and longitude needed to a add a marker to a map using sites like [GetLatLong](https://getlatlong.net/) or [LatLong.net](https://www.latlong.net/) or any other similar website. Optionally, you can add a Google Maps API Key in the settings page of the plugin and this will enable you to get the coordinates directly in the map administration panel, when adding a maker. In this case, Google's geocoding service is only used in the administration to get the coordinates, it won't be used when the map displays in your pages.

= Where can I learn how to use the plugin? =
You can get visit the [documentation pages on the official website](https://interactivegeomaps.com/documentation/).


== Screenshots ==
1. World map example
2. Tooltip example
3. USA Map
4. US county maps example
5. World Map with coloured countries
6. Single country map
7. Administration 01
8. Administration 02
9. Administration 03
10. Administration 04

== Changelog ==
= 1.1.1 =
* New Maps for Cuba, Jamaica, Uruguay and Mexican county maps
* [Pro] Customize tooltip shadow options

= 1.1.0 =
* Improved compatibility with Elementor
* [Pro] Custom Action bug fixed

= 1.0.9 =
* Improved loading of assets to workaround cache
* Added Actions to help adding markers and regions
* Forced amcharts version to 4.8.0 (4.8.1 introduced a hover bug)

= 1.0.8 =
* Improved group hover
* Added new maps (Canada regions and other world maps)
* [Pro] Fix group hover bug
* [Pro] Improved Lightbox feature

= 1.0.7 =
* Fix conflict with Async Javascript plugin
* [Pro] Improved feature to drag auto Labels
* [Pro] Fixed bug when initial zoom was changed
* [Pro] Fixed bug with Albers projection
* [Pro] Better handling of Pro Actions

= 1.0.6 =
* Upgrade option introduced
* Remove drag/resize on mobile

= 1.0.5 =
* Freemius OptIn added
* Zoom in preview bug fix
* Map List Update

= 1.0.4 =
* Disable drag when zoom is disabled
* Gutenberg block bug fix (ccs class)
* Small code improvements

= 1.0.3 =
* Extra maps for Portugal added
* Tooltip improvements to handle images
* Preview bugs fixed

= 1.0.2 =
* Zoom Controls added (Settings > Map Features )
* Automatic line breaks in tooltips
* Option to enable rich editor for the tooltip (Settings > Editing )

= 1.0.1 =
* Gutenberg Block
* Map Image Preview
* PHP 7 compatibility

= 1.0 =
* Initial Release

== Upgrade Notice ==
= 1.1.1 =
* New maps added


== Credits ==
* [amcharts](https://www.amcharts.com/)
* [jsonTree](http://github.com/summerstyle/jsonTreeViewer)
* [autocomplete](https://kraaden.github.io/autocomplete/)