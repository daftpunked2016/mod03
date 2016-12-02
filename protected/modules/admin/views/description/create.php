<script type="text/javascript">
$(function() {

	if($('#qty').val() === "T")
	{
		$("#range").show();
	}

	$('#qty').change(function()
	{
		if($(this).val() === "T") {
			$('#range2').addClass('report');
			$("#range").fadeIn();
		} else {
			$("#range").fadeOut();
			$('#range2').removeClass('report');
		}
	});
});

function createDescription(){
	errors = 0;

	$( ".report" ).each(function( index ) {
		if ($(this).val() === "") {
		  	$(this).next("span").html( "<b>Required!</b>" ).show().delay(6000).fadeOut( 6000 );
	      	errors++;
	    }
	});

	if (errors>0){
		alert("Please fill out all fields.");
		return false;
	}else{
		$('#description-form').submit();
	}
	
	event.eventPreventDefault();
}

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
		<?php echo $subcat->SubCat; ?></br>
		<small>CREATE DESCRIPTION</small>
		</br>
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
					'id'=>'description-form',
					// Please note: When you enable ajax validation, make sure the corresponding
					// controller action is handling ajax validation correctly.
					// There is a call to performAjaxValidation() commented in generated controller code.
					// See class documentation of CActiveForm for details on this.
					'enableAjaxValidation'=>false,
				)); ?>

				<p class="note text-center">Fields with <span class="required">*</span> are required.</p>

				<div class="text-center">
					<font color='red'><?php echo $form->errorSummary($model); ?></font>
				</div>
				
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'rep_id'); ?>
						<?php echo $form->textField($model,'rep_id',array('class'=>'report form-control', 'size'=>40,'maxlength'=>40, 'placeholder'=>'Annex ID')); ?>
						<?php echo $form->error($model,'rep_id', array('style'=>'color:red;')); ?>
						<span class="label label-danger"></span>
					</div>

					<div class="form-group">
						<?php echo $form->labelEx($model,'description'); ?>
						<?php echo $form->textArea($model,'description', array('class'=>'report form-control', 'maxlength' => 300, 'rows' => 6, 'cols' => 50, 'style' =>'resize:none;', 'placeholder'=>'Description')); ?>
						<?php echo $form->error($model,'description', array('style'=>'color:red;')); ?>
						<span class="label label-danger"></span>
					</div>

					<div class="form-group">
						<?php echo $form->labelEx($model,'goal'); ?>
						<?php echo $form->textArea($model,'goal', array('class'=>'report form-control', 'maxlength' => 300, 'rows' => 6, 'cols' => 50, 'style' =>'resize:none;', 'placeholder'=>'Goal')); ?>
						<?php echo $form->error($model,'goal', array('style'=>'color:red;')); ?>
						<span class="label label-danger"></span>
					</div>

					<div class="form-group">
						<?php echo $form->labelEx($model,'criteria'); ?>
						<?php echo $form->textArea($model,'criteria', array('class'=>'form-control', 'maxlength' => 300, 'rows' => 6, 'cols' => 50, 'style' =>'resize:none;', 'placeholder'=>'Criteria')); ?>
						<?php echo $form->error($model,'criteria', array('style'=>'color:red;')); ?>
						<span class="label label-danger"></span>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'details'); ?>
						<?php echo $form->textArea($model,'details', array('class'=>'report form-control', 'maxlength' => 300, 'rows' => 6, 'cols' => 50, 'style' =>'resize:none;', 'placeholder'=>'Details')); ?>
						<?php echo $form->error($model,'details', array('style'=>'color:red;')); ?>
						<span class="label label-danger"></span>
					</div>

					<div class="form-group">
						<?php echo $form->labelEx($model,'remarks'); ?>
						<?php echo $form->textArea($model,'remarks', array('class'=>'report form-control', 'maxlength' => 300, 'rows' => 6, 'cols' => 50, 'style' =>'resize:none;', 'placeholder'=>'Remarks')); ?>
						<?php echo $form->error($model,'remarks', array('style'=>'color:red;')); ?>
						<span class="label label-danger"></span>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<?php echo $form->labelEx($model,'goal_point'); ?>
							<?php echo $form->textField($model,'goal_point', array('class'=>'quantity report form-control', 'maxlength' => 2, 'placeholder'=>'Goal Point')); ?>
							<?php echo $form->error($model,'goal_point', array('style'=>'color:red;')); ?>
							<span class="label label-danger"></span>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<?php echo $form->labelEx($model,'criteria_point'); ?>
							<?php echo $form->textField($model,'criteria_point', array('class'=>'quantity report form-control', 'maxlength' => 2, 'placeholder'=>'Criteria Point')); ?>
							<?php echo $form->error($model,'criteria_point', array('style'=>'color:red;')); ?>
							<span class="label label-danger"></span>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<?php echo $form->labelEx($model,'max'); ?>
							<?php echo $form->textField($model,'max', array('class'=>'quantity report form-control', 'maxlength' => 2, 'placeholder'=>'Max Point')); ?>
							<?php echo $form->error($model,'max', array('style'=>'color:red;')); ?>
							<span class="label label-danger"></span>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="col-lg-4">
						<div class="form-group">
							<?php echo $form->labelEx($model,'qty'); ?>
							<?php echo $form->dropDownList($model,'qty',array('T'=>'True','F'=>'False'), array('class'=>'report form-control', 'prompt' => 'Select Quantity Restriction', 'id'=>'qty')); ?>
							<?php echo $form->error($model,'qty', array('style'=>'color:red;')); ?>
							<span class="label label-danger"></span>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group" style="display:none;" id='range'>
							<?php echo $form->labelEx($model,'range'); ?>
							<?php echo $form->textField($model,'range', array('class'=>'quantity form-control', 'prompt' => 'Select Quantity Restriction', 'id'=>'range2')); ?>
							<?php echo $form->error($model,'range', array('style'=>'color:red;')); ?>
							<span class="label label-danger"></span>
						</div>
					</div>
					
					<div class="col-lg-4">
						<div class="form-group">
							<?php echo $form->labelEx($model,'color'); ?>
							<?php echo $form->dropDownList($model,'color',array('BLACK'=>'Black','GREEN'=>'Green', 'BLUE'=>'Blue'), array('class'=>'report form-control', 'prompt' => 'Select Color Restriction')); ?>
							<?php echo $form->error($model,'color', array('style'=>'color:red;')); ?>
							<span class="label label-danger"></span>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="form-group">
						<div class="text-center">
							<?php echo CHtml::link('Back', array('default/subcategory', 'id'=>$subcat->sub_id), array('class'=>'btn btn-warning', 'confirm'=>'Are you sure you want to go back and discard your changes?')) ?>
							<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
							<a class='btn btn-primary' onClick="createDescription()">Create</a>
						</div>
					</div>
				</div>

			<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</section>
