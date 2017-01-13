<?php

class AccountController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view', 'listsubcat', 'listallrefcode'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'submitreport', 'scorereport', 'listrefcode', 'viewreports', 'approvereport', 'rejectreport', 'viewprojphoto', 'editreport',
					'getdescdetails','getscoringanswers', 'showscore', 'selectchapter','listscoring', 'listdescscoring', 'viewattsheet', 'deletereport', 'checkactivepres', 'printreport'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->verifyAccount(Yii::app()->user->id);
		$this->redirect('listScoring');
	}

	/**
	 * SUBMIT REPORT
	 */
	public function actionSubmitReport()
	{
		$settings = PeaSettings::model()->find();

		if ($settings->pres_approval == 2) {
			Yii::app()->user->setFlash("error", 'Reports Submission disabled by NSG.');
			$this->redirect(array("account/listscoring"));
		}

		$response = array();
		$account_id =  Yii::app()->user->id;
		
		$this->verifyAccount($account_id);

		$account = Account::model()->findByPk($account_id);
		$user = User::model()->find('account_id = '.$account_id);
		$chapter = Chapter::model()->findByPk($user->chapter_id);
		$president = User::model()->with(array(
					    'account' => array(
					    	'select'=> false,
					        'condition' => 'account.status_id = 1'
					    ),))->find('chapter_id = '.$user->chapter_id.' AND position_id = 11');
		$members = User::model()->userAccount()->isActive()->findAll('chapter_id = '.$user->chapter_id);


		if(isset($_POST['refcode']))
		{
			$criteria = "N";
			$goal = "N";
			$qty = 0;

			if(isset($_POST['criteria']))
				$criteria = $_POST['criteria'];

			if(isset($_POST['goal']))
				$goal = $_POST['goal'];

			if(isset($_POST['quantity']))
				$qty = $_POST['quantity'];

			if ($_POST['date_completed'] == '') {
				$date_completed = null;
			} else {
				$date_completed = $_POST['date_completed'];
			}
		
			$report = new PeaReports;

			$report->project_title = $_POST['project_title'];
			$report->account_id = $account_id;
			$report->president_id = $president->account_id;
			$report->chairman_id = $_POST['chairman_id'];
			$report->chapter_id = $user->chapter_id;
			$report->rep_id =  $_POST['refcode'];
			$report->date_upload = date('Y-m-d H:i:s');
			$report->brief_description = $_POST['brief_description'];
			$report->objectives = $_POST['objectives'];
			$report->action_taken = $_POST['action_taken'];
			$report->results_achieved = $_POST['results_achieved'];
			$report->program_partners = $_POST['program_partners'];
			$report->recommendation = $_POST['recommendations'];
			$report->data_completed = $_POST['date_completed'];
			$report->members_involved = $_POST['jci_members'];
			$report->sectors_involved = $_POST['non_jci'];
			$report->projected_income = $_POST['proj_income'];
			$report->projected_expenditures = $_POST['proj_exp'];
			$report->actual_income = $_POST['actual_income'];
			$report->actual_expenditures = $_POST['actual_exp'];
			$report->fileupload_id = (isset($_FILES['file-report'])) ? $_FILES['file-report']['name'] : null;
			$report->attendance_sheet =  (isset($_FILES['attendance-sheet'])) ? $_FILES['attendance-sheet']['name'] : null;
			
			if($date_completed != null) {
				$report->date_deadline = date('Y-m-10', strtotime("+1 month", strtotime($_POST['date_completed'])));
			} else {
				$report->date_deadline = null;
			}

			if(isset($_POST['to_draft'])) {
				$report->status_id = 6; //TO DRAFT ONLY
			} else {
				if($account_id == $president->account_id)
					$report->status_id = 3; //APPROVED BY PRES -> PENDING NOW TO RVP
				else
					$report->status_id = 4; // PENDING TO PRES
			}

			if(isset($_FILES['file-report'])) {
				$fileupload = new Fileupload;
				$filerelation = new Filerelation;
				//FILE UPLOAD RENAMING
				$name       = $_FILES['file-report']['name'];
				$ext        = pathinfo($name, PATHINFO_EXTENSION);
				$currentDate = date('Ymdhis');
				$newName = 'JCIPEA-'.$_POST['refcode'].'-'.$user->chapter_id.'-'.$currentDate.'-'.$account_id.'.'.$ext;
				$image =  $newName;
				$fileupload->poster_id = $account_id;
				$fileupload->filename = $image;
				$target_path = "jcipea_reports/".$chapter->area_no."/";
				$target_path = $target_path . $image;
			}

			if(isset($_FILES['attendance-sheet'])) {
				$filerelation_att = new Filerelation;
				$fileupload_att = new Fileupload;
				$name_att = $_FILES['attendance-sheet']['name'];
				$ext_att        = pathinfo($name_att, PATHINFO_EXTENSION);
				$newName_att = 'JCIPEA-Attndc-'.$_POST['refcode'].'-'.$user->chapter_id.'-'.$currentDate.'-'.$account_id.'.'.$ext_att;
				$image_att =  $newName_att;
				$fileupload_att->poster_id = $account_id;
				$fileupload_att->filename = $image_att;
				$target_path_att = "attendance_sheets/".$chapter->area_no."/";
				$target_path_att = $target_path_att . $image_att;
			}

			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();

			if(isset($_POST['to_draft'])) {
				$valid = true;
				$save = false; //to save file without validation checking
			} else {
				$valid = $report->validate();
				$save = true;  //to save file with validation checking
			}

			if($valid)
			{
				if($date_completed != null) {
					if(!isset($_POST['to_draft'])) {
						if(strtotime("now") >= strtotime($report->date_deadline)) {
							Yii::app()->user->setFlash('error', 'ERROR: Project Report\'s Deadline of Submission has already passed.');
							$response['status'] = false;
							$response['message'] = 'Report cannot be submitted. Deadline of submission has already passed.';
							echo json_encode($response);
							exit;
						}
					}
				}

				try
				{
					if(isset($_FILES['file-report']))
					{
						if ($fileupload->save($save))
						{
							move_uploaded_file($_FILES['file-report']['tmp_name'], $target_path);
							$report->fileupload_id = $fileupload->id;
							$filerelation->fileupload_id = $fileupload->id;
							$filerelation->relationship_id = 5; //5 means JCI PEA Reports
							$filerelation->save($save); //save file relation
						}
						else
						{
							$errors = $fileupload->getErrors();
							print_r($errors); 
							exit;
						}
					}

					if(isset($_FILES['attendance-sheet']))
					{
						if ($fileupload_att->save($save))
						{
							move_uploaded_file($_FILES['attendance-sheet']['tmp_name'], $target_path_att);
							$report->attendance_sheet = $fileupload_att->id;
							$filerelation_att->fileupload_id = $fileupload_att->id;
							$filerelation_att->relationship_id = 5; //5 means JCI PEA Reports
							$filerelation_att->save($save); //save file relation
						}
						else
						{
							$errors = $fileupload_att->getErrors();
							print_r($errors); 
							exit;
						}
					}

					if ($report->save($save))
					{
						$transaction->commit();

						if($this->modifyScore($report->id, $report->rep_id, $user->chapter_id, $goal, $criteria, $qty))
						{
							$response['status'] = true;

							if(isset($_POST['to_draft'])) {
								Yii::app()->user->setFlash('success', 'You have successfully save a report to your drafts.');
								$response['message'] = 'You have successfully save a report to your drafts.';
								$response['redirect_url'] = "/mod03/index.php/account/";
							} else {
								Yii::app()->user->setFlash('success', 'You have successfully uploaded the report.');
								$response['message'] = 'You have successfully uploaded the report.';
								$response['redirect_url'] = "/mod03/index.php/account/showScore?id=".$report->id;
							}
						}
						else
						{
							Yii::app()->user->setFlash('error', 'An error has occured on scoring the report. Please contact the Admin for this issue.');
							$response['status'] = false;
							$response['message'] = 'An error has occured on scoring the report. Please contact the Admin for this issue.';
						}

						echo json_encode($response);
						exit;
					}
					else
					{
						$errors = $report->getErrors();
						print_r($errors); 
						exit;
					}	
				}
				catch (Exception $e)
				{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'An error occured while trying to upload the report! Please try again later.');
					print_r($e);
					exit;
				}
			}
			else
			{
				print_r($report->getErrors());
				exit;
			} 
		}
		$this->render('upload_report',array(
			'account'=>$account,
			'chapter'=>$chapter,
			'president'=>$president,
			'members'=>$members,
		));
	}

	public function actionEditReport($id, $rejected = null)
	{
		$response = array(); 
		$account_id =  Yii::app()->user->id;
		$this->verifyAccount($account_id);
		$currentDate = date('Ymdhis');

		$report = PeaReports::model()->findByPk($id);
		$orig_rep_id = $report->rep_id;
		$account = Account::model()->findByPk($account_id);

		if($report != null) { //USER CHAPTER VALIDATION FOR REPORT EDITING
			// $user_chapter = Chapter::model()->findByPk($account->user->chapter_id);

			// if($account->user->position_id == 11 || $account->user->position_id == 13) {
				if($account->user->chapter_id != $report->chapter_id) {
					$this->redirect(array('account/index'));
				}
			// } else {
			// 	$this->redirect(array('account/index'));
			// }
		} else {
			$this->redirect(array('account/index'));
		}

		$chapter = Chapter::model()->findByPk($report->chapter_id);
		$president = User::model()->with(array(
					    'account' => array(
					    	'select'=> false,
					        'condition' => 'account.status_id = 1'
					    ),))->find('chapter_id = '.$report->chapter_id.' AND position_id = 11');
		$members = User::model()->userAccount()->findAll('chapter_id = '.$report->chapter_id);
		$scoring = PeaScores::model()->find('report_id = '.$id);


		if(isset($_POST['refcode'])) {
			$criteria = "N";
			$goal = "N";
			$qty = 0;

			if(isset($_POST['criteria'])) {
				$criteria = $_POST['criteria'];
			} elseif(isset($_POST['orig_criteria'])) {
				$criteria = $_POST['orig_criteria'];
			}

			if(isset($_POST['goal'])) {
				$goal = $_POST['goal'];
			} elseif(isset($_POST['orig_goal'])) {
				$goal = $_POST['orig_goal'];
			}

			if(isset($_POST['quantity'])) {
				$qty = $_POST['quantity'];
			} elseif(isset($_POST['orig_quantity'])) {
				$qty = $_POST['orig_quantity'];
			}

			if(isset($_POST['to_draft'])) {
				$report->status_id = 6;
			} else {
				if(isset($_POST['rejected'])) {
					if($_POST['rejected'] == 1 || $report->status_id == 6) {
						if($account_id == $president->account_id) {
							$report->date_upload = date('Y-m-d H:i:s');
							$report->status_id = 3; //APPROVED BY PRES -> PENDING NOW TO RVP
						} else if($account_id == $report->chairman_id) {
							$report->status_id = 7; // PENDING TO SECRETARY
						} else {
							$report->status_id = 4; // PENDING TO PRES
						}
					}
				}
			}

			if ($_POST['date_completed'] == '') {
				$date_completed = null;
			} else {
				$date_completed = $_POST['date_completed'];
			}

			$report->project_title = $_POST['project_title'];
			$report->president_id = $president->account_id;
			$report->chairman_id = $_POST['chairman_id'];
			$report->rep_id =  $_POST['refcode'];
			$report->brief_description = $_POST['brief_description'];
			$report->objectives = $_POST['objectives'];
			$report->action_taken = $_POST['action_taken'];
			$report->results_achieved = $_POST['results_achieved'];
			$report->program_partners = $_POST['program_partners'];
			$report->recommendation = $_POST['recommendations'];
			$report->data_completed= $date_completed;
			$report->members_involved = $_POST['jci_members'];
			$report->sectors_involved = $_POST['non_jci'];
			$report->projected_income = $_POST['proj_income'];
			$report->projected_expenditures = $_POST['proj_exp'];
			$report->actual_income = $_POST['actual_income'];
			$report->actual_expenditures = $_POST['actual_exp'];

			if($date_completed != null) {
				$report->date_deadline = date('Y-m-10', strtotime("+1 month", strtotime($date_completed)));
			} else {
				$report->date_deadline = null;
			}
			// $report->date_upload = date('Y-m-d H:i:s');

			if(isset($_POST['edit-delete-att'])) {
				if($_POST['edit-delete-att'] === "D") {
					$report->attendance_sheet = 0;
				}
			}

			if(isset($_FILES['file-report'])) {
				$filerelation = new Filerelation;
				$fileupload = new Fileupload;
				$name       = $_FILES['file-report']['name'];
				$ext        = pathinfo($name, PATHINFO_EXTENSION);
				$newName = 'JCIPEA-'.$_POST['refcode'].'-'.$account->user->chapter_id.'-'.$currentDate.'-'.$account_id.'.'.$ext;
				$image =  $newName;
				$fileupload->poster_id = $account_id;
				$fileupload->filename = $image;
				$target_path = "jcipea_reports/".$chapter->area_no."/";
				$target_path = $target_path . $image;
			}

			if(isset($_FILES['attendance-sheet'])) {
				$filerelation_att = new Filerelation;
				$fileupload_att = new Fileupload;
				$name_att = $_FILES['attendance-sheet']['name'];
				$ext_att        = pathinfo($name_att, PATHINFO_EXTENSION);
				$newName_att = 'JCIPEA-Attndc-'.$_POST['refcode'].'-'.$account->user->chapter_id.'-'.$currentDate.'-'.$account_id.'.'.$ext_att;
				$image_att =  $newName_att;
				$fileupload_att->poster_id = $account_id;
				$fileupload_att->filename = $image_att;
				$target_path_att = "attendance_sheets/".$chapter->area_no."/";
				$target_path_att = $target_path_att . $image_att; 
			}

			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();

			if(isset($_POST['to_draft'])) {
				$valid = true;
				$save = false; //to save file without validation checking
			} else {
				$valid = $report->validate();
				$save = true;  //to save file with validation checking
			}

			if($valid)
			{
				if($date_completed != null) {
					if(strtotime("now") >= strtotime($report->date_deadline)) {
						Yii::app()->user->setFlash('error', 'ERROR: Project Report\'s Deadline of Submission has already passed.');
						$response['status'] = false;
						$response['message'] = 'Report cannot be submitted. Deadline of submission has already passed.';
						echo json_encode($response);
						exit;
					}
				}

				try
				{
					if(isset($_FILES['file-report'])) //new proj. photo saving
					{
						if ($fileupload->save($save))
						{
							move_uploaded_file($_FILES['file-report']['tmp_name'], $target_path);
							$report->fileupload_id = $fileupload->id;
							$filerelation->fileupload_id = $fileupload->id;
							$filerelation->relationship_id = 5; //5 means JCI PEA Reports
							$filerelation->save($save); //save file relation
						}
						else
						{
							$errors = $fileupload->getErrors();
							print_r($errors); 
							exit;
						}
					}

					if(isset($_FILES['attendance-sheet'])) //new attendance sheet saving
					{
						if ($fileupload_att->save($save))
						{
							move_uploaded_file($_FILES['attendance-sheet']['tmp_name'], $target_path_att);
							$report->attendance_sheet = $fileupload_att->id;
							$filerelation_att->fileupload_id = $fileupload_att->id;
							$filerelation_att->relationship_id = 5; //5 means JCI PEA Reports
							$filerelation_att->save($save); //save file relation
						}
						else
						{
							$errors = $fileupload_att->getErrors();
							print_r($errors); 
							exit;
						}
					}

					if ($report->save($save))
					{	
						$transaction->commit();

						if($orig_rep_id === $_POST['refcode']) {
							$updateScore = $this->modifyScore($report->id, $report->rep_id, $account->user->chapter_id, $goal, $criteria, $qty, 1);
						} else { //if refcode is changed
							$scoring = PeaScores::model()->find('report_id = '.$report->id);
							$scoring->delete();
							$updateScore = $this->modifyScore($report->id, $report->rep_id, $account->user->chapter_id, $goal, $criteria, $qty);
						}

						if($updateScore)
						{
							$response['status'] = true;

							if(isset($_POST['to_draft'])) {
								Yii::app()->user->setFlash('success', 'You have successfully save a report to your drafts.');
								$response['message'] = 'You have successfully save a report to your drafts.';
								$response['redirect_url'] = "/mod03/index.php/account/";
							} else {
								Yii::app()->user->setFlash('success', 'You have successfully updated and submitted the report.');
								$response['message'] = 'You have successfully updated and submitted the report.';
								$response['redirect_url'] = "/mod03/index.php/account/showScore?id=".$report->id;
							}
						}
						else
						{
							Yii::app()->user->setFlash('error', 'An error has occured on rescoring the report. Please contact the Admin for this issue.');
							$response['status'] = false;
							$response['message'] = 'An error has occured on rescoring the report. Please contact the Admin for this issue.';
						}

						echo json_encode($response);
						exit;
					}
					else
					{
						$errors = $report->getErrors();
						print_r($errors); 
						exit;
					}
					
				}
				catch (Exception $e)
				{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'An error occured while trying to upload the report! Please try again later.');
					print_r($e);
					exit;
				}
			}
			else
			{
				print_r($report->getErrors());
				exit;
			} 

		}

		$this->render('edit_report',array(
			'account'=>$account,
			'chapter'=>$chapter,
			'president'=>$president,
			'members'=>$members,
			'report'=>$report,
			'rejected'=>$rejected
		));
	}

	public function actionCheckActivePres()
	{
		$account_id =  Yii::app()->user->id;
		
		$this->verifyAccount($account_id);

		$account = Account::model()->findByPk($account_id);
		$president = User::model()->with(array(
					    'account' => array(
					    	'select'=> false,
					        'condition' => 'account.status_id = 1'
					    ),))->find('chapter_id = '.$account->user->chapter_id.' AND position_id = 11');

		if($president == null) {
			echo json_encode(0);
		} else {
			echo json_encode(1);
		}
	}

	public function actionScoreReport($id)
	{
		$account_id =  Yii::app()->user->id;
		$report =  PeaReports::model()->findByPk($id);

		if($report == null)
		{
			Yii::app()->user->setFlash('error','Report Invalid!');
			$this->redirect(array('account/index'));
		}

		$this->verifyAccount($account_id);

		$description = PeaDescription::model()->findByPk($report->rep_id);

		if(isset($_POST['submit'])) {
			if(isset($_POST['criteria']))
				$criteria = $_POST['criteria'];
			else
				$criteria = 0;

			if(isset($_POST['goal']))
				$goal = $_POST['goal'];
			else
				$goal = 0;

			print_r($goal.' '.$criteria);
			exit;
		}

		$this->render('scoring',array(
			'report'=>$report,
			'description' => $description,
		));

	}


	public function actionDeleteReport($id, $view)
	{
		$report =  PeaReports::model()->findByPk($id);
		
		if($report == null)
		{
			Yii::app()->user->setFlash('error','Report Invalid!');
			$this->redirect(array('account/index'));
		}

		$scoring = PeaScores::model()->find('report_id='.$report->id);
		$remarks = PeaReportsRemarks::model()->find('report_id='.$report->id);

		if($report->delete())
		{
			if($scoring->delete())
			{
				if($remarks != null)
				{
					$remarks->delete();
				}

				Yii::app()->user->setFlash('success','You have successfully deleted a report and its properties.');
				$this->redirect(array('viewreports', 'st'=> $view));
			}
		}
	}

	public function modifyScore($report_id, $rep_id, $chapter_id, $g, $c, $q, $update = null)
	{
		$account_id =  Yii::app()->user->id;
		$this->verifyAccount($account_id);
		
		if($q == null)
		{
			$q = 0;
		}

		$description =  PeaDescriptions::model()->findByPk($rep_id);

		if($update != null) {
			$scoring = PeaScores::model()->find('report_id = '.$report_id);
		} else {
			$scoring = new PeaScores;
			$scoring->date_created =  date('Y-m-d H:i:s');
		}

		$scoring->report_id = $report_id;
		$scoring->account_id = $account_id;
		$scoring->chapter_id = $chapter_id;
		$scoring->rep_id = $rep_id;
		$scoring->goal_status = $g;
		$scoring->criteria_status = $c;
		$scoring->qty = $q;
		$scoring->score = PeaScores::model()->computeScore($rep_id, $g, $q, $c, $description->qty, $description->range, $description->goal_point, $description->criteria_point, $description->max);
		$valid = $scoring->validate();

		if($valid)
		{
			try
			{
				if ($scoring->save())
				{
					return true;
				}
			}
			catch (Exception $e)
			{
				return false;
			}
		} else {
			print_r($scoring->getErrors());
			exit;
		}

		return false;
	}

	public function actionShowScore($id)
	{
		$account_id =  Yii::app()->user->id;
		$this->verifyAccount($account_id);

		$account = Account::model()->findByPk($account_id);
		$report = PeaReports::model()->findByPk($id);
		$description = PeaDescriptions::model()->findByPk($report->rep_id);
		$summary = PeaSummary::model()->find('chapter_id = '.$account->user->chapter_id);

		$this->render('show_score',array(
			'summary'=>$summary,
			'description' => $description,
			'g'=>$report->score->goal_status,
			'c'=>$report->score->criteria_status,
			'q'=>$report->score->qty,
			'score'=>$report->score->score,
			'id'=>$id
		));
	}

	public function actionListScoring($chapter_id = null, $topdf = null)
	{
		$account_id =  Yii::app()->user->id;
		$this->verifyAccount($account_id);

		if ($topdf!=null) {
			$this->layout='//layouts/pdf';
		}

		$user = User::model()->find('account_id = '.$account_id);
		$pos_arr = [1=>'8', 2=>'9', 3=>'11', 4=>'13'];

		// redirect writer
		if(!array_search($user->position_id, $pos_arr)) {
			$this->redirect(array('account/viewreports', 'st'=>'p'));
		}

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
			'topdf'=>$topdf,
		));

	}

	public function actionListDescScoring($chapter_id = null, $sub_id, $topdf = null)
	{
		$account_id =  Yii::app()->user->id;
		$this->verifyAccount($account_id);
		
		if($chapter_id == null) {
			$user = User::model()->find('account_id = '.$account_id);
			$chapter = $user->chapter;
		} else {
			$chapter = Chapter::model()->findByPk($chapter_id);
		}

		if($topdf!=null)
		{
			$this->layout='//layouts/pdf';
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

	/**
	 * VIEW REPORTS  // st means status : a = APPROVED, p = PENDING, r = REJECTED
	 */
	public function actionViewReports($st)
	{
		$account_id =  Yii::app()->user->id;
		$subheader = '';
		$layout = '';

		$this->verifyAccount($account_id);

		$user = User::model()->with('chapter')->find('account_id = '.$account_id);
		$chapter = Chapter::model()->findByPk($user->chapter_id);
		$pos = $user->position_id;

		$settings = PeaSettings::model()->find();

		if($pos == 11 || $pos == 13) { //SEC AND PRES
			if ($settings->pres_approval == 1) {
				$display_actions_status =  true;
			} else {
				$display_actions_status =  false;
			}
		} else if($pos == 8) { // AVP
			if ($settings->avp_approval == 1) {
				$display_actions_status =  true;
			} else {
				$display_actions_status =  false;
			}
		} else if($pos == 9) { // RVP
			if ($settings->rvp_approval == 1) {
				$display_actions_status =  true;
			} else {
				$display_actions_status =  false;
			}
		} else {
			$display_actions_status = false;
		}

		switch($st) {
			case "p":
				switch($pos) {
					case 8:
						$search1 = array(
					    'chapter' => array(
					    	'select'=> false,
					        'condition' => 'chapter.area_no = '.$user->chapter->area_no
					    ),);

					    $search2 = '';

						if(!empty($_GET['chapter_id'])){
							$search1 =  array(
						    'chapter' => array(
						    	'select'=> false,
						        'condition' => 'chapter.id = '.$_GET['chapter_id']
						    ),);
						}

						if(!empty($_GET['rep_id'])){
							$search2 = array('condition'=>'rep_id = "'.$_GET['rep_id'].'"');
						}

						$search2['order'] = 'date_upload ASC';
						$reports = PeaReports::model()->isApprovedPres()->with($search1)->findAll($search2);

					    $subheader = "Reports for Approval in your Area";
					break;

					case 9:
						$search1 = array(
					    'chapter' => array(
					    	'select'=> false,
					        'condition' => 'chapter.region_id = '.$user->chapter->region_id
					    ),);

					    $search2 = '';

						if(!empty($_GET['chapter_id'])){
							$search1 =  array(
						    'chapter' => array(
						    	'select'=> false,
						        'condition' => 'chapter.id = '.$_GET['chapter_id']
						    ),);
						}

						if(!empty($_GET['rep_id'])){
							$search2 = array('condition'=>'rep_id = "'.$_GET['rep_id'].'"');
						}

						$search2['order'] = 'date_upload ASC';
						$reports = PeaReports::model()->isApprovedPres()->with($search1)->findAll($search2);
					    $subheader = "Reports for Approval in your Region";
					break;

					case 13:
					case 11:
						$search2['order'] = 'date_upload ASC';
						$search2['condition'] = 'chapter_id = '.$user->chapter_id;
						$reports = PeaReports::model()->isPending()->findAll($search2);
						$subheader = "Reports for Approval in your Chapter";
					break;

					default:
						// FOR PROJECT CHAIRMAN
						$search2['order'] = 'date_upload ASC';
						$search2['condition'] = 'chairman_id = '.$user->account_id.' AND status_id = 7';
						$reports = Peareports::model()->findAll($search2);
						$subheader = "Reports for Assigned to you";
					break;
				}

				$layout = 'view-pending';
				break;
			case "a":
				switch($pos) {
					case 8:
						$search1 = array(
					    'chapter' => array(
					    	'select'=> false,
					        'condition' => 'chapter.area_no = '.$user->chapter->area_no
					    ),);

					    $search2 = '';

						if(!empty($_GET['chapter_id'])){
							$search1 =  array(
						    'chapter' => array(
						    	'select'=> false,
						        'condition' => 'chapter.id = '.$_GET['chapter_id']
						    ),);
						}

						if(!empty($_GET['rep_id'])){
							$search2 = array('condition'=>'rep_id = "'.$_GET['rep_id'].'"');
						}

						$search2['order'] = 'date_upload DESC';
						$reports = PeaReports::model()->isApprovedAllRvp()->with($search1)->findAll($search2);
					break;

					case 9:
						$search1 = array(
					    'chapter' => array(
					    	'select'=> false,
					        'condition' => 'chapter.region_id = '.$user->chapter->region_id
					    ),);

					    $search2 = '';

						if(!empty($_GET['chapter_id'])){
							$search1 =  array(
						    'chapter' => array(
						    	'select'=> false,
						        'condition' => 'chapter.id = '.$_GET['chapter_id']
						    ),);
						}

						if(!empty($_GET['rep_id'])){
							$search2 = array('condition'=>'rep_id = "'.$_GET['rep_id'].'"');
						}

						$search2['order'] = 'date_upload DESC';
						$reports = PeaReports::model()->isApprovedAllRvp()->with($search1)->findAll($search2);
					break;

					case 13:
					case 11:
						$search2['order'] = 'date_upload DESC';
						$search2['condition'] = 'chapter_id = '.$user->chapter_id;
						$reports = PeaReports::model()->isApprovedAll()->findAll($search2);
					break;

					default:
						// FOR PROJECT CHAIRMAN
						$search2['order'] = 'date_upload DESC';
						$search2['condition'] = 'chairman_id = '.$user->account_id.' AND status_id NOT IN (5,6,7)';
						$reports = PeaReports::model()->findAll($search2);
					break;
				}

				$layout = 'view-approved';
				break;
			case "r":
				switch($pos) {
					case 8:
						$search1 = array(
					    'chapter' => array(
					    	'select'=> false,
					        'condition' => 'chapter.area_no = '.$user->chapter->area_no
					    ),);

					    $search2 = '';

						if(!empty($_GET['chapter_id'])){
							$search1 =  array(
						    'chapter' => array(
						    	'select'=> false,
						        'condition' => 'chapter.id = '.$_GET['chapter_id']
						    ),);
						}

						if(!empty($_GET['rep_id'])){
							$search2 = array('condition'=>'rep_id = "'.$_GET['rep_id'].'"');
						}

						$search2['order'] = 'date_upload DESC';
						$reports = PeaReports::model()->isRejected()->with($search1)->findAll($search2);
					break;

					case 9:
						$search1 = array(
					    'chapter' => array(
					    	'select'=> false,
					        'condition' => 'chapter.region_id = '.$user->chapter->region_id
					    ),);

					    $search2 = '';

						if(!empty($_GET['chapter_id'])){
							$search1 =  array(
						    'chapter' => array(
						    	'select'=> false,
						        'condition' => 'chapter.id = '.$_GET['chapter_id']
						    ),);
						}

						if(!empty($_GET['rep_id'])){
							$search2 = array('condition'=>'rep_id = "'.$_GET['rep_id'].'"');
						}

						$search2['order'] = 'date_upload DESC';
						$reports = PeaReports::model()->isRejected()->with($search1)->findAll($search2);
					break;

					case 13:
					case 11:
						$search2['order'] = 'date_upload DESC';
						$search2['condition'] = 'chapter_id = '.$user->chapter_id;
						$reports = PeaReports::model()->isRejected()->findAll($search2);
					break;

					default:
						// FOR PROJECT CHAIRMAN
						$search2['order'] = 'date_upload DESC';
						$search2['condition'] = 'chairman_id = '.$user->account_id;
						$reports = PeaReports::model()->isRejected()->findAll($search2);
					break;
				}

				$layout = 'view-rejected';
				break;
			case "d":
				switch($pos) {
					case 13:
					case 11:
						$search2['order'] = 'date_upload DESC';
						$search2['condition'] = 'chapter_id = '.$user->chapter_id.' AND account_id = '.Yii::app()->user->id;
						$reports = PeaReports::model()->isDraft()->findAll($search2);
					break;

					default:
						$search2['order'] = 'date_upload DESC';
						$search2['condition'] = 'chairman_id = '.$user->account_id;
						$reports = PeaReports::model()->isDraft()->findAll($search2);
					break;
				}

				$layout = 'view-drafts';
				break;

			case 'c':
				if ($pos == 13) {
					$search2['order'] = 'date_upload DESC';
					$search2['condition'] = 'chapter_id = '.$user->chapter_id;
					$reports = PeaReports::model()->isProjectChair()->findAll($search2);
				}
				$layout = 'view-chairs';
				break;
		}

		$reportDP=new CArrayDataProvider($reports, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render($layout, array(
			'reportDP' => $reportDP, 
			'subheader' => $subheader,
			'display_actions_status' => $display_actions_status,
			'pos'=>$pos,
			'user_position'=>$user->position_id,
			'user'=>$user,
		));
	}

	public function actionPrintReport($id)
	{
		$this->layout='//layouts/pdf';
		$account_id =  Yii::app()->user->id;
		$this->verifyAccount($account_id);

		$account = Account::model()->findByPk($account_id);
		$report = PeaReports::model()->findByPk($id);

		if($report != null)
		{
			if($account->user->chapter_id == $report->chapter_id)
			{
				$this->render('print_report', array(
					'report' => $report, 
				));
			}
		}

		$this->redirect('index'); 
	}

	public function actionApproveReport($id, $st)
	{
		$report = PeaReports::model()->findByPk($id);
		$user = User::model()->find('account_id = '.Yii::app()->user->id);

		if(!empty($report))
		{
			if($user->position_id == 8 || $user->position_id == 9) {
				$status = 2;
			} else if($user->position_id == 13) {
				$status = 4; // PENDING TO PRESIDENT
			} else {
				if($user->position_id == 11) {
					$report->date_upload = date('Y-m-d H:i:s');
				}

				$status = 3;
			}
			
			$report->status_id = $status; //3 APPROVED BY PRES AND PENDING TO RVP - 2 APPROVED BY RVP/AVP AND PENDING TO NSG
			
			if($report->save())
			{
				$transaction = new PeaTransactions;
				$transaction->generateLog($id, $report->account_id, 1, PeaTransactions::TYPE_APPROVE_REPORT);

				if($report->status_id == 2) {
					Yii::app()->user->setFlash('success','Please wait for the approval of NSG.');
				} else if($report->status_id == 4) {
					Yii::app()->user->setFlash('success','Please wait for the approval of your LO President.');
				} else {
					Yii::app()->user->setFlash('success','You have successfully approved this report and will now be submitted to your respective RVP.');
				}
				
			}else{
				Yii::app()->user->setFlash('error','An error occured while trying to approve this report. Please try again later.');
			}

			$this->redirect(array('account/viewreports', 'st'=>$st));
		}else{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	public function actionRejectReport($id, $st)
	{
		//$remarks = new PeaReportsRemarks;
		$report = PeaReports::model()->findByPk($id);

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
				$remarks->account_id = Yii::app()->user->id;
				$remarks->report_id = $report->id;

				if($remarks->save())
				{
					$transaction = new PeaTransactions;
					$transaction->generateLog($id, $report->account_id, 1, PeaTransactions::TYPE_REJECT_REPORT);

					Yii::app()->user->setFlash('success','You have successfully rejected this report!');
				}else{
					Yii::app()->user->setFlash('error','An error occured while trying to approve this report. Please try again later.');
				}
			}
			$this->redirect(array('viewreports', 'st'=>$st));
		}else{
			throw new CHttpException(404,'The requested page does not exist.');
		}

		$this->refresh();
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
	 * GET SUBCATEGORY
	 */
	public function actionListSubCat()
	{	
		if(isset($_POST['cat_id']))
		{
			$cat_id = $_POST['cat_id'];

			$subcat = PeaSubcat::model()->findAll('cat_id = '.$cat_id);

			foreach($subcat as $subcat)
			{
				echo "<option value ='".$subcat->sub_id."'>".$subcat->SubCat."</option>";
			}
		}

		exit;
	}

	/**
	 * GET REF CODE
	 */
	public function actionListRefCode()
	{	
		$account_id =  Yii::app()->user->id;
		$user = User::model()->find('account_id = '.$account_id);

		if(isset($_POST['sub_id']))
		{
			$sub_id = $_POST['sub_id'];

			$descriptions = PeaDescriptions::model()->with(array("reports" => array(
						    'joinType' => 'LEFT JOIN',
						    'together' => true
						)))->findAll(array('condition'=>"sub_id = ".$sub_id, 'order'=>'order_no'));

			foreach($descriptions as $desc)
			{
				$print = true;

				if($desc->reports != null) {
					foreach($desc->reports as $report) {
						if($report->chapter_id == $user->chapter_id) {
							$print = false;
						}
					}
				} 

				if($print)
					echo "<option value ='".$desc->rep_id."'>".$desc->rep_id." - ".$desc->description."</option>";
			}
		}

		exit;
	}

	public function actionListAllRefCode()
	{	
		// $account_id =  Yii::app()->user->id;
		// $user = User::model()->find('account_id = '.$account_id);

		if(isset($_POST['sub_id']))
		{
			$sub_id = $_POST['sub_id'];

			$descriptions = PeaDescriptions::model()->findAll(array('condition'=>"sub_id = ".$sub_id, 'order'=>'order_no'));

			foreach($descriptions as $desc)
			{
				echo "<option value ='".$desc->rep_id."'>".$desc->rep_id." - ".$desc->description."</option>";
			}
		}

		exit;
	}

	public function actionGetDescDetails()
	{	
		if(isset($_POST['rep_id']))
		{
			$rep_id = $_POST['rep_id'];
			$description = PeaDescriptions::model()->findByPk($rep_id);
			echo json_encode($description->attributes);
		}

		exit;
	}

	public function actionGetScoringAnswers()
	{	
		if(isset($_POST['report_id']))
		{
			$report_id = $_POST['report_id'];
			$scoring = PeaScores::model()->find('report_id ='.$report_id);
			echo json_encode($scoring->attributes);
		}

		exit;
	}

	public function verifyAccount($id)
	{
		$account = Account::model()->findByPk($id);

		if($account != null)
		{
			if($account->status_id == 1)
			{
				//$user = User::model()->find('account_id = '.$account->id);

				// if($account->user->position_id == 8 || $account->user->position_id == 9 || $account->user->position_id == 11 || $account->user->position_id == 13)
				// {
					return true;
				// }
			}
		}

		Yii::app()->user->logout();
		Yii::app()->session->open();
		Yii::app()->user->setFlash('error','Account Inactive or Invalid');
		$this->redirect(array('site/login'));
	}

	public function verifyAvpActions()
	{
		$status = PeaAvpActivate::model()->findByPk(1);
		
		if($status->status_id == 1)
			return true;
		else
			return false;
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Account the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Account::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Account $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='account-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
