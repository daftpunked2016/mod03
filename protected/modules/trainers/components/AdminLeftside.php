<?php
/* add variables or conditions if need */
	class AdminLeftside extends CWidget
	{
		
		public function init()
		{
			
		}
		
		public function run()
		{	
			$id = Yii::app()->getModule('trainers')->user->id;
			$user = User::model()->find(array('condition' => 'account_id= "'.$id.'"'));

			$fileupload = Fileupload::model()->findByPk($user->user_avatar);
			$user_avatar = $fileupload->filename;

			switch ($user->training_position_id) {
				case 2:
					$filename = "atd-leftside";
					break;
				case 3:
					$filename = "rtd-leftside";
					break;
				case 4:
					$filename = "ltd-leftside";
					break;
			}

			$this->render($filename, array(
				'user' => $user, 
				'user_avatar'=>$user_avatar,
			));
		}
	}
?>