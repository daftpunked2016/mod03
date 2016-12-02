<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	
	public function authenticate()
	{
		$username=strtolower($this->username);
       
	   	$user=Account::model()->isActive()->isAuth()->find('LOWER(username)="'.$username.'" AND (account_type_id = 2 OR account_type_id = 3)');
		$userinactive = Account::model()->isInactive()->find('LOWER(username)="'.$username.'" AND (account_type_id = 2 OR account_type_id = 3)');
		$userinactivepause = Account::model()->isInactivePause()->find('LOWER(username)="'.$username.'" AND (account_type_id = 2 OR account_type_id = 3)');
		// $userreset = Account::model()->isReset()->find('LOWER(username)="'.$username.'" AND (account_type_id = 2 OR account_type_id = 3)');
		
 	    if($user==null && $userinactive==null && $userinactivepause==null /*&& $userreset==null*/)
            Yii::app()->user->setFlash('error', 'Account not available or invalid!');
		else if($userinactive!=null || $userinactivepause!=null)
			Yii::app()->user->setFlash('error', 'Account is inactive! Please verify your e-mail address first.');
		// else if($userreset != null)
		// {
		// 	$this->_id=$userreset->id;
		  //$this->username=$userreset->username;
		  //$this->errorCode=self::ERROR_NONE;
		// }
        else if(!$user->validatePassword($this->password))
       	{ 
       		$this->errorCode=self::ERROR_PASSWORD_INVALID;
			Yii::app()->user->setFlash('error', 'Email / Password invalid!'); 
		}
        else
        {
      		$user_details = User::model()->find('account_id = '.$user->id);

      		if($user_details->position_id == 8 || $user_details->position_id == 9 || $user_details->position_id == 11 || $user_details->position_id == 13)
      		{
	            $this->_id=$user->id;
	            $this->username=$user->username;
	            $this->errorCode=self::ERROR_NONE;
           	}
           	else
           		Yii::app()->user->setFlash('error', 'Account not available or invalid!');
        }
		
        return $this->errorCode==self::ERROR_NONE;
	}
	
	public function getId()
    {
        return $this->_id;
    }
}