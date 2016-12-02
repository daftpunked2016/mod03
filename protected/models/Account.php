<?php

/**
 * This is the model class for table "jci_account".
 *
 * The followings are the available columns in table 'jci_account':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $salt
 * @property integer $account_type_id
 * @property string $date_created
 * @property string $date_updated
 * @property integer $status_id
 *
 * The followings are the available model relations:
 * @property AccountType $id0
 * @property User[] $users
 */
class Account extends CActiveRecord
{	
	public $new_password; 
	public $confirm_password; 
	public $current_password;
	CONST STATUS_ACTIVE = 1;
	CONST STATUS_INACTIVE = 2;
	CONST STATUS_INACTIVE_PAUSE = 3;
	private static $_items;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jci_account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username', 'required'),
			array('username', 'unique'),
			array('username', 'email'),
			array('password, confirm_password', 'required', 'on' => 'createNewAccount'),
			array('username', 'validateNewUsername', 'on' => 'createNewAccount'),
			array('username', 'validateNewUsername', 'on' => 'updateAccount'),
			array('current_password, new_password, confirm_password', 'required', 'on' => 'changePwd'),
			array('current_password', 'findPasswords', 'on' => 'changePwd'),
			array('confirm_password', 'compare', 'compareAttribute'=>'new_password', 'message'=>'New password doesn\'t match!', 'on'=>'changePwd'),
			array('confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>'Passwords doesn\'t match!', 'on'=>'createNewAccount'),
			array('date_created, date_updated, status, salt', 'safe'),
			array('account_type_id, status_id', 'numerical', 'integerOnly'=>true),
			array('password', 'length', 'min'=>8, 'max'=>16, 'on'=>'createNewAccount'),
			array('new_password', 'length', 'min'=>8, 'max'=>16, 'on'=>'changePwd'),
			array('confirm_password', 'length', 'min'=>8, 'max'=>16, 'on'=>'changePwd'),
			array('username', 'length', 'max'=>40),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, salt, account_type_id, date_created, date_updated, status_id', 'safe', 'on'=>'search'),
		);
	}

	public function scopes()
	{
		return array(
			'isActive' => array(
				'condition' => 't.status_id = '.self::STATUS_ACTIVE,
			),
			
			'isInactive' => array(
				'condition' => 't.status_id = '.self::STATUS_INACTIVE,
			),

			'isInactivePause' => array(
				'condition' => 't.status_id = '.self::STATUS_INACTIVE_PAUSE,
			),

			'isInactiveSen' => array(
				'condition' => 't.status_id = 3',
			),

			'isActiveSen' => array(
				'join' => 'INNER JOIN jci_user AS u ON t.id = u.account_id',
				'condition' => 'u.title = 1 AND t.status_id = 1',
			),

			'isNTD' => array(
				'join' => 'INNER JOIN jci_user AS u ON t.id = u.account_id',
				'condition' => 'u.training_position_id = 1',
			),

			'isTrainers' => array(
				'join' => 'INNER JOIN jci_user AS u ON t.id = u.account_id',
				'condition' => 'u.training_position_id IN (2,3,4) AND t.status_id = 1',
			),
			
			'adminAccount' => array(
				'condition' => 'account_type_id = 1',
			),
			
			'userAccount' => array(
				'condition' => 'account_type_id = 2',
			),
			
			'hostChairAccount' => array(
				'condition' => 'account_type_id = 3',
			),

			'presAccount' => array(
				'join' => 'INNER JOIN jci_user AS u ON t.id = u.account_id',
				'condition' => 'u.position_id = 11',
			),

			'isAuth' => array(
				'join' => 'INNER JOIN jci_user AS u ON t.id = u.account_id',
				'condition' => 'u.position_id IN (11, 13, 8, 9)',
			),

			'isAuth2' => array(
				'join' => 'INNER JOIN jci_user AS u ON t.id = u.account_id',
				'condition' => 't.account_type_id = 1 OR u.position_id IN (5)',	
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
			//'id0' => array(self::BELONGS_TO, 'AccountType', 'id'),
			'users' => array(self::HAS_MANY, 'User', 'account_id'),
			'user' => array(self::HAS_ONE, 'User', 'account_id'),
		);
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->salt=$this->generateSalt();
				$this->status_id = 2;
				$this->password=$this->hashPassword($this->password,$this->salt);	
				$this->date_created = date('Y-m-d H:i');
				$this->date_updated = date('Y-m-d H:i');
			}
			else
			{
				$this->date_updated = date('Y-m-d H:i');
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username / Email',
			'password' => 'Password',
			'confirm_password' => 'Confirm Password',
			'new_password' => 'New Password',
			'current_password' => 'Current Password',
			'salt' => 'Salt',
			'account_type_id' => 'Account Type',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt);
		$criteria->compare('account_type_id',$this->account_type_id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Account the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function validatePassword($password)
	{
		return $this->hashPassword($password,$this->salt)===$this->password;
	}
	
	/**
	 * Generate salt for safer encryption
	 */
	public function generateSalt()
	{
		// Simple timestamp. Needs to be worked on to make site more secure
		return time();
	}
	
	/*
	 * Create hashed password
	 */
	public function hashPassword($password,$salt)
	{
		//Used to encrypt the password
		//You can either use sha1, sha2 or sha256
		//md5 not that secure anymore
		return sha1($password.$salt);
	}

	public function validateNewUsername($attribute,$params)
	{
		$id = Yii::app()->user->id;
		

		if ($this->username != "")
		{
			if (!$this->hasErrors())
			{
				if(!filter_var($this->username,FILTER_VALIDATE_EMAIL))
				{
					$this->addError('username','Please use a valid email address.');
				}
				else
				{
					$account=Account::model()->find(array(
						'condition'=>'username=:username',
						'params'=>array(
							':username'=>$this->username
						)
					));
					$account2 = Account::model()->findByPk($id);
					
					if($account !== null)
						if($account->username !== $account2->username)
							$this->addError('username','Email address is already in use.');	
				}
			}
		}
	}


	//comparing current password
	public function findPasswords($attribute, $params)
    {
        $account= Account::model()->findByPk(Yii::app()->user->id);
        if (!$this->validatePassword($this->current_password))
            $this->addError($attribute, 'Old password is incorrect.');
    }

    public function countDel($chapter_id, $status_id)
    {
    	$x = 0;
		$accounts = Account::model()->findAll(array(
			'condition'=>'status_id = '.$status_id,
			'order'=>'id desc'));

		foreach($accounts as $account)
		{
			$user = User::model()->find(array('condition'=>'account_id = '.$account->id.' AND chapter_id = '.$chapter_id));

			if($user!=null && $user->account_id != Yii::app()->user->id)
				$x++;
		}

		return $x;
    }

    public function getRole()
    {
    	$model=AccountType::model()->find(array(
    		'condition' => 'id=:id',
    		'params' => array(
    			':id' => $this->account_type_id,
    			)
    		));
    	if($model!==NULL)
    		return $model->account_type;
    }
}