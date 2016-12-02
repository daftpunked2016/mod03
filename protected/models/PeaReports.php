<?php

/**
 * This is the model class for table "{{pea_reports}}".
 *
 * The followings are the available columns in table '{{pea_reports}}':
 * @property integer $id
 * @property string $project_title
 * @property integer $account_id
 * @property integer $president_id
 * @property integer $chairman_id
 * @property integer $chapter_id
 * @property string $rep_id
 * @property string $brief_description
 * @property string $objectives
 * @property string $action_taken
 * @property string $results_achieved
 * @property string $program_partners
 * @property string $recommendation
 * @property string $data_completed
 * @property integer $members_involved
 * @property integer $sectors_involved
 * @property double $projected_income
 * @property double $projected_expenditures
 * @property double $actual_income
 * @property double $actual_expenditures
 * @property integer $fileupload_id
 * @property string $date_upload
 * @property integer $status_id
 */
class PeaReports extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pea_reports}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_title, account_id, president_id, chairman_id, chapter_id, rep_id, brief_description, objectives, action_taken, results_achieved, program_partners, recommendation, data_completed, members_involved, sectors_involved, projected_income, projected_expenditures, actual_income, actual_expenditures, status_id', 'required'),
			array('account_id, president_id, chairman_id, chapter_id, members_involved, sectors_involved, status_id', 'numerical', 'integerOnly'=>true),
			array('projected_income, projected_expenditures, actual_income, actual_expenditures', 'numerical'),
			array('project_title', 'length', 'max'=>255),
			array('rep_id', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, project_title, account_id, president_id, chairman_id, chapter_id, rep_id, brief_description, objectives, action_taken, results_achieved, program_partners, recommendation, data_completed, members_involved, sectors_involved, projected_income, projected_expenditures, actual_income, actual_expenditures, fileupload_id, attendance_sheet date_upload, status_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'chapter' => array(self::BELONGS_TO, 'Chapter', 'chapter_id'),
			'description' => array(self::BELONGS_TO, 'PeaDescriptions', 'rep_id'),
			'description1' => array(self::HAS_ONE, 'PeaDescriptions', 'rep_id'),
			'score' => array(self::HAS_ONE, 'PeaScores', 'report_id'),
		);
	}

	public function scopes()
	{
		return array(

			'isApproved' => array(
				'condition' => 't.status_id = 1',
			),

			'isApprovedRVP' => array(
				'condition' => 't.status_id = 2',
			),

			'isApprovedPres' => array(
				'condition' => 't.status_id = 3',
			),

			'isApprovedAll' => array(
				'condition' => 't.status_id = 1 OR t.status_id = 2 OR t.status_id = 3',
			),

			'isAllExcRej' => array(
				'condition' => 't.status_id = 1 OR t.status_id = 2 OR t.status_id = 3 OR t.status_id = 4',
			),

			'isApprovedAllRvp' => array(
				'condition' => 't.status_id = 1 OR t.status_id = 2',
			),

			'isPending' => array(
				'condition' => 't.status_id = 4',
			),

			'isRejected' => array(
				'condition' => 't.status_id = 5',
			),

			'isDraft' => array(
				'condition' => 't.status_id = 6',
			),

			'isProjectChair' => array(
				'condition' => 't.status_id = 7',
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'project_title' => 'Project Title',
			'account_id' => 'Account',
			'president_id' => 'President',
			'chairman_id' => 'Chairman',
			'chapter_id' => 'Chapter',
			'rep_id' => 'Rep',
			'brief_description' => 'Brief Description',
			'objectives' => 'Objectives',
			'action_taken' => 'Action Taken',
			'results_achieved' => 'Results Achieved',
			'program_partners' => 'Program Partners',
			'recommendation' => 'Recommendation',
			'data_completed' => 'Data Completed',
			'members_involved' => 'Members Involved',
			'sectors_involved' => 'Sectors Involved',
			'projected_income' => 'Projected Income',
			'projected_expenditures' => 'Projected Expenditures',
			'actual_income' => 'Actual Income',
			'actual_expenditures' => 'Actual Expenditures',
			'fileupload_id' => 'Fileupload',
			'attendance_sheet' => 'Attendance Sheet',
			'date_upload' => 'Date Upload',
			'status_id' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('project_title',$this->project_title,true);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('president_id',$this->president_id);
		$criteria->compare('chairman_id',$this->chairman_id);
		$criteria->compare('chapter_id',$this->chapter_id);
		$criteria->compare('rep_id',$this->rep_id,true);
		$criteria->compare('brief_description',$this->brief_description,true);
		$criteria->compare('objectives',$this->objectives,true);
		$criteria->compare('action_taken',$this->action_taken,true);
		$criteria->compare('results_achieved',$this->results_achieved,true);
		$criteria->compare('program_partners',$this->program_partners,true);
		$criteria->compare('recommendation',$this->recommendation,true);
		$criteria->compare('data_completed',$this->data_completed,true);
		$criteria->compare('members_involved',$this->members_involved);
		$criteria->compare('sectors_involved',$this->sectors_involved);
		$criteria->compare('projected_income',$this->projected_income);
		$criteria->compare('projected_expenditures',$this->projected_expenditures);
		$criteria->compare('actual_income',$this->actual_income);
		$criteria->compare('actual_expenditures',$this->actual_expenditures);
		$criteria->compare('fileupload_id',$this->fileupload_id);
		$criteria->compare('date_upload',$this->date_upload,true);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PeaReports the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function countReports($st)
	{
		$user = User::model()->find('account_id = '.Yii::app()->user->id);
		$pos = $user->position_id;
		$count = 0;

		switch($st) {
			case "p":
				switch($pos) {
					case 8:
						$count = PeaReports::model()->isApprovedPres()->with(array(
					    'chapter' => array(
					    	'select'=> false,
					        'condition' => 'chapter.area_no = '.$user->chapter->area_no
					    ),))->count();					    
					break;

					case 9:
						$count = PeaReports::model()->isApprovedPres()->with(array(
					    'chapter' => array(
					    	'select'=> false,
					        'condition' => 'chapter.region_id = '.$user->chapter->region_id
					    ),))->count();
					break;

					case 11:
						$count = PeaReports::model()->isPending()->count('chapter_id = '.$user->chapter_id);
					break;

					default:
						// PROJECT CHAIRMAN
						$count = PeaReports::model()->count(array('condition' => 'chairman_id = :id AND status_id = 7', 'params'=>array(':id'=>$user->account_id)));
					break;
				}
				break;
			case "a":
				switch($pos) {
					case 8:
						$count = PeaReports::model()->isApprovedAllRvp()->with(array(
					    'chapter' => array(
					    	'select'=> false,
					        'condition' => 'chapter.area_no = '.$user->chapter->area_no
					    ),))->count();
					break;

					case 9:
						$count = PeaReports::model()->isApprovedAllRvp()->with(array(
					    'chapter' => array(
					    	'select'=> false,
					        'condition' => 'chapter.region_id = '.$user->chapter->region_id
					    ),))->count();
					break;

					case 13:
					case 11:
						$count = PeaReports::model()->isApprovedAll()->count('chapter_id = '.$user->chapter_id);
					break;

					default:
						// PROJECT CHAIRMAN
						$count = PeaReports::model()->count(array('condition' => 'chairman_id = :id AND status_id <> 7', 'params'=>array(':id'=>$user->account_id)));
					break;
				}
				break;
			case "r":
				switch($pos) {
					case 8:
						$count = PeaReports::model()->isRejected()->with(array(
					    'chapter' => array(
					    	'select'=> false,
					        'condition' => 'chapter.area_no = '.$user->chapter->area_no
					    ),))->count();
					break;

					case 9:
						$count = PeaReports::model()->isRejected()->with(array(
					    'chapter' => array(
					    	'select'=> false,
					        'condition' => 'chapter.region_id = '.$user->chapter->region_id
					    ),))->count();
					break;

					case 13:
					case 11:
						$count = PeaReports::model()->isRejected()->count('chapter_id = '.$user->chapter_id);
					break;

					default:
						// PROJECT CHAIRMAN
						$count = PeaReports::model()->isRejected()->count('chairman_id ='.$user->account_id);
					break;
				}
				break;
			case "d":
				if($pos == 11 || $pos == 13) {
					$count = PeaReports::model()->isDraft()->count('chapter_id = '.$user->chapter_id.' AND account_id = '.Yii::app()->user->id);
				} else {	
					$count = PeaReports::model()->isDraft()->count('chapter_id = '.$user->chapter_id.' AND chairman_id = '.Yii::app()->user->id);
				}
			case 'c':
				if ($pos == 13) {
					$count = PeaReports::model()->isProjectChair()->count('chapter_id = '.$user->chapter_id);
				}
				break;
		}

		return $count;
	}

	public static function getReportPictures($id)
	{
		$fileupload = Fileupload::model()->findByPk($id);
		$report_avatar = $fileupload->filename;

		return $report_avatar;
	}

	public static function getAttendance($id)
	{
		$attendance = Fileupload::model()->findByPk($id);
		$report_attendance = $attendance->filename;

		return $report_attendance;
	}

	// Scope: Area, Region, Chapter
	// Scope ID = area #, region_id, chapter_id
	// cid = category_id
	public function getCount($scope, $scope_id, $cid)
	{
		$condition = array('condition'=>'status_id = 1');
		switch ($scope) {
			case 'AREA':
				$count = $this::model()
								->with(array(
									'chapter'=>array(
										'condition'=>'area_no = :scope_id',
											'params'=>array(
												':scope_id'=>$scope_id,
									)),
									'description'=>array(
										'join'=>'LEFT JOIN jci_pea_subcat AS sc ON sc.sub_id = description.sub_id',
										'condition'=>'description.rep_id = t.rep_id AND sc.cat_id = :cid',
											'params'=>array(
												':cid'=>$cid,
									)),
								))->count($condition);
				break;
			case 'REGION':
				$count = $this::model()
								->with(array(
									'chapter'=>array(
										'condition'=>'region_id = :scope_id',
											'params'=>array(
												':scope_id'=>$scope_id,
									)),
									'description'=>array(
										'join'=>'LEFT JOIN jci_pea_subcat AS sc ON sc.sub_id = description.sub_id',
										'condition'=>'description.rep_id = t.rep_id AND sc.cat_id = :cid',
											'params'=>array(
												':cid'=>$cid,
									)),
								))->count($condition);
				break;
			case 'CHAPTER':
				$count = $this::model()
								->with(array(
									'description'=>array(
										'join'=>'LEFT JOIN jci_pea_subcat AS sc ON sc.sub_id = description.sub_id',
										'condition'=>'description.rep_id = t.rep_id AND sc.cat_id = :cid',
											'params'=>array(
												':cid'=>$cid,
									)),
								))->count(array('condition'=>'chapter_id = :scope_id AND status_id = 1', 'params'=>array(':scope_id'=>$scope_id)));
				break;
			// default:
			// 	# code...
			// 	break;
		}

		return $count;
	}

	public function getProjects($chairman_id)
	{
		$count = $this::model()->count(array('condition'=>'chairman_id = :id', 'params'=>array(':id'=>$chairman_id)));

		if ($count != 0) {
			return true;
		} else {
			return false;
		}
	}
}
