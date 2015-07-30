<?php
	echo head(array('title'=>'MapFig', 'bodyclass'=>'mapfig browse'));

	if (count($defaultLayer) > 0){
		$defaultLayer = "L.tileLayer('" . $defaultLayer->url ."', {maxZoom: 18, id: '". $defaultLayer->key . "', attribution:'" . html_entity_decode($defaultLayer->attribution) . "' + mbAttribution})";
	}

	$first_lat = 0;
	$first_lng = 0;

	if (!empty($mapfig->pointers)) {
		$parseData = json_decode($mapfig->pointers);
		
		if($parseData) {
			$coordinates = json_encode($parseData[0]->geometry->coordinates);
			if(preg_match_all("/(\-?\d+(\.\d+)?),(\-?\d+(\.\d+)?)/", $coordinates, $matches)) {
				$match = $matches[0][0];
				$match = str_replace(array("[","]"), "", $match);
				
				$match = explode(",", $match);
				$first_lat = $match[0];
				$first_lng = $match[1];
			}
		}
	}
	
	$csrfToken = new Zend_Session_Namespace('mapfig');
	$csrfToken->token = base64_encode(openssl_random_pseudo_bytes(16));
?>
<script src="<?php echo admin_url("../") ?>plugins/MapFig/js/tinymce/js/tinymce/tinymce.min.js"></script>


<link rel="stylesheet" href="<?php echo admin_url("../") ?>plugins/MapFig/leaflet/dist/leaflet.css" />
<script src="<?php echo admin_url("../") ?>plugins/MapFig/leaflet/dist/leaflet.js"></script>



<link href='https://cdn.mapfig.com/mapfig-cdn/leaflet.draw.css' rel='stylesheet' />
<script src='https://cdn.mapfig.com/mapfig-cdn/leaflet.draw.js'></script>

<link href='<?php echo admin_url("../") ?>plugins/MapFig/css/mapfig.css' rel='stylesheet' />
<script type="text/javascript" src="<?php echo admin_url("../") ?>plugins/MapFig/js/modal.js"></script>
<script type="text/javascript" src="<?php echo admin_url("../") ?>plugins/MapFig/js/tab.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" />

<link rel="stylesheet" href="<?php echo admin_url("../") ?>plugins/MapFig/leaflet/dist/leaflet.awesome-markers.css" />
<script src="<?php echo admin_url("../") ?>plugins/MapFig/leaflet/dist/leaflet.awesome-markers.js"></script>
        

<link href='<?php echo admin_url("../") ?>plugins/MapFig/css/colpick.css' rel='stylesheet' />
<script type="text/javascript" src="<?php echo admin_url("../") ?>plugins/MapFig/js/colpick.js"></script>

