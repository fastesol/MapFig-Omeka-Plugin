<?php
	echo head(array('title'=>'MapFig', 'bodyclass'=>'mapfig browse'));
?>

<form action="<?php echo url("map-fig/group/edit/id/".$mapfig_group->id); ?>" id="save_map_form" method="post">
    <?PHP echo $csrf; ?>
	
    <p>
        <label for="">Name</label> 
        <input type="text" name="name" value="<?php echo $mapfig_group->name; ?>">
    </p>
	<input type="hidden" id="layer_id" name="layer_id"/>
    <p>
		<label for="">BaseLayers</label> 
        <select id="layer_id_select" multiple="multiple"> 
        	<?php foreach ($baselayer as $b) : if (!isset($b->is_deleted)) : ?>
        		<option value="<?php echo $b->id; ?>" <?php echo (in_array($b->id, $selected_baselayer)) ? 'selected="selected"': ''; ?> ><?php echo $b->name; ?></option>
        	<?php endif; endforeach; ?>
        </select>   	
    </p>
    <p>
    	<button class="btn button green">Save</button>
    </p>
</form>

<script>
	jQuery(document).ready(function($){
		$("#save_map_form").submit(function(){
			$("#layer_id").val($("#layer_id_select").val());
		});
	});
</script>