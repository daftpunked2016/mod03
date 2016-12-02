<?php
/* @var $this EtrainingScorecardController */
/* @var $model EtrainingScorecard */

$this->breadcrumbs=array(
	'Etraining Scorecards'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List EtrainingScorecard', 'url'=>array('index')),
	array('label'=>'Create EtrainingScorecard', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#etraining-scorecard-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Etraining Scorecards</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'etraining-scorecard-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'category',
		'measure',
		'item_code',
		'pea_code',
		'goal_point',
		/*
		'pair',
		'notes',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
