<tr>
	<td><?php echo CHtml::encode($data->category); ?></td>
	<td><?php echo CHtml::encode($data->pea_code); ?></td>
	<td><?php echo CHtml::encode($data->measure); ?></td>
	<td><?php echo CHtml::encode($data->goal_point); ?></td>
	<td class="text-center">
		<!-- <div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span class="fa fa-cog"></span> <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
				<li>
					<?php
						//echo CHtml::link('<span class="fa fa-edit"></span> Edit', array('etrainingScorecard/update', 'id'=>$data->id), array('title' => 'Edit Training'));
					?>
				</li>
				<li>
					<?php
						//echo CHtml::link('<span class="fa fa-exclamation"></span> Delete', array('etrainingScorecard/delete', 'id'=>$data->id), array('title' => 'Delete Training', 'confirm'=>'Are you sure you want to Delete this Training Score card?'));
					?>
				</li>
			</ul>
		</div> -->
		<?php echo CHtml::link('<i class="fa fa-edit"></i> Edit' ,array('etrainingScorecard/update', 'id'=>$data->id), array('class'=>'btn-sm btn-primary')); ?>
	</td>
</tr>