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
			echo CHtml::link('<span class="btn-flat btn-success btn-sm" style="margin-right:5px;">Activate</span>', array('account/activate', 'id' => $data->id));
		?>
	</td>
</tr>