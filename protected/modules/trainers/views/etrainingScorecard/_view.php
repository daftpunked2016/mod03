<?php
/* @var $this EtrainingScorecardController */
/* @var $data EtrainingScorecard */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category')); ?>:</b>
	<?php echo CHtml::encode($data->category); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('measure')); ?>:</b>
	<?php echo CHtml::encode($data->measure); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_code')); ?>:</b>
	<?php echo CHtml::encode($data->item_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pea_code')); ?>:</b>
	<?php echo CHtml::encode($data->pea_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('goal_point')); ?>:</b>
	<?php echo CHtml::encode($data->goal_point); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pair')); ?>:</b>
	<?php echo CHtml::encode($data->pair); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	*/ ?>

</div>