<form action="<?php echo url("map-fig/index/edit/id/".$mapfig->id); ?>" id="save_map_form" method="post">
	<?PHP echo $csrf; ?>
    <input type="hidden" value="" id="geo_json_str" name="pointers">
    <p>
        <label for="">Name</label> 
        <input type="text" name="name" value="<?php echo (isset($mapfig->name)) ? $mapfig->name : 'mapfig name'; ?>">
    </p>
    <div class="mapfig_slider_container">
        <label for="">Width</label> 
        <input type="hidden" name="width" id="mapfig_width" value="<?php echo (isset($mapfig->width)) ? $mapfig->width : '600'; ?>">
        <div id="mapfig_width_slider" class="slider"></div> 
        <div id="mapfig_width_value"><?php echo (isset($mapfig->width)) ? $mapfig->width : '600'; ?></div>
    </div>
    <div class="mapfig_slider_container">
        <label for="">Height</label> 
        <input type="hidden" name="height" id="mapfig_height" value="<?php echo (isset($mapfig->height)) ? $mapfig->height : '500'; ?>">
        <div id="mapfig_height_slider" class="slider" style=""></div> 
        <div id="mapfig_height_value" style=""><?php echo (isset($mapfig->height)) ? $mapfig->height : '500'; ?></div>
    </div>    
    <div class="mapfig_slider_container">
        <label for="">Zoom</label> 
        <input type="hidden" name="zoom"  id="mapfig_zoom"  value="<?php echo (isset($mapfig->zoom)) ? $mapfig->zoom : '2'; ?>">
        <div id="mapfig_zoom_slider" class="slider"></div> 
        <div id="mapfig_zoom_value"><?php echo (isset($mapfig->zoom)) ? $mapfig->zoom : '2'; ?></div>
    </div>
    
     <p>
        <label for="">Baselayer</label> 
         <select name="baselayer" id="">
           
            <?php foreach ($baselayer  as $b) : if (!isset($b->is_deleted)) :  ?>
                <option value="<?php echo $b->id; ?>" <?php if (isset($mapfig) && $mapfig->baselayer == $b->id) echo 'selected="selected"';  ?>><?php echo $b->name; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </p>

    <p>
        <label for="">Layer group</label> 
        <select name="layergroup" id="" >
            <option value="">Select</option>
            <?php foreach ($layerGroup  as $l) : if (!isset($l->is_deleted)) :  ?>
                <option value="<?php echo $l->id; ?>" <?php if (isset($mapfig) && $mapfig->layergroup == $l->id) echo 'selected="selected"'; ?>><?php echo $l->name; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </p>    

</form>

<div id='map' style="width:<?php echo $width; ?>px; height:<?php echo $height; ?>px; margin-bottom:10px;"></div>
<button  id="geo_json" data-type="index" class="btn btn-primary">Save</button>
<?php if (isset($mapfig)) : ?>
<!--<button  id="save_json" data-type="manage" class="btn btn-primary">Refresh</button>-->
<?php endif; ?>
<div class="modal fade" style="display:none;z-index:1000;" id="mapfig_myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        <h4 class="modal-title">Add/Edit Properties And Styles</h4>
      </div>
      <div class="modal-body">
            
            <div role="tabpanel">

              <!-- Nav tabs -->
              <ul class="nav nav-tabs nav-justified" role="tablist">
                <li role="presentation" class="active"><a href="#properties" aria-controls="properties" role="tab" data-toggle="tab">Properties</a></li>
                <li role="presentation"><a href="#advanced" aria-controls="advanced" role="tab" data-toggle="tab">Advanced</a></li>
                <li role="presentation"><a href="#style" aria-controls="style" role="tab" data-toggle="tab">Styles</a></li>
                
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="properties"> 
                                     
                    <table style="border:0" id="menuBasic">
                        <tbody>
                            <tr>
                                <td><label for="">Name</label></td>
                                <td><input type="text" id="autoFillAddress" ></td>
                            </tr>
                            <tr>
                                <td><label for="">Description</label></td>
                                <td><textarea id="description"></textarea></td>
                            </tr>   
                        </tbody>                                             
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="advanced">

                    <table id="menuCustomProperties"><tbody></tbody></table>
                </div>
                <div role="tabpanel" class="tab-pane" id="style">
                    <table id="menuStyle"><tbody></tbody></table>
                </div>         

              </div>

            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submit_modal">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
var featureGroup = L.featureGroup();
var show_sidebar = true;
var mbAttribution = ' contributors | <a href="https://www.mapfig.com" target="_blank">MapFig</a>'; 
var defaultLayer = <?php echo $defaultLayer; ?>;

var baseLayers = { <?php echo $mapfiglayergroup; ?>
};
var overlays = {
    "Map Points": featureGroup
};
var layerSelector = L.control.layers(baseLayers, overlays);

