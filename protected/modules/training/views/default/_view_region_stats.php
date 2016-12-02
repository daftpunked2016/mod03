<tr>
	<td><?php echo AreaRegion::model()->getRegion($data->id); ?></td>
	<td>
		<?php 
			if(isset($scores[$data->id])) {
				// echo $scores[$data->id];
				echo CHtml::button($scores[$data->id], array('class'=>'btn btn-default btn-flat list-chapters', 'data-reg_id'=>$data->id, 'data-rep_id'=>$pea_code));
			}else{
				echo CHtml::button("0", array('class'=>'btn btn-default btn-flat disabled'));
			}
		?>
	</td>
</tr>