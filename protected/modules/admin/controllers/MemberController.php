<?php

class MemberController extends Controller
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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	// public function accessRules()
	// {
	// 	return array(
	// 		array('allow',  // allow all users to perform 'index' and 'view' actions
	// 			'actions'=>array('index','view', 'create'),
	// 			'users'=>array('*'),
	// 		),
	// 		array('allow', // allow authenticated user to perform 'create' and 'update' actions
	// 			'actions'=>array('update'),
	// 			'users'=>array('@'),
	// 		),
	// 		array('allow', // allow admin user to perform 'admin' and 'delete' actions
	// 			'actions'=>array('admin','delete'),
	// 			'users'=>array('admin'),
	// 		),
	// 		array('deny',  // deny all users
	// 			'users'=>array('*'),
	// 		),
	// 	);
	// }

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
		$model=new Member;
		$fileupload = new Fileupload;
		$filerelation = new Filerelation;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Member']))
		{
			$model->attributes=$_POST['Member'];
			$image = $fileupload->filename=CUploadedFile::getInstance($model,'member_avatar');
			$model->member_avatar = $image;

			$valid = $model->validate();
			$valid = $model->validate() && $valid;

			$model->date_created = date('Y-m-d');

			if($valid)
			{
				$connection = Yii::app()->db;
				$transaction = $connection->beginTransaction();
					
				$fileupload->account_id = $model->id;

				//FILE UPLOAD RENAMING
				$name       = $_FILES['Member']['name']['member_avatar'];
				$ext        = pathinfo($name, PATHINFO_EXTENSION);
				$currentDate = date('Ymdhis');
				$newName = 'JCIPH-UA-'.$currentDate.''.$model->id.'.'.$ext;

				//FILE TRANSFER TO SERVER
				$fileupload->filename->saveAs('member_avatars/'.$newName);
				$fileupload->filename = $newName;

				if($fileupload->save(false))
				{
					$filerelation->fileupload_id = $fileupload->id;
					$filerelation->relationship_id = 1; //1 means User Accounts		

					$model->member_avatar = $fileupload->id;

					if($model->save())
					{
						if($filerelation->save())
						{
							$transaction->commit();
							Yii::app()->user->setFlash('success','Member Registration Complete!');
							$this->redirect(array('default/index'));
						}
					}
				}
				else
				{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'An error occurred while trying to register a Member! Please try again later.');
				}
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

		if(isset($_POST['Member']))
		{
			$model->attributes=$_POST['Member'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$members = Member::model()->findAll();

		$memberDP=new CArrayDataProvider($members, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('index',array(
			'memberDP' => $memberDP,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Member('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Member']))
			$model->attributes=$_GET['Member'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Member the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Member::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Member $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='member-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