var map = L.map('map', { dragging: true, touchZoom: true, scrollWheelZoom: true, doubleClickZoom: true, boxzoom: true, trackResize: true, worldCopyJump: false, closePopupOnClick: true, keyboard: true, keyboardPanOffset: 80, keyboardZoomOffset: 1, inertia: true, inertiaDeceleration: 3000, inertiaMaxSpeed: 1500, zoomControl: true, crs: L.CRS.EPSG3857, layers: [defaultLayer, featureGroup] });
map.setView([<?php echo $first_lng;?>,<?php echo $first_lat; ?>], <?php echo $zoom; ?>);

 
jQuery('#map .leaflet-top.leaflet-left').append('<div id="sidebarhideshow" class="leaflet-control-sidebar leaflet-bar leaflet-control" style="z-index:10;">' + '<a class="leaflet-control-sidebar-button leaflet-bar-part" id="sidebar-button-reorder" href="#" onClick="return false;" title="Sidebar Toggle"><i class="fa fa-reorder"></i></a>' + '<div id="sidebar-buttons" class="sidebar-buttons" style="max-height: 300px; overflow: auto;">' + '<ul class="list-unstyled leaflet-sidebar">' + '</ul>' + '</div>' + '</div>');

var jsonData = L.geoJson(null, {

        style: function (feature) {
            return {color: "#f06eaa",  "weight": 4, "opacity": 0.5, "fillOpacity": 0.2};
        },
        onEachFeature: function (feature, layer) {
            featureGroup.addLayer(layer);
            
            layer.on("click", function(){
                if(editMode) {
                    showModal("edit", layer);
                    setTimeout(function(){
                        map.closePopup();
                    },50);
                }                
            });            

            properties1 = feature.properties;
            var properties = new Array();
            for(var i=0; i<properties1.length; i++){
                row = {};
                row['name']  = properties1[i].name;
                row['value'] = properties1[i].value;
                row['defaultProperty'] = properties1[i].defaultProperty;
                properties.push(row);
            }
            
            layerProperties.push(new Array(layer, properties));
            
            var style = feature.style;
            var cp    = feature.customProperties;

            if(style) {
                if(layer instanceof L.Marker) {
                    if(style.markerColor) {
                        layer.setIcon(L.AwesomeMarkers.icon(style));
                    }
                }
                else {
                    layer.setStyle(style);
                }
            }

            shapeStyles.push(style); //styles is JSON Object
            shapeCustomProperties.push(cp);
            bindPopup(layer);

            renderSideBar(layer);
        }
    })


  var drawControl = new L.Control.Draw({
    draw : {        
        circle : false
    },
    edit: {
      featureGroup: featureGroup
    }
  }).addTo(map);

