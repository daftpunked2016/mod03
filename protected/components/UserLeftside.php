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

		if($account->user->position_id == 8 || $account->user->position_id == 9 || $account->user->position_id == 11 || $account->user->position_id == 13) {
			$this->render("userLeftside",array(
				'user_avatar' => $user_avatar,
				'user'=>$account->user,
			));
		} else {
			$this->render('writerLeftside', array(
				'user_avatar' => $user_avatar,
				'user'=>$account->user,
			));
		}

		
	}
}
?>