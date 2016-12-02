<?php
/* add variables or conditions if need */
class UserLeftside extends CWidget
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

		$this->render("userLeftside",array(
			'user_avatar' => $user_avatar,
			'user'=>$account->user,
		));
	}
}
?>