<?php
	$db = get_db();
	
	$sql = "CREATE TABLE IF NOT EXISTS `$db->Mapfig` (
			`id` int(4) NOT NULL AUTO_INCREMENT,
			`name` varchar(200) NOT NULL,
			`width` varchar(100) NOT NULL,
			`height` varchar(100) NOT NULL,
			`zoom` tinyint(2) NOT NULL,
			`baselayer` int(11) NOT NULL,
			`layergroup` int(11) NOT NULL,
			`pointers` longtext NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
	$db->query($sql);
	
	$sql = "CREATE TABLE IF NOT EXISTS `$db->MapfigGroup` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(200) NOT NULL,
			`layer_id` varchar(100) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
	$db->query($sql);
		
	$sql = "CREATE TABLE IF NOT EXISTS `$db->MapfigLayer` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(200) NOT NULL,
			`url` varchar(200) NOT NULL,
			`key` varchar(200) NOT NULL,
			`accesstoken` varchar(200) NOT NULL,
			`attribution` varchar(500) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
	$db->query($sql);
	
	$sql = "CREATE TABLE IF NOT EXISTS `$db->MapfigItem` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`item_id` int(11) NOT NULL,
			`content` longtext NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
	$db->query($sql);
	
		
	$sql = "INSERT INTO `$db->MapfigLayer` (`id`, `name`, `url`, `key`, `attribution`) VALUES
		(1, 'Open Street Map', 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', '', '<a href=\"https://openstreetmap.org\" target=\"_blank\">OpenStreetMap</a>'),
		(2, 'MapQuest', 'http://otile1.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.png', '', '<a href=\"https://openstreetmap.org\" target=\"blank\">OpenStreetMap contributors.</a> Tiles Courtesy of <a href=\"https://www.mapquest.com/\" target=\"_blank\">MapQuest</a>'),
		(3, 'Google Maps', 'http://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', '', '<a href=\"http://www.google.com/intl/en-GB_US/help/terms_maps.html\" target=\"_blank\">Google - Terms of Use</a>'),
		(4, 'Esri World Imagery', 'http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', '', '<a href=\"http://www.esri.com/\" target=\"_blank\">ESRI</a>'),
		(5, 'Stamen.Watercolor', 'http://{s}.tile.stamen.com/watercolor/{z}/{x}/{y}.jpg', '', 'Map tiles by <a href=\"http://stamen.com\" target=\"_blank\">Stamen Design</a>, under <a href=\"http://creativecommons.org/licenses/by/3.0\" target=\"_blank\">CC BY 3.0</a>. Data by <a href=\"http://openstreetmap.org\" target=\"_blank\">OpenStreetMap</a>, under <a href=\"http://creativecommons.org/licenses/by-sa/3.0\" target=\"_blank\">CC BY SA</a>'),
		(6, 'Stamen.Toner', 'http://a.tile.stamen.com/toner/{z}/{x}/{y}.png', '', 'Map tiles by <a href=\"http://stamen.com\" target=\"_blank\">Stamen Design</a>, under <a href=\"http://creativecommons.org/licenses/by/3.0\" target=\"_blank\">CC BY 3.0</a>. Data by <a href=\"http://openstreetmap.org\" target=\"_blank\">OpenStreetMap</a>, under <a href=\"http://www.openstreetmap.org/copyright\" target=\"_blank\">ODbL</a>'),
		(7, 'CartoDB Light', 'http://a.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', '', '<a href=\"https://CartoD.com\" target=\"_blank\">Map tiles by CartoDB, under CC BY 3.0.</a> Data by <a href=\"http://OpenStreetMap.org/license\" target=\"_blank\">OpenStreetMap</a>, under ODbL.</a>'),
		(8, 'CartoDB Dark', 'http://a.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png', '', '<a href=\"https://CartoD.com\" target=\"_blank\">Map tiles by CartoDB, under CC BY 3.0.</a> Data by <a href=\"http://OpenStreetMap.org/license\" target=\"_blank\">OpenStreetMap</a>, under ODbL.</a>'),
		(9, 'MapFig Whitewaters', 'https://a.tile.thunderforest.com/mapfig/{z}/{x}/{y}.png', '', '<a href=\"http://mapfig.org\" target=\"_blank\">MapFig </a> Whitewaters by <a href=\"http://thunderforest.com\" target=\"_blank\">Thunderforest,</a> Data by <a href=\"http://www.openstreetmap.org/copyright\" target=\"_blank\">OpenStreetMap</a>'),
		(10, 'MapFig Greenwaters', 'https://a.tile.thunderforest.com/mapfig-2a6/{z}/{x}/{y}.png', '', '<a href=\"http://mapfig.org\" target=\"_blank\">MapFig </a> Greenwaters by <a href=\"http://thunderforest.com\" target=\"_blank\">Thunderforest,</a> Data by <a href=\"http://www.openstreetmap.org/copyright\" target=\"_blank\">OpenStreetMap</a>'),
		(11, 'OpenCycle', 'http://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png', '', '<a href=\"http://thunderforest.com/\" target=\"_blank\">Thunderforest</a> Data by <a href=\"http://www.openstreetmap.org/copyright\" target=\"_blank\">OpenStreetMap</a>'),
		(12, 'Loniva Cycling', 'http://tile.waymarkedtrails.org/cycling/{z}/{x}/{y}.png', '', '<a href=\"https://waymarkedtrails.org\" target=\"_blank\">Waymarkedtrails</a> Data by <a href=\"http://www.openstreetmap.org/copyright\" target=\"_blank\">OpenStreetMap</a>'),
		(13, 'Loniva Hiking', 'http://tile.waymarkedtrails.org/hiking/{z}/{x}/{y}.png', '', '<a href=\"https://waymarkedtrails.org\" target=\"_blank\">Waymarkedtrails</a> Data by <a href=\"http://www.openstreetmap.org/copyright\" target=\"_blank\">OpenStreetMap</a>');";
	$db->query($sql);
	
	
	$sql = "INSERT INTO `$db->MapfigGroup` (`id`, `name`, `layer_id`) VALUES
		(2, 'My First Group', '1,2,9,10');";
	$db->query($sql);
	
	
	$sql = "INSERT INTO `$db->Mapfig` (`id`, `name`, `width`, `height`, `zoom`, `baselayer`, `layergroup`, `pointers`) VALUES
		(1, 'My First Map', '600', '500', 6, 2, 2, 'czoyMDQwOiJbeyJ0eXBlIjoiRmVhdHVyZSIsInByb3BlcnRpZXMiOlt7Im5hbWUiOiJOYW1lIiwidmFsdWUiOiJQYXJpcywgRnJhbmNlIiwiZGVmYXVsdFByb3BlcnR5Ijp0cnVlfSx7Im5hbWUiOiJEZXNjcmlwdGlvbiIsInZhbHVlIjoiPHA+VGhpcyBpcyBhIG1hcmtlci4gJm5ic3A7WW91IGNhbiBhZGQgbWFya2VycyBhcyB3ZWxsIGFzIHNldCBtYXJrZXIgaWNvbiBhbmQgc3R5bGUgYnkgZHJvcHBpbmcgYSBtYXJrZXIgb250byBtYXAgY2FudmFzLiAmbmJzcDtUeXBpbmcgdGhlIGxvY2F0aW9uIGluIHRoZSBOYW1lIGZpZWxkIHdpbGwgc2V0IHRoZSBtYXJrZXIgcG9zaXRpb24uICZuYnNwOyBZb3UgY2FuIGFsc28gYWRkIGltYWdlcyBhbmQgb3RoZXIgbWVkaWEgaW50byB0aGUgYm94IGFzIHdlbGwuJm5ic3A7PC9wPiIsImRlZmF1bHRQcm9wZXJ0eSI6dHJ1ZX1dLCJnZW9tZXRyeSI6eyJ0eXBlIjoiUG9pbnQiLCJjb29yZGluYXRlcyI6WzIuMzUyMjIxOTAwMDAwMDE3Nyw0OC44NTY2MTRdfSwiY3VzdG9tUHJvcGVydGllcyI6eyJnZXRfZGlyZWN0aW9uIjpmYWxzZSwic2hvd19hZGRyZXNzX29uX3BvcHVwIjp0cnVlLCJoaWRlX2xhYmVsIjp0cnVlfSwic3R5bGUiOnsiaWNvbiI6ImNvZmZlZSIsInByZWZpeCI6ImZhIiwibWFya2VyQ29sb3IiOiJjYWRldGJsdWUifX0seyJ0eXBlIjoiRmVhdHVyZSIsInByb3BlcnRpZXMiOlt7Im5hbWUiOiJOYW1lIiwidmFsdWUiOiJQb2x5Z29uIiwiZGVmYXVsdFByb3BlcnR5Ijp0cnVlfSx7Im5hbWUiOiJEZXNjcmlwdGlvbiIsInZhbHVlIjoiPHA+VGhpcyBpcyBhJm5ic3A7UG9seWdvbi4gJm5ic3A7WW91IGNhbiBkcmF3IHBvbHlnb25zIGJ5IGNsaWNraW5nIHRoZSZuYnNwO1BvbHlnb24gaWNvbiBhbmQgc3RhcnQgZHJhd2luZy4gJm5ic3A7WW91IGNhbiBhbHNvIGFkZCBpbWFnZXMgYW5kIG90aGVyIG1lZGlhIHRvIHRoaXMgYm94LjwvcD4iLCJkZWZhdWx0UHJvcGVydHkiOnRydWV9XSwiZ2VvbWV0cnkiOnsidHlwZSI6IlBvbHlnb24iLCJjb29yZGluYXRlcyI6W1tbMy40Mzg3MjA3MDMxMjUsNDguNDI5MjAwNTU1NTY4NDFdLFs1LjA2NDY5NzI2NTYyNSw0OS4xOTYwNjQwMDA3MjM3OTRdLFs2Ljc3ODU2NDQ1MzEyNSw0OC43NjM0MzExMzc5MTc5Nl0sWzQuODIyOTk4MDQ2ODc1LDQ3LjUwMjM1ODk1MTk2ODU5Nl0sWzMuMTA5MTMwODU5Mzc0OTk5Niw0Ny40MjgwODcyNjE3MTQyNzVdLFszLjQzODcyMDcwMzEyNSw0OC40MjkyMDA1NTU1Njg0MV1dXX0sImN1c3RvbVByb3BlcnRpZXMiOnsiZ2V0X2RpcmVjdGlvbiI6ZmFsc2UsInNob3dfYWRkcmVzc19vbl9wb3B1cCI6dHJ1ZSwiaGlkZV9sYWJlbCI6dHJ1ZX0sInN0eWxlIjp7ImNvbG9yIjoiIzljMGUwZSIsIm9wYWNpdHkiOiIwLjUiLCJ3ZWlnaHQiOiI1IiwiZmlsbENvbG9yIjoiIzAwZmZhNiIsImZpbGxPcGFjaXR5IjoiMC4yIn19LHsidHlwZSI6IkZlYXR1cmUiLCJwcm9wZXJ0aWVzIjpbeyJuYW1lIjoiTmFtZSIsInZhbHVlIjoiQSBMaW5lIiwiZGVmYXVsdFByb3BlcnR5Ijp0cnVlfSx7Im5hbWUiOiJEZXNjcmlwdGlvbiIsInZhbHVlIjoiPHA+VGhpcyBpcyBhIExpbmUuICZuYnNwO1lvdSBjYW4gZHJhdyBwb2x5Z29ucyBieSBjbGlja2luZyB0aGUgTGluZSBpY29uIGFuZCBzdGFydCBkcmF3aW5nLiAmbmJzcDtZb3UgY2FuIGFsc28gYWRkIGltYWdlcyBhbmQgb3RoZXIgbWVkaWEgdG8gdGhpcyBib3guPC9wPiIsImRlZmF1bHRQcm9wZXJ0eSI6dHJ1ZX1dLCJnZW9tZXRyeSI6eyJ0eXBlIjoiTGluZVN0cmluZyIsImNvb3JkaW5hdGVzIjpbWzAuMjk2NjMwODU5Mzc1LDQ4LjQ4NzQ4NjQ3OTg4NDE1XSxbMS41OTMwMTc1NzgxMjUsNDguMTIyMTAxMDI4MTkwODA1XV19LCJjdXN0b21Qcm9wZXJ0aWVzIjp7ImdldF9kaXJlY3Rpb24iOmZhbHNlLCJzaG93X2FkZHJlc3Nfb25fcG9wdXAiOnRydWUsImhpZGVfbGFiZWwiOnRydWV9LCJzdHlsZSI6eyJjb2xvciI6IiM3ODc4ZTMiLCJvcGFjaXR5IjoiMC41Iiwid2VpZ2h0IjoiNSIsImZpbGxDb2xvciI6IiNiZjdhN2EiLCJmaWxsT3BhY2l0eSI6IjAuMiJ9fV0iOw==');
	";
	
	$db->query($sql);
?>