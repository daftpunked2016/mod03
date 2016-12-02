<tr>
	<td><?php echo CHtml::encode($data->rep_id); ?></td>
	<td><?php echo CHtml::encode($data->description); ?></td>
	<td><?php echo CHtml::encode($data->goal); ?></td>
	<td><?php echo CHtml::encode($data->criteria); ?></td>
	<td><?php echo CHtml::encode($data->details); ?></td>
	<td><?php echo CHtml::encode($data->goal_point); ?></td>
	<td><?php echo CHtml::encode($data->criteria_point); ?></td>
	<td><?php echo CHtml::encode($data->max); ?></td>
	<td>
		<?php echo CHtml::link('<span class="btn-sm btn-success">Edit</span>', array('/admin/description/edit', 'id' => $data->rep_id), array('class' => 'btn', 'title' => 'Edit Description', 'confirm'=>'Are you sure you want to edit this description?')); ?>
	</td>
</tr>