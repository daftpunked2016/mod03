<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->redirect(array('site/login'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{	
		$this->layout ='login';
		
		if(Yii::app()->user->id === null)
		{
			$model=new LoginForm;

			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}

			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login())
					$this->redirect(array('/account/listscoring'));
			}
			// display the login form
			$this->render('login',array('model'=>$model));
		}
		else
			$this->redirect(array('/account/index'));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		if(isset($_SESSION['token']))
			unset($_SESSION['token']);

		Yii::app()->user->logout(false);
		// Yii::app()->session->open();
		Yii::app()->user->setFlash('success','You have successfully logged out your account.');
		$this->redirect('login');
	}

	public function actionDashboard()
	{
		$user = User::model()->find(array('condition'=>'account_id = :id', 'params'=>array(':id'=>Yii::app()->user->id)));
		$categories = PeaCategory::model()->findAll();

		switch ($user->position_id) {
			case 8:
				// AVP
				$ano = $user->chapter->area_no;
				$regions = AreaRegion::model()->findAll(array('condition'=>'area_no = :ano', 'params'=>array(':ano'=>$ano)));
				$regionsDP=new CArrayDataProvider($regions, array(
					'pagination' => array(
						'pageSize' => 10
					),
				));

				$this->render('avp_dashboard', array(
					'regionsDP'=>$regionsDP,
					'ano'=>$ano,
				));
				break;
			case 9:
				// RVP
				$rid = $user->chapter->region_id;
				$region = AreaRegion::model()->findByPk($rid);
				$chapters = Chapter::model()->findAll(array('condition'=>'region_id = :rid', 'params'=>array(':rid'=>$rid)));
				$chaptersDP=new CArrayDataProvider($chapters, array(
					'pagination' => array(
						'pageSize' => 20
					),
				));

				$this->render('rvp_dashboard', array(
					'chaptersDP'=>$chaptersDP,
					'region'=>$region,
				));
				break;
			default:
				// PRES
				$this->render('pres_dashboard', array(
					'user'=>$user,
					'categories'=>$categories,
				));
				break;
		}
	}

	public function actionChapterReport($rid)
	{
		$region = AreaRegion::model()->findByPk($rid);
		$chapters = Chapter::model()->findAll(array('condition'=>'region_id = :rid', 'params'=>array(':rid'=>$rid)));
		$chaptersDP=new CArrayDataProvider($chapters, array(
			'pagination' => array(
				'pageSize' => 20
			),
		));

		$this->render('chapterreport', array(
			'chaptersDP'=>$chaptersDP,
			'region'=>$region,
		));
	}
}