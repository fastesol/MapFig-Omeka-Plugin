<?php
	echo head(array('title'=>'MapFig', 'bodyclass'=>'mapfig browse'));
?>
<link href='<?php echo admin_url("../") ?>plugins/MapFig/css/mapfig.css' rel='stylesheet' />
<form action="<?php echo url("map-fig/layer/edit/id/".$mapfig_layer->id); ?>" id="save_map_form" method="post">
	<?PHP echo $csrf; ?>

    <p>
        <label for="">Layer Name</label> 
        <input type="text" name="name" value="<?php echo htmlspecialchars($mapfig_layer->name); ?>">
    </p>
	
	<p>
        <label for="">Layer URL</label> 
        <input type="text" name="url" value="<?php echo htmlspecialchars($mapfig_layer->url); ?>">
    </p>

    <p>
        <label for="">key</label> 
        <input type="text" name="key" value="<?php echo htmlspecialchars($mapfig_layer->key); ?>">
    </p>

    <p>
        <label for="">Access Token</label> 
        <input type="text" name="accesstoken" value="<?php echo htmlspecialchars($mapfig_layer->accesstoken); ?>">
    </p>

    <p>
        <label for="">Attribution</label> 
        <input type="text" name="attribution" value="<?php echo htmlspecialchars($mapfig_layer->attribution); ?>">
    </p>

    <p>
    	<button class="btn button green">Save</button>
    </p>
</form>
