<a href="<?php echo url("map-fig/layer/addbaselayerapi"); ?>" class="big green add button">Add Baselayer</a>
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
				<a href="<?php echo url("map-fig/layer/edit/" . $f->id); ?>" class="btn button green">Edit</a>
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