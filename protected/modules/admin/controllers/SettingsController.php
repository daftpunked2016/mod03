<?php

class SettingsController extends Controller
{
	public $layout = '/layouts/main';

	public function actionIndex()
	{
		$settings = PeaSettings::model()->find();

		if (isset($_POST['PeaSettings'])) {

			$settings->attributes = $_POST['PeaSettings'];

			$valid = $settings->validate();
			$valid = $settings->validate() && $valid;

			if ($valid) {
				try {
					$transaction = Yii::app()->db->beginTransaction();
					if ($settings->save()) {
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'You have successfully change the Settings.');
						$this->redirect(array('settings/index'));
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('danger', 'An error has occurred while trying to change the Settings.');
					$this->redirect(array('settings/index'));
				}
			}
		}

		$this->render('index', array(
			'settings' => $settings,
		));
	}
}