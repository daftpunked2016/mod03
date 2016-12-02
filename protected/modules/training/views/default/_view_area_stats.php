<?php $scores = EtrainingScorecard::model()->getAreaCount2($data->pea_code); ?>
<tr class="scorecard">
	<td><?php echo CHtml::encode($data->pea_code); ?></td>
	<td><?php echo CHtml::encode($data->measure); ?></td>
	<td class="text-center area-count" data-val="<?php if(isset($scores[1])) echo $scores[1]; else echo 0;?>">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/training/default/region?area_no=1&card_id=<?php echo $data->id; ?>">
			<?php 
				if(isset($scores[1])) echo $scores[1]; else echo 0;
			?>
		</a>
	</td>
	<td class="text-center area-count" data-val="<?php if(isset($scores[2])) echo $scores[2]; else echo 0;?>">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/training/default/region?area_no=2&card_id=<?php echo $data->id; ?>">
			<?php if(isset($scores[2])) echo $scores[2]; else echo 0; ?>
		</a>
	</td>
	<td class="text-center area-count" data-val="<?php if(isset($scores[3])) echo $scores[3]; else echo 0;?>">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/training/default/region?area_no=3&card_id=<?php echo $data->id; ?>">
			<?php if(isset($scores[3])) echo $scores[3]; else echo 0; ?>
		</a>
	</td>
	<td class="text-center area-count" data-val="<?php if(isset($scores[4])) echo $scores[4]; else echo 0;?>">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/training/default/region?area_no=4&card_id=<?php echo $data->id; ?>">
			<?php if(isset($scores[4])) echo $scores[4]; else echo 0; ?>
		</a>
	</td>
	<td class="text-center area-count" data-val="<?php if(isset($scores[5])) echo $scores[5]; else echo 0;?>">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/training/default/region?area_no=5&card_id=<?php echo $data->id; ?>">
			<?php if(isset($scores[5])) echo $scores[5]; else echo 0; ?>
		</a>
	</td>
	<td class="text-center" id="total-count">
		<!-- computed by jquery -->
	</td>
</tr>