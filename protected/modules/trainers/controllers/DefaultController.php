<?php

class DefaultController extends Controller
{
	public $layout = '/layouts/main';

	public function actionIndex()
	{
		$trainer = User::model()->find(array('condition'=>'account_id = :aid', 'params'=>array(':aid'=>Yii::app()->getModule('trainers')->user->id)));

		if ($trainer->training_position_id == 4) {
			Yii::app()->user->setFlash('danger', 'This is a restricted login page.');
			$this->redirect(array('default/logout'));
		}

		$condition = array();

		if (isset($_GET['filters'])) {
			$condition = array('condition'=>'grouping = :filters', 'params'=>array(':filters'=>$_GET['filters']));
		}


		$cards = EtrainingScorecard::model()->findAll($condition);
		$cardsDP=new CArrayDataProvider($cards, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('index', array(
			'cardsDP'=>$cardsDP,
			'area'=>$trainer->chapter->area_no,
			'region'=>$trainer->chapter->region,
			'trainer'=>$trainer,
		));
	}

	public function actionRegion($area_no, $card_id)
	{	
		$card = EtrainingScorecard::model()->findByPk($card_id);
		$regions = AreaRegion::model()->findAll(array('condition'=>'area_no = :area_no', 'params'=>array(':area_no'=>$area_no)));
		$regionsDP=new CArrayDataProvider($regions, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('region_stats', array(
			'regionsDP'=>$regionsDP,
			'card'=>$card,
			'area_no'=>$area_no,
		));
	}

	public function actionLogin()
	{	
		$this->layout ='default/login';
		$model = new AdminLoginForm;
		if(isset($_POST['AdminLoginForm']))
		{
			$model->attributes = $_POST['AdminLoginForm'];
			if ($model->validate() && $model->login())
			{
				// $transaction = new Transaction;
				// $transaction->generateLog(Yii::app()->getModule("admin")->user->id, Transaction::TYPE_LOGIN);
				$this->redirect(array('default/index'));
			}
		}

		$this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		if(isset($_SESSION['token']))
			unset($_SESSION['token']);
			
		Yii::app()->getModule('trainers')->user->logout(false);
		Yii::app()->user->setFlash('success', 'Logout Successful.');
		$this->redirect(Yii::app()->getModule('trainers')->user->loginUrl);
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

	public function actionTrainers($type)
	{
		$users = User::model()->findAll(array('condition'=>'training_position_id = :type', 'params'=>array(':type'=>$type)));

		$usersDP=new CArrayDataProvider($users, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$trainer_type = "";
		if($type == 1) {
			$trainer_type = "National Training Director";
		}elseif ($type == 2) {
			$trainer_type = "Area Training Director";
		}elseif ($type == 3) {
			$trainer_type = "Regional Training Director";
		}elseif ($type == 4) {
			$trainer_type = "Local Training Director";
		}

		$this->render('trainers', array(
			'usersDP' => $usersDP,
			'trainer_type' => $trainer_type,
			'type'=>$type,
		));
	}

	public function actionRender($type)
	{	
		$this->renderPartial('createtrainers', array(
			'type'=>$type
		));
	}

	public function actionCreateTrainer($type)
	{
		$user = User::model()->find(array('condition'=>'account_id = :aid', 'params'=>array(':aid'=>$_POST['member'])));

		if(isset($user)) {
			$user->training_position_id = $type;

			if($user->save(false)) {
				Yii::app()->user->setFlash('success', 'Assigning Trainer Complete!');
				$this->redirect(array('default/trainers', 'type'=>$type));
			}
		}else{
			Yii::app()->user->setFlash('error', 'Assigning Trainer failed!');
				$this->redirect(array('default/trainers', 'type'=>$type));
		}
	}

	public function actionRemove($type, $id)
	{
		$user = User::model()->findByPk($id);

		if(isset($user))
		{
			$user->training_position_id = 0;

			if($user->save(false)) {
				Yii::app()->user->setFlash('success', 'Removing Training Position Complete!');
				$this->redirect(array('default/trainers', 'type'=>$type));
			}
		}else {
			Yii::app()->user->setFlash('error', 'Removing Training Position Failed!');
			$this->redirect(array('default/trainers', 'type'=>$type));
		}
	}

	public function actionListChapters($rep_id, $region_id)
	{
		$chapters = PeaReports::model()
					->with(array(
					    'chapter'=>array(
					        // we don't want to select posts
					        'select'=>false,
					        'condition'=>'chapter.region_id = :region_id', 'params'=>array(':region_id'=>$region_id),
					    ),
					))
					->findAll(array('condition'=>'rep_id = :rid', 'params'=>array(':rid'=>$rep_id)));

		$results = '<table class="table table-hover table-bordered"><tbody>
					    <tr>
					    	<th style="width: 10%">#</th>
					    	<th style="width: 90%">Chapter</th>
					    </tr>';

		if($chapters) {
			foreach($chapters as $key => $chap) {
				$results.='<tr>';
					$results.='<td>'.($key+1).'</td>';
					// $results.='<td>'.Chapter::model()->getChapter($chap->chapter_id).'</td>';
					$results.='<td><a href="'.Yii::app()->createUrl('trainers/default/viewreport?rep_id='.$rep_id.'&chapter_id='.$chap->chapter_id).'" target="_blank">'.Chapter::model()->getChapter($chap->chapter_id).'</a></td>';
				$results.='</tr>';
			}
		} else {
			$results .= '<tr style="text-align:center;">
							<td colspan="3">No available entries</td>
						</tr>';
		}
		$results.="</tbody></table>";
		echo $results; exit;
	}

	public function actionViewReport($rep_id, $chapter_id)
	{
		$this->layout='/layouts/pdf';
		$report = PeaReports::model()->find(
			'rep_id = :rep_id AND chapter_id = :chapter_id', 
			array(':rep_id'=>$rep_id, ':chapter_id'=>$chapter_id)
		);

		$this->render('print_report', array(
				'report' => $report, 
			));
	}
}