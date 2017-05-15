<?php

class DefaultController extends Controller
{
	public $layout = '/layouts/main';

	public function actionDashboard()
	{
		$areas = AreaRegion::model()->findAll(array('select'=>'area_no','distinct'=>true));
		$areasDP=new CArrayDataProvider($areas, array(
			'pagination' => array(
				'pageSize' => 10
			),
		));

		$this->render('dashboard', array(
			'areasDP'=>$areasDP,
		));
	}

	public function actionRegionReport($ano)
	{
		$regions = AreaRegion::model()->findAll(array('condition'=>'area_no = :ano', 'params'=>array(':ano'=>$ano)));
		$regionsDP=new CArrayDataProvider($regions, array(
			'pagination' => array(
				'pageSize' => 10
			),
		));

		$this->render('regionreport', array(
			'regionsDP'=>$regionsDP,
			'ano'=>$ano,
		));
	}

	public function actionChapterReport($rid)
	{
		$region = AreaRegion::model()->findByPk($rid);
		$chapters = Chapter::model()->findAll(array('condition'=>'region_id = :rid', 'params'=>array(':rid'=>$rid)));
		$chaptersDP=new CArrayDataProvider($chapters, array(
			'pagination' => array(
				'pageSize' => 10
			),
		));

		$this->render('chapterreport', array(
			'chaptersDP'=>$chaptersDP,
			'region'=>$region,
		));
	}

