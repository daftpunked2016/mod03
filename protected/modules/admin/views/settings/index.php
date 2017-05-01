<section class="content-header">
	<h1>
		Settings
		<small>dashboard</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Settings', array('settings/index')); ?>
		</li>
		<li class="active">Dashboard</li>
	</ol>
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
</section>

<section class="content">
	<div class="box box-solid">
		<div class="box-body">
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'settings-form',
				// Please note: When you enable ajax validation, make sure the corresponding
				// controller action is handling ajax validation correctly.
				// There is a call to performAjaxValidation() commented in generated controller code.
				// See class documentation of CActiveForm for details on this.
				'enableAjaxValidation'=>true,
				)); 
			?>
			<div class="form">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<span class="fa fa-cogs"></span>
							<?php echo $form->labelEx($settings,'pres_approval'); ?>
							<br>
							<?php echo $form->radioButtonList($settings,'pres_approval', 
								array(1=>'Enabled', 2=>'Disabled'),
								array(
							   		// 'labelOptions'=>array('style'=>'display:block;'), // add this code
						    		// 'separator'=>'&nbsp;&nbsp;&nbsp;',
						    )); ?>
							<?php echo $form->error($settings,'pres_approval'); ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<span class="fa fa-cogs"></span>
							<?php echo $form->labelEx($settings,'rvp_approval'); ?>
							<br>
							<?php echo $form->radioButtonList($settings,'rvp_approval', 
								array(1=>'Enabled', 2=>'Disabled'),
								array(
							   		// 'labelOptions'=>array('style'=>'display:block;'), // add this code
						    		// 'separator'=>'&nbsp;&nbsp;&nbsp;',
						    )); ?>
							<?php echo $form->error($settings,'rvp_approval'); ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<span class="fa fa-cogs"></span>
							<?php echo $form->labelEx($settings,'avp_approval'); ?>
							<br>
							<?php echo $form->radioButtonList($settings,'avp_approval', 
								array(1=>'Enabled', 2=>'Disabled'),
								array(
							   		// 'labelOptions'=>array('style'=>'display:block;'), // add this code
						    		// 'separator'=>'&nbsp;&nbsp;&nbsp;',
						    )); ?>
							<?php echo $form->error($settings,'avp_approval'); ?>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<span class="fa fa-cogs"></span>
							<?php echo $form->labelEx($settings,'bypass_status'); ?>
							<br>
							<?php echo $form->radioButtonList($settings,'bypass_status', 
								array(1=>'Enabled', 2=>'Disabled'),
								array(
							   		// 'labelOptions'=>array('style'=>'display:block;'), // add this code
						    		// 'separator'=>'&nbsp;&nbsp;&nbsp;',
						    )); ?>
							<?php echo $form->error($settings,'bypass_status'); ?>
						</div>
					</div>
				</div>
			</div><!-- form -->
			<div class="pull-right">
				<?php echo CHtml::submitButton($settings->isNewRecord ? 'Create' : 'Save', array('class'=>'form-control btn-primary', 'confirm'=>'Are you sure you want to change the settings?')); ?>
			</div>
			<?php $this->endWidget(); ?>
		</div>
	</div>
</section>