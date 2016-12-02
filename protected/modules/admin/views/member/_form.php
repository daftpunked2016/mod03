<?php
/* @var $this MemberController */
/* @var $model Member */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'member-form',
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	)); 
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email_address'); ?>
		<?php echo $form->textField($model,'email_address',array('class'=>'form-control', 'size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('class'=>'form-control', 'size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('class'=>'form-control', 'size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'middlename'); ?>
		<?php echo $form->textField($model,'middlename',array('class'=>'form-control', 'size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'middlename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->dropDownList($model,'gender',array('M'=>'Male','F'=>'Female'), array('class'=>'form-control', 'prompt' => 'Select Gender')); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birthdate'); ?>
		<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model' => $model,
				'attribute' => 'birthdate',
				'options'=>array(
					'showAnim'=>'slideDown',
					'yearRange'=>'-60:-18',
					'changeMonth' => true,
					'changeYear' => true,
					'dateFormat' => 'yy-mm-dd'
					),
				'htmlOptions' => array(
					'size' => 20,         // textField size
					'class' => 'form-control',
				),	
			));
		?>
		<?php echo $form->error($model,'birthdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('class'=>'form-control', 'size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_number'); ?>
		<?php echo $form->textField($model,'contact_number',array('class'=>'form-control', 'size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'contact_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->dropDownList($model,'title',array('1'=>'JCI SENATOR','2'=>'JCI MEMBER'), array('class'=>'form-control', 'prompt' => 'Select Title')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
        <label for="pos_category">Position Category *</label>
        <select id="pos_category" name="pos_category" class="form-control" required>
          <option value =''> - Select Category - </option>
          <option value ='Local'> Local </option>
          <option value ='National'> National </option>
        <select>
     </div>


	<div class="row">
		<label for="position_id">Position *</label>
		<select id="position_id" name="Member[position_id]" class="form-control" required>
			<option value =''> - Select Position - </option>
		<select>		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'batch_name'); ?>
		<?php echo $form->textField($model,'batch_name',array('class'=>'form-control', 'size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'batch_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'induct_year'); ?>
		<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model' => $model,
				'attribute' => 'induct_year',
				'options'=>array(
					'showAnim'=>'slideDown',
					'yearRange'=>'-60:-18',
					'changeMonth' => true,
					'changeYear' => true,
					'dateFormat' => 'Y'
					),
				'htmlOptions' => array(
					'size' => 20,         // textField size
					'class' => 'form-control',
				),	
			));
		?>
		<?php echo $form->error($model,'induct_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'member_avatar'); ?>
		<?php echo $form->fileField($model,'member_avatar'); ?>
		<?php echo $form->error($model,'member_avatar'); ?>
	</div>
</br>
	<div class="row">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'form-control btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->