jQuery(document).ready(function($) {
    
   // jQuery("#description").tinymce();

    jQuery('#geo_json, #save_json').click(function(){
        var type = jQuery(this).attr("data-type");
        jQuery('#mapfig_type').val(type);

        var finalShapeData = new Array();
                
        var shapes = getShapes(featureGroup);
        
        jQuery.each(shapes, function(index, shape) {
            properties = getPropertiesByLayer(shape);

            var index = getLayerIndex(shape);
            shpJson = shape.toGeoJSON();
            shpJson.properties = properties;
            shpJson.customProperties = shapeCustomProperties[index];
            shpJson.style = shapeStyles[index];
            finalShapeData.push(shpJson);
        });

        finalShapeData = JSON.stringify(finalShapeData);
        
        jQuery("#geo_json_str").val(finalShapeData);
        jQuery('#save_map_form').submit();       
    
    })

    jQuery('#submit_modal').click(function(){

        properties = new Array();
        var name = jQuery('#autoFillAddress').val();
        var description = tinyMCE.get('description').getContent();
                console.log(description);            
        row = {};
        row['name']            = "Name";
        row['value']           = name;
        row['defaultProperty'] = true;
        
        properties.push(row);

        row = {};
        row['name']     = "Description";
        row['value']    = description;
        row['defaultProperty'] = true;
        
        properties.push(row);


        stl = {};
        jQuery('#menuStyle tbody tr input, #menuStyle tbody tr select').each(function(){
            name  = $(this).attr('id');
            value = $(this).val();
            
            stl[name]  = value;
        });
        
        cp = {};
        jQuery('#menuCustomProperties tbody tr input[type=checkbox]').each(function(){
            name  = $(this).attr('id');
            value = $(this).is(':checked');
            
            cp[name]  = value;
        });

        for(i=0; i<layerProperties.length; i++) {
            if(layerProperties[i][0] == currentLayer) {
                layerProperties[i][1] = properties;
                shapeStyles[i] = stl;
                shapeCustomProperties[i] = cp;
                break;
            }
        }
        bindPopup(currentLayer);
        reRenderShapeStylesOnMap(currentLayer);
        renderSideBar(currentLayer);
        jQuery('#mapfig_myModal').modal("hide");
    })   
   
     var animating = false;
    jQuery('#sidebar-button-reorder').click(function() {
        if (animating) return;
        var element = jQuery('#sidebar-buttons');
        animating = true;
        if (element.css('left') == '-50px') {
            element.show();
            element.animate({
                opacity: '1',
                left: '0px'
            }, 400, function() {
                animating = false;
            });
        } else {
            element.animate({
                opacity: '0',
                left: '-50px'
            }, 400, function() {
                animating = false;
                element.hide();
            });
        }
    });
});


function renderSideBar(layer) {
        if (show_sidebar )
            jQuery('#sidebarhideshow').show();
        else {
            jQuery('#sidebarhideshow').hide();
        }
        target = jQuery('#sidebar-buttons ul.leaflet-sidebar');
        currentIndex = getLayerIndex(layer);
     //   console.log(layerProperties[currentIndex]);
        lable = layerProperties[currentIndex][1][0].value;
        //alert(lable);
        if (lable == "") {
            lable = "No Location";
        }
        target.append('<li><input type="checkbox" data-index="' + currentIndex + '" onClick="changeAddressCheckbox(this)" checked><a data-index="' + currentIndex + '" onClick="clickOnSidebarAddress(this)">' + lable + '</a><div class="clear"></div></li>');
    }

    function changeAddressCheckbox(obj) {
        var layers = getLayers();
        
        index = jQuery(obj).attr("data-index");
        
        if (jQuery(obj).is(':checked')) {
            featureGroup.addLayer(layers[index]);
        } else {
            featureGroup.removeLayer(layers[index]);
        }
    }

function clickOnSidebarAddress(obj) {
    var layers = getLayers();
    index = jQuery(obj).attr("data-index");
    setTimeout(function() {
        layers[index].openPopup();
    }, 50);
}
</script>

<script type="text/javascript" src="<?php echo admin_url("../") ?>plugins/MapFig/js/helper.js"></script>

<script type="text/javascript" src="<?php echo admin_url("../") ?>plugins/MapFig/js/mapfig.js"></script>

<textarea style="display:none;" id="hidden_pointers_json"><?PHP echo $mapfig->pointers; ?></textarea>

<script type="text/javascript">

jQuery(document).ready(function($) {
        layerSelector.addTo(map);
        jQuery('#map .leaflet-control-layers form.leaflet-control-layers-list input[type=radio]').click(function(){
                map.removeLayer(defaultLayer);
            });
    });

 <?php if (isset($mapfig) && count($mapfig->pointers) > 0) : ?>
    
    var data = JSON.parse(jQuery("#hidden_pointers_json").val());
    jsonData.addData(data); 
    
<?php endif; ?>

</script>

