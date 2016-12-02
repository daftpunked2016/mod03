<?php $scores = EtrainingScorecard::model()->getRegionCount2($data->pea_code, $region->id); ?>
<tr class="scorecard">
	<td><?php echo CHtml::encode($data->pea_code); ?></td>
	<td><?php echo CHtml::encode($data->measure); ?></td>
	<td class="text-center">
		<?php 
			if(isset($scores[$region->id])) {
				// echo $scores[$data->id];
				echo CHtml::button($scores[$region->id], array('class'=>'btn btn-default btn-flat trainers-list-chapters', 'data-reg_id'=>$region->id, 'data-rep_id'=>$data->pea_code));
			}else{
				echo CHtml::button("0", array('class'=>'btn btn-default btn-flat disabled'));
			}
		?>
	</td>
</tr>