<section class="content-header">
	<h1>
		Create eTraining Score card
		<small>form</small>
	</h1>
</section>

<section class="content">
	<div class="box">
		<div class="box-header with-border">
			<?php echo CHtml::link('<i class="fa fa-chevron-left"></i>', array('etrainingScorecard/index'), array('title'=>'Back', 'class'=>'btn btn-default btn-flat', 'confirm'=>'Are you sure you want to Discard all of your changes?')); ?>
			Create
		</div>
		<div class="box-body">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
		<div class="box-footer">Create</div>
	</div>
</section>