<script type="text/javascript">
    jQuery(document).ready(function($) {
            //alert("called");
        jQuery('#mapfig_zoom_slider').slider({
            value: <?php echo (isset($mapfig)) ? $mapfig->zoom : 2; ?>,
            min: 0,
            max: 18,
            step: 1,
            slide: function (event, ui){

                var valA = jQuery('#mapfig_zoom_slider').slider("value");
                
                jQuery('#mapfig_zoom').val(valA);
                jQuery('#mapfig_zoom_value').html(valA);  
            },
            change  : function( event, ui ) { 
                 var valA = jQuery('#mapfig_zoom_slider').slider("value");
                
                jQuery('#mapfig_zoom').val(valA);
                jQuery('#mapfig_zoom_value').html(valA);
				
				map.setZoom(valA);
            }

        });


        jQuery('#mapfig_width_slider').slider({
            value: <?php echo (isset($mapfig)) ? $mapfig->width : 600; ?>,
            min: 100,
            max: 1000,
            step: 10,
            slide: function (event, ui){

                var valA = jQuery('#mapfig_width_slider').slider("value");
                
                jQuery('#mapfig_width').val(valA);
                jQuery('#mapfig_width_value').html(valA);  
            },
            change: function (event, ui){

                var valA = jQuery('#mapfig_width_slider').slider("value");
                
                jQuery('#mapfig_width').val(valA);
                jQuery('#mapfig_width_value').html(valA);
				
				map._size.x = valA;
				jQuery('#map').css('width',valA);
            }

        });


        jQuery('#mapfig_height_slider').slider({
            value: <?php echo (isset($mapfig)) ? $mapfig->height : 500; ?>,
            min: 100,
            max: 1000,
            step: 10,
            slide: function (event, ui){

                var valA = jQuery('#mapfig_height_slider').slider("value");
                
                jQuery('#mapfig_height').val(valA);
                jQuery('#mapfig_height_value').html(valA);  
            },
            change: function (event, ui){

                var valA = jQuery('#mapfig_height_slider').slider("value");
                
                jQuery('#mapfig_height').val(valA);
                jQuery('#mapfig_height_value').html(valA);
				
				map._size.y = valA;
				jQuery('#map').css('height',valA);
            }

        });
		
		$ = jQuery;
		
		$('select[name=baselayer]').change(function(e){
			var posting = $.post('<?php echo url("map-fig/ajax/jsonlayer"); ?>', { layers_id: $(this).val() });
			
			posting.done(function(data) {
				map.removeLayer(defaultLayer);
				
				$.each(map._layers, function(idx, obj) {
					if(obj._url) {
						map.removeLayer(obj);
					}
				});
				
				data = jQuery.parseJSON(data);
				defaultLayer = new L.TileLayer(data.url, {'id' : data.key, token: data.accesstoken, maxZoom: 18, attribution: '© '+$('<div/>').html(data.attribution).html()+mbAttribution});
				
				map.addLayer(defaultLayer);
			});
		});
		
		$('select[name=layergroup]').change(function(e){
			var posting = $.post('<?php echo url("map-fig/ajax/jsongroup"); ?>', { groups_id: $(this).val() });
			
			posting.done(function(data) {
				map.removeControl(layerSelector);
				
				data = jQuery.parseJSON(data);
				
				baseLayers = {}
				$.each(data, function(idx, obj) {
					if(obj.name) {
						baseLayers[obj.name] = new L.TileLayer(obj.url, {maxZoom: 18, id: obj.key, token: obj.accesstoken, attribution: '© '+$('<div/>').html(obj.attribution).html()+mbAttribution});
					}
				});
				
				layerSelector = L.control.layers(baseLayers, overlays)
				map.addControl(layerSelector);
				
				setTimeout(function(){
					$('.leaflet-control-layers form.leaflet-control-layers-list input[type=radio]').click(function(){
						map.removeLayer(defaultLayer);
					});
				},200);
			});
		});
		
		setTimeout(function(){
			$('.leaflet-control-layers form.leaflet-control-layers-list input[type=radio]').click(function(){
				map.removeLayer(defaultLayer);
			});
		},200);
    });
</script>
<?php echo foot(); ?>