<?php
/* @var $this EtrainingScorecardController */
/* @var $model EtrainingScorecard */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'etraining-scorecard-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="col-md-6">
		<div class="form-group">
			<?php echo $form->labelEx($model,'category'); ?>
			<?php echo $form->textField($model,'category',array('size'=>60,'maxlength'=>72, 'class'=>'form-control', 'placeholder'=>'Category')); ?>
			<?php echo $form->error($model,'category', array('class'=>'text-red')); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model,'measure'); ?>
			<?php echo $form->textField($model,'measure',array('size'=>60,'maxlength'=>97, 'class'=>'form-control', 'placeholder'=>'Measure')); ?>
			<?php echo $form->error($model,'measure', array('class'=>'text-red')); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model,'item_code'); ?>
			<?php echo $form->textField($model,'item_code',array('size'=>3,'maxlength'=>3, 'class'=>'form-control', 'placeholder'=>'Item Code')); ?>
			<?php echo $form->error($model,'item_code', array('class'=>'text-red')); ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?php echo $form->labelEx($model,'pea_code'); ?>
			<?php echo $form->textField($model,'pea_code',array('size'=>4,'maxlength'=>4, 'class'=>'form-control', 'placeholder'=>'Rep ID')); ?>
			<?php echo $form->error($model,'pea_code', array('class'=>'text-red')); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model,'goal_point'); ?>
			<?php echo $form->textField($model,'goal_point',array('size'=>5,'maxlength'=>5, 'class'=>'form-control', 'placeholder'=>'Goal Point')); ?>
			<?php echo $form->error($model,'goal_point', array('class'=>'text-red')); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model,'notes'); ?>
			<?php echo $form->textField($model,'notes',array('size'=>60,'maxlength'=>88, 'class'=>'form-control', 'placeholder'=>'Notes / Remarks')); ?>
			<?php echo $form->error($model,'notes', array('class'=>'text-red')); ?>
		</div>

		<div class="form-group pull-right">
			<?php echo CHtml::link('Back', array('etrainingScorecard/index'), array('title'=>'Back', 'class'=>'btn btn-warning btn-flat', 'confirm'=>'Are you sure you want to Discard all of your changes?')); ?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary btn-flat')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->