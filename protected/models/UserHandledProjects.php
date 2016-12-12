<?php

/**
 * This is the model class for table "{{user_handled_projects}}".
 *
 * The followings are the available columns in table '{{user_handled_projects}}':
 * @property string $id
 * @property integer $pea_report_id
 * @property integer $account_id
 * @property integer $position_id
 * @property string $project_title
 * @property string $date_completed
 * @property string $date_created
 */
class UserHandledProjects extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_handled_projects}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pea_report_id, account_id, position_id, date_completed', 'required'),
			array('pea_report_id, account_id, position_id', 'numerical', 'integerOnly'=>true),
			array('project_title', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pea_report_id, account_id, position_id, project_title, date_completed, date_created', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pea_report_id' => 'Pea Report',
			'account_id' => 'Account',
			'position_id' => 'Position',
			'project_title' => 'Project Title',
			'date_completed' => 'Date Completed',
			'date_created' => 'Date Created',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('pea_report_id',$this->pea_report_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('position_id',$this->position_id);
		$criteria->compare('project_title',$this->project_title,true);
		$criteria->compare('date_completed',$this->date_completed,true);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserHandledProjects the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function addProject($account_id, $report_id)
	{
		$report = PeaReports::model()->findByPk($report_id);
		$account = Account::model()->findByPk($account_id);

		$project = new self;
		$project->account_id = $account_id;
		$project->position_id = $account->user->position_id;
		$project->pea_report_id = $report_id;
		$project->date_completed = $report->data_completed;
		$project->project_title = $report->project_title;

		return $project->save();
	}

	public static function deleteProject($account_id, $report_id)
	{
		$project = self::model()->find('account_id = :account_id AND pea_report_id = :report_id', array(
				':account_id' => $account_id, 
				':report_id' => $report_id
			));

		return ($project != null) ? $project->delete() : true;
	}
}
