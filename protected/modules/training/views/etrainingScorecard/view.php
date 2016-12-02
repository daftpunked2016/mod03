<?php
/* @var $this EtrainingScorecardController */
/* @var $model EtrainingScorecard */

$this->breadcrumbs=array(
	'Etraining Scorecards'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EtrainingScorecard', 'url'=>array('index')),
	array('label'=>'Create EtrainingScorecard', 'url'=>array('create')),
	array('label'=>'Update EtrainingScorecard', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EtrainingScorecard', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EtrainingScorecard', 'url'=>array('admin')),
);
?>

<h1>View EtrainingScorecard #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'category',
		'measure',
		'item_code',
		'pea_code',
		'goal_point',
		'pair',
		'notes',
	),
)); ?>
