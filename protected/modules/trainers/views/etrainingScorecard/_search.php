<?php
/* @var $this EtrainingScorecardController */
/* @var $model EtrainingScorecard */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'category'); ?>
		<?php echo $form->textField($model,'category',array('size'=>60,'maxlength'=>72)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'measure'); ?>
		<?php echo $form->textField($model,'measure',array('size'=>60,'maxlength'=>97)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'item_code'); ?>
		<?php echo $form->textField($model,'item_code',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pea_code'); ?>
		<?php echo $form->textField($model,'pea_code',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'goal_point'); ?>
		<?php echo $form->textField($model,'goal_point',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pair'); ?>
		<?php echo $form->textField($model,'pair'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'notes'); ?>
		<?php echo $form->textField($model,'notes',array('size'=>60,'maxlength'=>88)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->