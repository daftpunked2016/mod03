<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property integer $account_id
 * @property integer $title
 * @property string $sen_no
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $contactno
 * @property integer $gender
 * @property string $address
 * @property string $birthdate
 * @property integer $chapter_id
 * @property integer $position_id
 * @property string $user_avatar
 *
 * The followings are the available model relations:
 * @property Account $account
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, title, sen_no, firstname, middlename, lastname, contactno, gender, address, birthdate, chapter_id, position_id, user_avatar', 'required'),
			array('account_id, title, gender, chapter_id, position_id', 'numerical', 'integerOnly'=>true),
			array('sen_no', 'length', 'max'=>50),
			array('firstname, middlename, lastname', 'length', 'max'=>40),
			array('contactno', 'length', 'max'=>20),
			array('address', 'length', 'max'=>128),
			array('user_avatar', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, title, sen_no, firstname, middlename, lastname, contactno, gender, address, birthdate, chapter_id, position_id, user_avatar', 'safe', 'on'=>'search'),
		);
	}

	public function scopes()
	{
		return array(			
			'userAccount' => array(
				'join' => 'INNER JOIN jci_account AS a ON t.account_id = a.id',
				'condition' => 'a.account_type_id = 2',
			),
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
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
			'chapter' => array(self::BELONGS_TO, 'Chapter', 'chapter_id'),
			'position' => array(self::BELONGS_TO, 'Position', 'position_id'),
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
			'title' => 'Title',
			'sen_no' => 'Sen No',
			'firstname' => 'Firstname',
			'middlename' => 'Middlename',
			'lastname' => 'Lastname',
			'contactno' => 'Contactno',
			'gender' => 'Gender',
			'address' => 'Address',
			'birthdate' => 'Birthdate',
			'chapter_id' => 'Chapter',
			'position_id' => 'Position',
			'user_avatar' => 'User Avatar',
			'training_position_id' => 'Training ID',
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
		$criteria->compare('title',$this->title);
		$criteria->compare('sen_no',$this->sen_no,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('middlename',$this->middlename,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('contactno',$this->contactno,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('birthdate',$this->birthdate,true);
		$criteria->compare('chapter_id',$this->chapter_id);
		$criteria->compare('position_id',$this->position_id);
		$criteria->compare('user_avatar',$this->user_avatar,true);
		$criteria->compare('training_position_id',$this->training_position_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getCompleteName($length = 0)
	{
		$name = '';
		$id = Yii::app()->user->id;
		
		// $user = User::model()->find(array('condition'=>'account_id = "'.$id.'"'));
		$user = User::model()->find(array('condition'=>'account_id = :id', 'params'=>array(':id'=>$id)));
		if(!empty($this->middlename))
			$name = ucfirst($user->firstname).' '.ucfirst($user->middlename).' '.ucfirst($user->lastname);
		else	
			$name = ucfirst($user->firstname).' '.ucfirst($user->lastname);
		 
		$count = strlen($name);

		if ($length <> 0)
		{
			if($count > $length)
				$name = substr($name,0,$length).'...';
		}
		
		return $name; 
	}

	public function getCompleteName2($id, $length = 0)
	{
		// $user = User::model()->find(array('condition'=>'account_id = "'.$id.'"'));
		$user = User::model()->find(array('condition'=>'account_id = :id', 'params'=>array(':id'=>$id)));
		if(!empty($this->middlename))
			$name = ucwords(strtolower($user->firstname.' '.$user->middlename.' '.$user->lastname));
		else	
			$name = ucwords(strtolower($user->firstname.' '.$user->lastname));
		 
		$count = strlen($name);

		if ($length <> 0)
		{
			if($count > $length)
				$name = substr($name,0,$length).'...';
		}
		
		$title = "";
		if($user->title == 1)
		{
			$title = "JCI SEN";
		}else{
			$title = "JCI MEM";
		}

		return $title." ".$name; 
	}

	public function getPosition()
	{
		$id = Yii::app()->user->id;

		// $user = User::model()->find(array('condition'=>'account_id = "'.$id.'"'));
		$user = User::model()->find(array('condition'=>'account_id = :id', 'params'=>array(':id'=>$id)));
		$position = Position::model()->findByPk($user->position_id);
		return  $position->category." ".$position->position;
	}

	public function getPosition2($id)
	{
		// $user = User::model()->find(array('condition'=>'account_id = "'.$id.'"'));
		$user = User::model()->find(array('condition'=>'account_id = :id', 'params'=>array(':id'=>$id)));
		$position = Position::model()->findByPk($user->position_id);
		return  $position->category." ".$position->position;
	}
}
