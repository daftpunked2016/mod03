<tr>
	<td>
		<?php //echo CHtml::encode($data->id); 
			$user = User::model()->find(array('condition' => 'account_id ='.$data->id));
			$fileupload = Fileupload::model()->findByPk($user->user_avatar);
			$user_avatar = $fileupload->filename;
		?>
		<img class="img-circle" style="width:50px; height:50px;" src="<?php echo Yii::app()->request->baseUrl; ?>/user_avatars/<?php echo $user_avatar; ?>">
	</td>
	<td>
		<?php echo CHtml::encode($data->username); ?>
	</td>
	<td>
		<?php echo CHtml::encode($user->firstname." ".$user->lastname); ?>
	</td>
	<td>
		<?php
			echo CHtml::link('<span class="btn-flat btn-danger btn-sm" style="margin-right:5px;">Deactivate</span>', array('account/deactivate', 'id' => $data->id), array('confirm' => "Are you sure you want to deactivate this account?", 'title' => 'Deactivate Account'));
		?>
	</td>
</tr>