	public function actionIndex()
	{
		if(!empty($_GET['chapter_id']) && empty($_GET['rep_id']) ){
			$search = array('condition'=>'chapter_id ='.$_GET['chapter_id']);
		}elseif(!empty($_GET['rep_id']) && empty($_GET['chapter_id'])){
			$search = array('condition'=>'rep_id = "'.$_GET['rep_id'].'"');
		}elseif(!empty($_GET['chapter_id']) && !empty($_GET['rep_id'])){
			$search = array('condition'=>'rep_id = "'.$_GET['rep_id'].'" AND chapter_id ='.$_GET['chapter_id']);
		}

		$search['order'] = 'date_upload ASC'; 
		$reports = PeaReports::model()->isApprovedRVP()->findAll($search);

		$reportDP=new CArrayDataProvider($reports, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('index', array(
			'reportDP' => $reportDP,
		));
	}

	public function actionApproved()
	{
		$search = "";

		if(!empty($_GET['chapter_id']) && empty($_GET['rep_id']) ){
			$search = array('condition'=>'chapter_id ='.$_GET['chapter_id']);
		}elseif(!empty($_GET['rep_id']) && empty($_GET['chapter_id'])){
			$search = array('condition'=>'rep_id = "'.$_GET['rep_id'].'"');
		}elseif(!empty($_GET['chapter_id']) && !empty($_GET['rep_id'])){
			$search = array('condition'=>'rep_id = "'.$_GET['rep_id'].'" AND chapter_id ='.$_GET['chapter_id']);
		}

		$search['order'] = 'date_upload DESC'; 
		$reports = PeaReports::model()->isApproved()->findAll($search);

		$reportDP=new CArrayDataProvider($reports, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('approve', array(
			'reportDP' => $reportDP,
		));
	}

	public function actionReject()
	{
		$search = "";

		if(!empty($_GET['chapter_id']) && empty($_GET['rep_id']) ){
			$search = array('condition'=>'chapter_id ='.$_GET['chapter_id']);
		}elseif(!empty($_GET['rep_id']) && empty($_GET['chapter_id'])){
			$search = array('condition'=>'rep_id = "'.$_GET['rep_id'].'"');
		}elseif(!empty($_GET['chapter_id']) && !empty($_GET['rep_id'])){
			$search = array('condition'=>'rep_id = "'.$_GET['rep_id'].'" AND chapter_id ='.$_GET['chapter_id']);
		}
		
		$search['order'] = 'date_upload DESC'; 
		$reports = PeaReports::model()->isRejected()->findAll($search);

		$reportDP=new CArrayDataProvider($reports, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('reject', array(
			'reportDP' => $reportDP,
		));
	}

	public function actionByPass()
	{
		$settings = PeaSettings::model()->find();

		if ($settings->bypass_status == 2) {
			Yii::app()->user->setFlash('error', 'ByPass Settings is Disabled. Please enable before going to this page.');
			$this->redirect(array('default/index'));
		}

		$search = "";

		if(!empty($_GET['chapter_id']) && empty($_GET['rep_id']) ){
			$search = array('condition'=>'chapter_id ='.$_GET['chapter_id']);
		}elseif(!empty($_GET['rep_id']) && empty($_GET['chapter_id'])){
			$search = array('condition'=>'rep_id = "'.$_GET['rep_id'].'"');
		}elseif(!empty($_GET['chapter_id']) && !empty($_GET['rep_id'])){
			$search = array('condition'=>'rep_id = "'.$_GET['rep_id'].'" AND chapter_id ='.$_GET['chapter_id']);
		}

		$search['order'] = 'date_upload ASC'; 
		$reports = PeaReports::model()->isApprovedPres()->findAll($search);

		$reportDP=new CArrayDataProvider($reports, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('bypass', array(
			'reportDP' => $reportDP,
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
			
		Yii::app()->getModule('admin')->user->logout(false);
		Yii::app()->user->setFlash('success', 'Logout Successful.');
		$this->redirect(Yii::app()->getModule('admin')->user->loginUrl);
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

	public function actionViewReportPDF($id)
	{
		$report =  PeaReports::model()->findByPk($id);
		$user = User::model()->find('account_id = '.$report->account_id);
		$fileupload = Fileupload::model()->findByPk($report->fileupload_id);
		$chapter = Chapter::model()->findByPk($report->chapter_id);

		if($report != null)
		{
			header("Location: ".Yii::app()->baseUrl."/jcipea_reports/".$chapter->area_no."/".$fileupload->filename);
		}
		else
		{
			print_r("ERROR! File not found.");
			exit;
		}
	}

	public function actionApproveReport($id)
	{	
		$admin_account_id = Yii::app()->getModule("admin")->user->id;
		$report = PeaReports::model()->findByPk($id);

		if(!empty($report))
		{
			if($report->status_id == 2)
			{
				$report->status_id = 1;

				if($report->save())
				{
					$transaction = new PeaTransactions;
					$transaction->generateLog($id, $report->account_id, 1, PeaTransactions::TYPE_APPROVE_REPORT);

					UserHandledProjects::addProject($report->chairman_id, $report->id);
					Yii::app()->user->setFlash('success','You have successfully approved this report!');
					$this->redirect(array('index'));	

				}else{
					Yii::app()->user->setFlash('error','An error occured while trying to approve this report. Please try again later.');
					$this->redirect(array('approved'));
				}
			}else{

				$remark = PeaReportsRemarks::model()->find(array('condition' => 'report_id ='.$report->id));
				
				if (!empty($remark)) {
					$remark->delete();
					$remark->save();
				}

				$report->status_id = 1;

				if($report->save())
				{
					$transaction = new PeaTransactions;
					$transaction->generateLog($id, $report->account_id, 1, PeaTransactions::TYPE_APPROVE_REPORT);

					UserHandledProjects::addProject($report->chairman_id, $report->id);
					Yii::app()->user->setFlash('success','You have successfully approved this report!');
					$this->redirect(array('approved'));
				} else {
					Yii::app()->user->setFlash('error','An error occured while trying to approve this report. Please try again later.');
					$this->redirect(array('approved'));
				}
			}
			
		}else{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	public function actionRejectReport($id)
	{
		$report = PeaReports::model()->findByPk($id);
		$admin_account_id = Yii::app()->getModule("admin")->user->id;

		if(!empty($report))
		{
			$report->status_id = 5;

			if($report->save())
			{	
				$remarks = PeaReportsRemarks::model()->find('report_id='.$id);

				if($remarks == null)
				{
					$remarks = new PeaReportsRemarks;
				}

				$remarks->attributes = $_POST["PeaReportsRemarks"];
				$remarks->account_id = $admin_account_id;
				$remarks->report_id = $report->id;

				if($remarks->save())
				{
					$transaction = new PeaTransactions;
					$transaction->generateLog($id, $report->account_id, 1, PeaTransactions::TYPE_REJECT_REPORT);

					UserHandledProjects::deleteProject($report->chairman_id, $report->id);
					Yii::app()->user->setFlash('success','You have successfully reject this report!');
					$this->redirect(array('reject'));	
				}else{
					Yii::app()->user->setFlash('error','An error occured while trying to approve this report. Please try again later.');
					$this->redirect(array('reject'));
				}
			}
		}else{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	public function actionPrintReport($id)
	{
		$this->layout='/layouts/pdf';

		$report = PeaReports::model()->findByPk($id);

		if($report != null)
		{
			$this->render('print_report', array(
					'report' => $report, 
				));
		}

		$this->redirect('index'); 
	}


	public function actionSubCategory($id)
	{
		$subcat = PeaSubcat::model()->findByPk($id);
		$description = PeaDescriptions::model()->findAll(array('condition'=>'sub_id ='.$id, 'order'=>'order_no'));

		$descriptionDP = new CArrayDataProvider($description, array(
			'keyField' => 'rep_id',
			'pagination' => array(
				'pageSize' => 20
			)
		));

		$this->render('subcategory', array(
			'descriptionDP' => $descriptionDP,
			'subcat' => $subcat,
		));
	}

	/**
	* VIEW REPORTS Attendance Sheet
	*/
	public function actionViewAttSheet($id)
	{
		$report =  PeaReports::model()->findByPk($id);
		$user = User::model()->find('account_id = '.$report->account_id);
		$fileupload = Fileupload::model()->findByPk($report->attendance_sheet);

		if($report != null)
		{
			header("Location: ".Yii::app()->baseUrl."/attendance_sheets/".$user->chapter->area_no."/".$fileupload->filename);
		}
		else
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	/**
	 * VIEW REPORTS Project Photo
	 */
	public function actionViewProjPhoto($id)
	{
		$report =  PeaReports::model()->findByPk($id);
		$user = User::model()->find('account_id = '.$report->account_id);
		$fileupload = Fileupload::model()->findByPk($report->fileupload_id);

		if($report != null)
		{
			header("Location: ".Yii::app()->baseUrl."/jcipea_reports/".$user->chapter->area_no."/".$fileupload->filename);
		}
		else
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	//Chapter selection for Scorecards
	public function actionSelectChapter()
	{
		if(isset($_POST['chapter'])) {
			$this->redirect(array('listScoring', 'chapter_id' => $_POST['chapter']));
		}
		$this->render('select_chapter');
	}

	public function actionListScoring($chapter_id = null, $topdf = null)
	{
		$account_id =  Yii::app()->getModule("admin")->user->id;

		if($topdf!=null)
		{
			$this->layout='/layouts/pdf';
		}

		$user = User::model()->find('account_id = '.$account_id);
		$pea_categories = PeaCategory::model()->findAll();
		$pea_subcat = PeaSubcat::model()->findAll();
		$cat_code = array("A", "B", "C");

		if($chapter_id == null) {
			$user = User::model()->find('account_id = '.$account_id);
			$chapter = $user->chapter;
		} else {
			$chapter = Chapter::model()->findByPk($chapter_id);
		}

		$this->render('list_scoring',array(
			'pea_categories'=>$pea_categories,
			'pea_subcat' => $pea_subcat,
			'cat_code' => $cat_code,
			'chapter'=>$chapter,
			'chapter_id'=>$chapter_id,
			'topdf'=>$topdf,
		));

	}

	public function actionListDescScoring($chapter_id = null, $sub_id, $topdf = null)
	{
		$account_id = Yii::app()->getModule("admin")->user->id;
		
		if($chapter_id == null) {
			$user = User::model()->find('account_id = '.$account_id);
			$chapter = $user->chapter;
		} else {
			$chapter = Chapter::model()->findByPk($chapter_id);
		}

		if($topdf!=null)
		{
			$this->layout='/layouts/pdf';
		}

		if(isset($_GET['submit']))
		{
			if($_GET['annex'] != "")
			{
				$pea_description = PeaDescriptions::model()->findAll(array('condition'=>"sub_id = ".$sub_id." AND rep_id = \"".$_GET['annex']."\""));
			}
			else if($_GET['status'] != "")
			{
				$pea_description = PeaDescriptions::model()->findAll(array('condition'=>"sub_id = ".$sub_id, 'order'=>'order_no'));

				foreach($pea_description as $key => $description)
				{
					$scoring = PeaScores::model()->find('rep_id = "'.$description->rep_id.'" AND chapter_id = '.$chapter->id);

					switch($_GET['status']) {
						case "A":
							if($scoring->report == null || $scoring->report->status_id != 1)
								unset($pea_description[$key]);
							break;
						case "P":
							if($scoring->report == null || $scoring->report->status_id == 1 || $scoring->report->status_id == 5)
								unset($pea_description[$key]);
							break;
						case "N":
							if($scoring->report != null)
								unset($pea_description[$key]);
							break;
						case "B":
							if($description->color !== "BLUE")
								unset($pea_description[$key]);
							break;
						case "G":
							if($description->color !== "GREEN")
								unset($pea_description[$key]);
							break;
					}
				}
			}
			else if($_GET['annex'] == "" && $_GET['status'] == "")
				$pea_description = PeaDescriptions::model()->findAll(array('condition'=>"sub_id = ".$sub_id, 'order'=>'order_no'));
		} else {
			$pea_description = PeaDescriptions::model()->findAll(array('condition'=>"sub_id = ".$sub_id, 'order'=>'order_no'));
		}

		$pea_subcat = PeaSubcat::model()->findByPk($sub_id);

		if($topdf!= null){
			$option =  array(
				'keyField' => 'rep_id',
				'pagination' => false
			);
		} else {
			$option =  array(
				'keyField' => 'rep_id',     
				'pagination' => array(
				'pageSize' => 20
				)
			);
		}

		$descriptionsDP=new CArrayDataProvider($pea_description, $option);


		$this->render('list_desc_scoring',array(
			'pea_description'=>$pea_description,
			'pea_subcat' => $pea_subcat,
			'descriptionsDP'=>$descriptionsDP,
			'chapter'=>$chapter,
			'sub_id'=>$sub_id,
			'topdf'=>$topdf,
			'chapter_id'=>$chapter_id
		));

	}

	public function actionRanking($topdf = null) 
	{
		ini_set('max_execution_time', 180);

		if($topdf!=null)
		{
			$this->layout='/layouts/pdf';
		}

		$scorings = array();
		$max_scores = array();
		$area_filter = '';
		$list_count_filter = '';
		$seal_filter = null;
		$descriptions = PeaDescriptions::model()->findAll(array('select'=>'sub_id, max, color'));
		$subcats = PeaSubcat::model()->findAll(array('select'=>'sub_id, cat_id'));
		$subcats_arr = array();

		foreach($subcats as $subcat) {
			$subcats_arr[$subcat->sub_id] = $subcat->cat_id;

			if(isset($cat_subcats_count[$subcat->cat_id]))
				$cat_subcats_count[$subcat->cat_id]++;
			else
				$cat_subcats_count[$subcat->cat_id] = 1;	
		}

		foreach($descriptions as $key=>$desc) {
			if($desc->color == "BLACK") {
				$max_scores[$desc->sub_id] = $max_scores[$desc->sub_id] + $desc->max;
			}
		}


		if(isset($_GET['submit'])) {
			$area_filter = $_GET['area'];
			$list_count_filter = $_GET['count'];
			$seal_filter = $_GET['seal'];
		}
			
		if($area_filter == '1' || $area_filter == "2" ||  $area_filter == "3" ||  $area_filter == "4" ||  $area_filter == "5")
			$chapters = Chapter::model()->findAll('area_no = '.$area_filter);
		else
			$chapters = Chapter::model()->findAll();
		
		foreach($chapters as $key=>$chapter)
		{	
			//$reports = PeaReports::model()->findAll(array('condition' => 'chapter_id ='.$chapter->id.' AND status_id = 1'));
			$reports = $chapter->valid_peareports;

			$subcat_scorings = array();
			$scorings[$key]['chapter_id'] = $chapter->id;
			$scorings[$key]['chapter'] = $chapter->chapter;
			$scorings[$key]['region'] = $chapter->region->region;

			$efficient_count = 0;
			$seal = "None";

			if($reports == null) {
				$scorings[$key]['raw'] = 0;
				$scorings[$key]['efficient_count'] = $efficient_count;
				$scorings[$key]['seal'] = $seal;
			} else {
				$scorings[$key]['raw'] = 0;
				
				foreach($reports as $report) {
					if($report->description->color !== "GREEN") {
						$subcat_scorings['scores'][$report->description->sub_id] = $subcat_scorings['scores'][$report->description->sub_id] + $report->score->score;
					}

					$scorings[$key]['raw'] = $scorings[$key]['raw'] + $report->score->score;
				}

				// if($chapter->id == 156) {
				// 	echo "<pre>";
				// 	print_r($subcat_scorings['scores']);
				// 	echo "</pre>";
				// }

				if(isset($subcat_scorings['scores'])) {
					foreach($subcat_scorings['scores'] as $subcat=>$score)
					{

						$weight = round(($score/($max_scores[$subcat]/2)) * 100);
						$subcat_scorings['weight'][$subcat] = $weight;

						if($weight >= 100) {
							$subcat_scorings['percentage'][$subcat] = 100;
							$efficient_count++;
						} else {
							$subcat_scorings['percentage'][$subcat] = $weight;
						}
					}
				} else {
					$subcat_scorings['percentage'] = array();
				}
				
				$scorings[$key]['rating'] = $this->computeRating($subcats_arr, $cat_subcats_count, $subcat_scorings['percentage']);
				$scorings[$key]['efficient_count'] = $efficient_count;
				$scorings[$key]['seal'] = $this->efficiencySeal($efficient_count);
			}
		}

		//SORTING OF RANKING
		foreach($scorings as $key=>$scoring) {
			$move = false;

			if($scorings[$key]['raw'] < $scorings[$key+1]['raw'])
			{
				$move = true;
				$get_elem = $key+1;
			}
			
			if($move)
			{
				$this->moveElement($scorings, $get_elem, $key);

	    		if($key != 0) 
	    		{
	    			for($x = 0; $x<$get_elem; $x++)
	   				{
	   					if($scorings[$key]['raw'] >= $scorings[$x]['raw'])
						{
							$this->moveElement($scorings, $key, $x);
						}
	   				}
	    		}
	    	}
		}

		//GET RANKS
		foreach($scorings as $key=>$scoring) {
			if($scorings[$key]['raw'] == 0) {
				if($list_count_filter == 10 || $list_count_filter == 20) {
					unset($scorings[$key]);
				} else {
					$scorings[$key]['rank'] = 999;
				}
			} else {
				if($key == 0) {
					$scorings[$key]['rank'] = $key+1;
				} else {
					if($scorings[$key]['raw'] == $scorings[$key-1]['raw']) {
						$scorings[$key]['rank'] = $scorings[$key-1]['rank'];
					} else {
						$scorings[$key]['rank'] = $key+1;
					}
				}
			}
		}

		if($list_count_filter == 10 || $list_count_filter == 20){ 
			$scorings = array_slice($scorings, 0, $list_count_filter);
		}


		// if($topdf!= null){
			$option =  array(
				'keyField' => 'chapter_id',
				'pagination' => false
			);
		/*} else {
			$option =  array(
				'keyField' => 'chapter_id',
				'pagination' => array(
				'pageSize' => 20
				)
			);
		}*/

		$rankingDP = new CArrayDataProvider($scorings, $option);

		$this->render('ranking', array(
			'rankingDP' => $rankingDP,
			'area_filter'=> $area_filter,
			'topdf'=>$topdf,
			'area'=>$area_filter,
			'seal_filter'=>$seal_filter
		));
	}

	public function moveElement(&$array, $get_pos, $new_pos) {
		$out = array_splice($array, $get_pos, 1);
	    array_splice($array, $new_pos , 0, $out);
	}

	public function efficiencySeal($efficient_count) {
		if($efficient_count >= 1 && $efficient_count <= 7) {
			$seal = "Bronze";
		} else if ($efficient_count >= 8 && $efficient_count <= 11) {
			$seal = "Silver";
		} else if ($efficient_count >= 12 && $efficient_count <= 14) {
			$seal = "Gold";
		} else if ($efficient_count == 15) {
			$seal = "Platinum";
		}

		return $seal;
	}

	public function computeRating(array $subcats_arr, array $cat_subcats_count, array $percentages)
	{
		$cat_scorings = array();
		$cat_percentages = array();

		foreach($percentages as $sub_id => $percentage) {
			$cat_scorings[$subcats_arr[$sub_id]][] += $percentage;
		}

		foreach($cat_scorings as $cat_id => $cat_scores) {
			$cat_percentages[$cat_id] = @(floor(array_sum($cat_scorings[$cat_id])/$cat_subcats_count[$cat_id])); 
		} 

		unset($cat_percentages[6]);
		$percentages_sum = array_sum($cat_percentages);

		if($percentages_sum >= 100) {
			return 100;
		} else {
			return $percentages_sum;
		}
	}

}