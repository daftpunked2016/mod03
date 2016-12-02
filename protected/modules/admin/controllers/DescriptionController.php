<?php

class DescriptionController extends Controller
{
	public $layout = '/layouts/main';

	public function actionEdit($id)
	{
		$model = PeaDescriptions::model()->findbyPK($id);

		if(isset($_POST['PeaDescriptions']))
		{
			$model->attributes=$_POST['PeaDescriptions'];

			if($model->qty == "T")
			{
				if($model->save())
				{
					Yii::app()->user->setFlash('success','Description update Complete!');
					$this->redirect(array('default/subcategory','id'=>$model->sub_id));
				}
			}else{
				$model->range = null;
				if($model->save())
				{
					Yii::app()->user->setFlash('success','Description update Complete!');
					$this->redirect(array('default/subcategory','id'=>$model->sub_id));
				}
			}
			
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionAdd($id)
	{	
		$subcat = PeaSubcat::model()->findbyPK($id);
		$description = new PeaDescriptions;

		$this->performAjaxValidation($description);

		if(isset($_POST['PeaDescriptions']))
		{
			$description->attributes=$_POST['PeaDescriptions'];

			$valid = $description->validate();
			$valid = $description->validate() && $valid;			

			if($valid)
			{
				$connection = Yii::app()->db;
				$transaction = $connection->beginTransaction();

				$description->sub_id = $id;
				$description->order_no = count(PeaDescriptions::model()->findAll()) + 1;

				if($_POST['PeaDescriptions']['qty'] == "T")
				{
					$description->range = $_POST['PeaDescriptions']['range'];
				}else{
					$description->range = null;
				}

				if($description->save())
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success','Creating Description Complete!');
					$this->redirect(array('default/subcategory', 'id'=>$id));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'An error occurred while trying to add a description! Please try again later.');
					$this->redirect(array('default/subcategory', 'id'=>$id));
				}
			}
		}

		$this->render('create',array(
			'model'=>$description,
			'subcat'=>$subcat,
		));
	}

	protected function performAjaxValidation($description)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='description-form')
		{
			echo CActiveForm::validate($description);
			Yii::app()->end();
		}
	}
}