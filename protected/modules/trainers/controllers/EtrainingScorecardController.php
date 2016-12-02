<?php

class EtrainingScorecardController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function actionRanking()
	{	
		$trainer = User::model()->find(array('condition'=>'account_id = :aid', 'params'=>array(':aid'=>Yii::app()->getModule('trainers')->user->id)));
		$count = null;

		switch ($trainer->training_position_id) {
			case 2:
				$area = $trainer->chapter->area_no;
				$region_id = null;
				$rankScorer = new RankScorer($area, $region_id, $count);
				break;
			case 3:
				$area = $trainer->chapter->area_no;
				$region_id = $trainer->chapter->region_id;
				$rankScorer = new RankScorer($area, $region_id, $count);
				break;
			case 4:
				# code...
				break;
		}

		$ranking = $rankScorer->ranking_prop;

		$rankingDP = new CArrayDataProvider($ranking, array(
			'pagination' => false,
		));
		
		$this->render('ranking',array(
			'rankingDP'=>$rankingDP,
			'area'=>$area,
			'count'=>$count,
			'trainer'=>$trainer,
			'region'=>$trainer->chapter->region,
		));
	}

	public function actionPrintScore()
	{
		$rankScorer = new RankScorer();
		$ranking = $rankScorer->ranking_prop;

		echo "<pre>";
		print_r($rankScorer->getScoreCollection());
		echo "</pre>";
		exit;
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new EtrainingScorecard;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EtrainingScorecard']))
		{
			$model->attributes=$_POST['EtrainingScorecard'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', 'Training Score card Registration Complete!');
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EtrainingScorecard']))
		{
			$model->attributes=$_POST['EtrainingScorecard'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', 'Update Training Score card Complete!');
				$this->redirect(array('etrainingScorecard/index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$card = EtrainingScorecard::model()->findByPk($id);

		echo "<pre>";
		print_r($card);
		echo "<pre>";
		exit;
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$cards = EtrainingScorecard::model()->findAll();
		$cardsDP=new CArrayDataProvider($cards, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('index', array(
			'cardsDP'=>$cardsDP,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new EtrainingScorecard('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EtrainingScorecard']))
			$model->attributes=$_GET['EtrainingScorecard'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EtrainingScorecard the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=EtrainingScorecard::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EtrainingScorecard $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='etraining-scorecard-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
