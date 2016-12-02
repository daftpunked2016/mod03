<?php $scores = EtrainingScorecard::model()->getAreaCount2($data->pea_code); ?>
<tr class="scorecard">
	<td><?php echo CHtml::encode($data->pea_code); ?></td>
	<td><?php echo CHtml::encode($data->measure); ?></td>
	<td class="text-center area-count" data-val="<?php if(isset($scores[$area])) echo $scores[$area]; else echo 0;?>">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/trainers/default/region?area_no=<?php echo $area; ?>&card_id=<?php echo $data->id; ?>">
			<?php 
				if(isset($scores[$area])) echo $scores[$area]; else echo 0;
			?>
		</a>
	</td>
</tr>