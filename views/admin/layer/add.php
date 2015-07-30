<?php
	echo head(array('title'=>'MapFig', 'bodyclass'=>'mapfig browse'));
?>
<link href='<?php echo admin_url("../") ?>plugins/MapFig/css/mapfig.css' rel='stylesheet' />
<form action="<?php echo url("map-fig/layer/add"); ?>" id="save_map_form" method="post">
	<?PHP echo $csrf ?>

    <p>
        <label for="">Layer Name</label> 
        <input type="text" name="name" value="Layer Name">
    </p>
	
	<p>
        <label for="">Layer URL</label> 
        <input type="text" name="url">
    </p>

    <p>
        <label for="">key</label> 
        <input type="text" name="key">
    </p>

    <p>
        <label for="">Access Token</label> 
        <input type="text" name="accesstoken">
    </p>

    <p>
        <label for="">Attribution</label> 
        <input type="text" name="attribution">
    </p>

    <p>
    	<button class="btn button green">Save</button>
    </p>
</form>
