<script type="text/javascript">
$(function() {

	if($('#qty').val() === "T")
	{
		$("#range").show();
	}

	$('#qty').change(function()
	{
		if($(this).val() === "T") {
			$("#range").fadeIn();
		} else {
			$("#range").fadeOut();
		}
	});
});
</script>

<section class="content-header">
	<?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
		if($key  === 'success')
			{
			echo "<div class='alert alert-success alert-dismissible' role='alert'>
			<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
			$message.'</div>';
			}
		else
			{
			echo "<div class='alert alert-danger alert-dismissible' role='alert'>
			<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
			$message.'</div>';
			}
		}
	?>
	<h1 class="text-center">
		<?php echo $model->rep_id; ?>
		<small><?php echo $model->description; ?></small>
	</h1>
</section>

<section class="content">
	<div class="row">
		<div class="content">
			<div class="box">
				<?php
				/* @var $this AccountController */
				/* @var $model Account */
				/* @var $form CActiveForm */
				?>


				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'account-form',
					// Please note: When you enable ajax validation, make sure the corresponding
					// controller action is handling ajax validation correctly.
					// There is a call to performAjaxValidation() commented in generated controller code.
					// See class documentation of CActiveForm for details on this.
					'enableAjaxValidation'=>false,
				)); ?>

				<p class="note text-center">Fields with <span class="required">*</span> are required.</p>

				<?php echo $form->errorSummary($model); ?>
				
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'rep_id'); ?>
						<?php echo $form->textField($model,'rep_id',array('class'=>'form-control', 'size'=>40,'maxlength'=>40)); ?>
						<?php echo $form->error($model,'rep_id'); ?>
					</div>

					<div class="form-group">
						<?php echo $form->labelEx($model,'description'); ?>
						<?php echo $form->textArea($model,'description', array('class'=>'form-control', 'maxlength' => 300, 'rows' => 6, 'cols' => 50, 'style' =>'resize:none;')); ?>
						<?php echo $form->error($model,'description'); ?>
					</div>

					<div class="form-group">
						<?php echo $form->labelEx($model,'goal'); ?>
						<?php echo $form->textArea($model,'goal', array('class'=>'form-control', 'maxlength' => 300, 'rows' => 6, 'cols' => 50, 'style' =>'resize:none;')); ?>
						<?php echo $form->error($model,'goal'); ?>
					</div>

					<div class="form-group">
						<?php echo $form->labelEx($model,'criteria'); ?>
						<?php echo $form->textArea($model,'criteria', array('class'=>'form-control', 'maxlength' => 300, 'rows' => 6, 'cols' => 50, 'style' =>'resize:none;')); ?>
						<?php echo $form->error($model,'criteria'); ?>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'details'); ?>
						<?php echo $form->textArea($model,'details', array('class'=>'form-control', 'maxlength' => 300, 'rows' => 6, 'cols' => 50, 'style' =>'resize:none;')); ?>
						<?php echo $form->error($model,'details'); ?>
					</div>

					<div class="form-group">
						<?php echo $form->labelEx($model,'remarks'); ?>
						<?php echo $form->textArea($model,'remarks', array('class'=>'form-control', 'maxlength' => 300, 'rows' => 6, 'cols' => 50, 'style' =>'resize:none;')); ?>
						<?php echo $form->error($model,'remarks'); ?>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<?php echo $form->labelEx($model,'goal_point'); ?>
							<?php echo $form->textField($model,'goal_point', array('class'=>'form-control', 'maxlength' => 2,)); ?>
							<?php echo $form->error($model,'goal_point'); ?>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<?php echo $form->labelEx($model,'criteria_point'); ?>
							<?php echo $form->textField($model,'criteria_point', array('class'=>'form-control', 'maxlength' => 2,)); ?>
							<?php echo $form->error($model,'criteria_point'); ?>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<?php echo $form->labelEx($model,'max'); ?>
							<?php echo $form->textField($model,'max', array('class'=>'form-control', 'maxlength' => 2,)); ?>
							<?php echo $form->error($model,'max'); ?>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="col-lg-4">
						<div class="form-group">
							<?php echo $form->labelEx($model,'qty'); ?>
							<?php echo $form->dropDownList($model,'qty',array('T'=>'True','F'=>'False'), array('class'=>'form-control', 'prompt' => 'Select Quantity Restriction', 'id'=>'qty')); ?>
							<?php echo $form->error($model,'qty'); ?>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group" style="display:none;" id='range'>
							<?php echo $form->labelEx($model,'range'); ?>
							<?php echo $form->textField($model,'range', array('class'=>'form-control', 'prompt' => 'Select Quantity Restriction')); ?>
							<?php echo $form->error($model,'range'); ?>
						</div>
					</div>
					
					<div class="col-lg-4">
						<div class="form-group">
							<?php echo $form->labelEx($model,'color'); ?>
							<?php echo $form->dropDownList($model,'color',array('BLACK'=>'Black','GREEN'=>'Green', 'BLUE'=>'Blue'), array('class'=>'form-control', 'prompt' => 'Select Color Restriction')); ?>
							<?php echo $form->error($model,'color'); ?>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="form-group">
						<div class="text-center">
							<?php echo CHtml::link('Back', array('default/subcategory', 'id'=>$model->sub_id), array('class'=>'btn-sm btn-warning', 'confirm'=>'Are you sure you want to go back and discard your changes?')) ?>
							<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
						</div>
					</div>
				</div>

			<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</section>
