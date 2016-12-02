<?php
/* add variables or conditions if need */
class UserHeader extends CWidget
{
	
	public function init()
	{
		
	}
	
	public function run()
	{	
		$user_avatar="";
		$account = Account::model()->findByPk(Yii::app()->user->id);
		$fileupload = Fileupload::model()->findByPk($account->user->user_avatar);
		$user_avatar = $fileupload->filename;
		
		$this->render("userHeader",array(
			'user_avatar' => $user_avatar,
		));
	}
}
?>