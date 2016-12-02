<?php
/* add variables or conditions if need */
	class AdminLeftside extends CWidget
	{
		
		public function init()
		{
			
		}
		
		public function run()
		{	
			$id = Yii::app()->getModule('training')->user->id;
			$user = User::model()->find(array('condition' => 'account_id= "'.$id.'"'));

			$fileupload = Fileupload::model()->findByPk($user->user_avatar);
			$user_avatar = $fileupload->filename;

			// $category = PeaCategory::model()->findAll();
			// $avp = PeaAvpActivate::model()->find();

			$this->render("leftside",array(
				'user' => $user, 
				'user_avatar'=>$user_avatar, 
				// 'category'=>$category,
				// 'avp'=> $avp,
			));
		}
	}
?>