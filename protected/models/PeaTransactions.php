<?php

/**
 * This is the model class for table "{{pea_transactions}}".
 *
 * The followings are the available columns in table '{{pea_transactions}}':
 * @property integer $id
 * @property integer $account_id
 * @property string $ip_address
 * @property integer $type
 * @property string $detail
 * @property integer $date_created
 */
class PeaTransactions extends CActiveRecord
{
	CONST TYPE_APPROVE_REPORT = 1;
	CONST TYPE_REJECT_REPORT = 2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pea_transactions}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, ip_address, type, detail, date_created', 'required'),
			array('account_id, report_id, type', 'numerical', 'integerOnly'=>true),
			array('ip_address', 'length', 'max'=>45),
			array('detail', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, report_id, ip_address, type, detail, date_created', 'safe', 'on'=>'search'),
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
			'account_id' => 'Account',
			'ip_address' => 'Ip Address',
			'type' => 'Type',
			'detail' => 'Detail',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('date_created',$this->date_created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PeaTransactions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getUserHostAddress()
	{
		return isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'127.0.0.1';
	}

	public function generateLog($report_id, $account_id, $type, $trans_no)
	{
		if(Yii::app()->user->id == null)
			$id = Yii::app()->getModule("admin")->user->id;
		else
			$id = Yii::app()->user->id;

		$transaction = new PeaTransactions;
		$transaction->report_id = $report_id;
		$transaction->account_id = $account_id;
		$transaction->type = $type;
		$transaction->ip_address = $this->getUserHostAddress();
		$transaction->date_created = date("Y-m-d H:i:s");
		$user = User::model()->find('account_id = '.$id);
		$message = User::model()->getCompleteName2($id).' ('.$user->position->position.')';

		switch($trans_no)
		{
			case self::TYPE_APPROVE_REPORT:
				$transaction->detail = "Approved by: ".$message;
			break;
			case self::TYPE_REJECT_REPORT:
				$transaction->detail = "Rejected by: ".$message;
			break;
		}

		$transaction->save(false);
	}
}
