# MapFig-Omeka-Plugin

MapFig Leaflet Plugin for Omeka

Stand alone plugin for adding Leaflet maps to your Omeka installation
# Version 2.0.1

# Changelog

Created a separate controller for each module
Removed addAction/editAction/saveAction/deleteAction functions from IndexController
Used the Abstract addAction/editAction/deleteAction functions for the controllers to enable the built-in csrf feature
Created the separate add/edit views for all the controllers
Removed all extraneous files

## Description

Add Leaflet maps via shortcode to your pages, exhibits, items, and collections.

MapFig is a plugin for [Omeka](http://omeka.org/). The MapFig plugin allows you to add Leaflet maps via shortcode to your pages, exhibits, items, and collections.

The plugin is tile-agnostic, allowing you to use any tile provider.  A group of 10 tile providers, a tile group, and a demo map are created on installation.

The plugin supports markers, lines, and polygons and includes a WYSIWYG editor for displaying formatted text, images, and links to InfoBoxes. 

Maps can be added to directly to pages, as Items in collections, and Exhibit pages.

## Installation

Copy the files to your Omeka plugins directory, <b>making sure that directory name is MapFig</b>.  You can also download the current, stable zip file from us [here] (http://mapfig.org/omeka.html) as well. 

Activate the plugin from the Omeka plugins page

  - Documentation is available at **[acugis.com/docs](https://www.acugis.com/docs/omeka-leaflet-plugin/)**.

  - Please check here or at docs site for examples.
  
  - Please report any issues to **[plugins(at)acugis(dot).com](mailto:plugins@acugis.com)**.
 
  
  

