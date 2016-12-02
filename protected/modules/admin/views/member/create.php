<?php
/* @var $this MemberController */
/* @var $model Member */

$this->breadcrumbs=array(
	'Members'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Member', 'url'=>array('index')),
	array('label'=>'Manage Member', 'url'=>array('admin')),
);
?>

<div class="content-wrapper">
	<section class="content-header">
		<h1>Create Member</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-lg-6">
				<?php $this->renderPartial('_form', array('model'=>$model)); ?>
			</div>
		</div>
	</section>
</div>