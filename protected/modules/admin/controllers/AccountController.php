<?php

class AccountController extends Controller
{
	public $layout = '/layouts/main';

	public function actionActiveIndex()
	{
		$active = Account::model()->isUser()->isActive()->findAll();

		$activeDP=new CArrayDataProvider($active, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('activeindex', array(
			'activeDP' => $activeDP,
		));
	}

	public function actionInactiveIndex()
	{
		$Inactive = Account::model()->isUser()->isInactive()->findAll();

		$inactiveDP=new CArrayDataProvider($Inactive, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('inactiveindex', array(
			'inactiveDP' => $inactiveDP,
		));
	}

	public function actionDeactivate($id)
	{
		$account = Account::model()->findByPk($id);

		if(isset($account))
		{
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();

			$account->status = 2;

			if($account->save())
			{	
				$transaction->commit();
				Yii::app()->user->setFlash('success','Account Deactivation COMPLETE!');
				$this->redirect(array('account/activeindex'));
			}
			else
			{
				Yii::app()->user->setFlash('error','Account Deactivation FAILED!');
				$this->redirect(array('account/activeindex'));
			}
		}
	}

	public function actionActivate($id)
	{
		$account = Account::model()->findByPk($id);

		if(isset($account))
		{
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();

			$account->status = 1;

			if($account->save())
			{	
				$transaction->commit();
				Yii::app()->user->setFlash('success','Account Activation COMPLETE!');
				$this->redirect(array('account/inactiveindex'));
			}
			else
			{
				Yii::app()->user->setFlash('error','Account Activation FAILED!');
				$this->redirect(array('account/inactiveindex'));
			}
		}
	}

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
}