<?php
	echo head(array('title'=>'MapFig', 'bodyclass'=>'mapfig browse'));
	
	$csrfToken = new Zend_Session_Namespace('mapfig');
	$csrfToken->token = base64_encode(openssl_random_pseudo_bytes(16));
?>
<link href='<?php echo admin_url("../") ?>plugins/MapFig/css/mapfig.css' rel='stylesheet' />

<div class="mapfig-img"></div>
<div id='primary'>	  	
    <p>To add maps to your Pages, Exhibits or Items, simply paste the short code [mapfig id="XXX"] where XXX is your MapID.</p>
</div>

<a href="<?php echo url("map-fig/index/add"); ?>" class="big green add button">Add Map</a>
<p>&nbsp;</p>
<p>&nbsp;</p>

	<table>
		<tr>
			<td>MapFig</td>
			<td>Name</td>
			<td>Action</td>
		</tr>
		<?php  $flag = 0; foreach ($mapfig as $f) : $flag = 1; ?>
			<tr>
				<td>[mapfig id="<?php echo $f->id; ?>"]</td>
				<td><?php echo $f->name; ?></td>
				<td>
					<a href="<?php echo url("map-fig/index/edit/id/" . $f->id); ?>" class="btn button green">Edit</a>
					<a href="<?php echo url("map-fig/ajax/downloadjson/" .  $f->id); ?>" class="btn button green">JSON</a>
					<a class="delete-confirm btn button red" href="<?php echo url("map-fig/index/delete-confirm/id/" .  $f->id); ?>">Delete</a>
				</td>		
			</tr>
			
		<?php endforeach; ?>

		<?php if (empty($flag)): ?>
			<tr>
				<td colspan="3">There are not map.</td>
			</tr>
		<?php endif; ?>
		
	</table>


	
	<a href="<?php echo url("map-fig/group/add"); ?>" class="big green add button">Add Layer Group</a>
<p>&nbsp;</p>
<p>&nbsp;</p>
	<table>
		<tr>
			<td>Name</td>
			<td>Action</td>
		</tr>
		<?php $flag = 0; foreach ($layer_group as $f) : $flag = 1; ?>
			<tr>
				<td><?php echo $f->name; ?></td>
					<td>
					<a href="<?php echo url("map-fig/group/edit/id/" . $f->id) ; ?>" class="btn button green">Edit</a>
					<a href="<?php echo url("map-fig/group/delete-confirm/id/" . $f->id); ?>" class="delete-confirm btn button red">Delete</a>
				</td>		
			</tr>
			
		<?php endforeach; ?>

		<?php if (empty($flag)): ?>
			<tr>
				<td colspan="2">There are no layer group.</td>
			</tr>
		<?php endif; ?>
	</table>
	
	
	
	
	
	
	
	<a href="<?php echo url("map-fig/layer/add"); ?>" class="big green add button">Add Baselayer</a>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table>
	<tr>			
		<td>Name</td>
		<td>Action</td>
	</tr>
	<?php $flag = 0; foreach ($baselayer as $f) :  $flag = 1; ?>
		<tr>
			<td><?php echo $f->name; ?></td>
			<td>
				<a href="<?php echo url("map-fig/layer/edit/id/" . $f->id); ?>" class="btn button green">Edit</a>
				<a href="<?php echo url("map-fig/layer/delete-confirm/id/" . $f->id); ?>" class="delete-confirm btn button red">Delete</a>
			</td>		
		</tr>
		
	<?php endforeach; ?>

	<?php if (empty($flag)): ?>
		<tr>
			<td colspan="2">There are not baselayer api.</td>
		</tr>
	<?php endif; ?>
</table>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
<?php echo foot(); ?>