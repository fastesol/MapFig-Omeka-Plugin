<?php 
	if (!empty($mapfig_item_id)){
		$mapfigItem = get_db()->getTable('MapfigItem')->find($mapfig_item_id);	
	}
?>
<style>
	#mapfig-metadata h2{
		display: none;
	}
</style>
<link href='<?php echo admin_url("../") ?>plugins/MapFig/css/mapfig.css' rel='stylesheet' />

<div class="mapfig-img"></div>

<p>To add MapFig map, Just copy and paste desired shortcode(s) below:</p>

<textarea id="mapfig_content" name="mapfig_content" rows="10" cols="10"><?php echo isset($mapfigItem) ? $mapfigItem->content : ''; ?></textarea>
<input type="hidden" name="mapfig_item_id" value="<?php echo isset($mapfigItem) ? $mapfigItem->id : '';?>">
<?php 
	$mapfig = get_db()->getTable('Mapfig')->findAll();
?>
<p>&nbsp;</p>
<table>
		<tr>
			<td>MapFig</td>
			<td>Name</td>			
		</tr>
		<?php  $flag = 0; foreach ($mapfig as $f) : $flag = 1; ?>
			
			<tr>
				<td>[mapfig id="<?php echo $f->id; ?>"]</td>
				<td><?php echo $f->name; ?></td>					
			</tr>
			
		<?php endforeach; ?>

		<?php if (empty($flag)): ?>
			<tr>
				<td colspan="2">There are not map.</td>
			</tr>
		<?php endif; ?>
		
	</table>