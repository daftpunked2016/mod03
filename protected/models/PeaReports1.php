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
 * @property integer $rep_id
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
			array('project_title, account_id, president_id, chairman_id, chapter_id, rep_id, date_upload, status_id', 'required'),
			array('account_id, president_id, chairman_id, chapter_id, status_id', 'numerical', 'integerOnly'=>true),
			array('project_title', 'length', 'max'=>255),
			array('rep_id', 'length', 'max'=>3),
			//array('fileupload_id', 'length', 'max' => 255, 'tooLong' => '{attribute} is too long (max {max} chars).'),
    		//array('fileupload_id', 'file', 'types' => 'pdf', 'maxSize' => 1024 * 1024 * 50, 'tooLarge' => 'Size should be less than 50MB!'),
			//array('fileupload_id', 'required', 'message' => 'You must upload the Project Completion Report PDF.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, project_title, account_id, president_id, chairman_id, chapter_id, rep_id, fileupload_id, date_upload, status_id', 'safe', 'on'=>'search'),
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

			'isApprovedAllRvp' => array(
				'condition' => 't.status_id = 1 OR t.status_id = 2',
			),

			'isPending' => array(
				'condition' => 't.status_id = 4',
			),

			'isRejected' => array(
				'condition' => 't.status_id = 5',
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
			'fileupload_id' => 'Fileupload',
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
		$criteria->compare('rep_id',$this->rep_id);
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

					case 11:
						$count = PeaReports::model()->isApprovedAll()->count('chapter_id = '.$user->chapter_id);
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

					case 11:
						$count = PeaReports::model()->isRejected()->count('chapter_id = '.$user->chapter_id);
					break;
				}
				break;
		}

		return $count;
	}

}
