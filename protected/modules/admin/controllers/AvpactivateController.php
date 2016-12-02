<?php

class AvpactivateController extends Controller
{
	public $layout = '/layouts/main';

	public function actionActivate()
	{
		$avpactivate = PeaAvpActivate::model()->find();

		if($avpactivate != null)
		{
			$avpactivate->status_id = 1;

			if($avpactivate->save())
			{
				Yii::app()->user->setFlash('success','AVP Activation Complete!');
				$this->redirect(array('default/index'));
			}
		}
	}

	public function actionDeactivate()
	{
		$avpactivate = PeaAvpActivate::model()->find();

		if($avpactivate != null)
		{
			$avpactivate->status_id = 2;

			if($avpactivate->save())
			{
				Yii::app()->user->setFlash('success','AVP Deactivation Complete!');
				$this->redirect(array('default/index'));
			}
		}
	}
}