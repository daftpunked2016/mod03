<tr>
	<td>
		<?php //echo CHtml::encode($data->id); 
			$fileupload = Fileupload::model()->findByPk($data->member_avatar);
			$member_avatar = $fileupload->filename;
		?>
		<img class="img-circle" style="width:50px; height:50px;" src="<?php echo Yii::app()->request->baseUrl; ?>/member_avatars/<?php echo $member_avatar; ?>">
	</td>
	<td>
		<?php echo CHtml::encode($data->email_address); ?>
	</td>

	<td>
		<?php 
			$title = Title::model()->find(array('condition' => 'id ='.$data->title));
			echo "JCI ".CHtml::encode($title->title)." ".CHtml::encode($data->firstname)." ".CHtml::encode($data->lastname); 
		?>
	</td>
	<td>
		<?php
		$position = Position::model()->find(array('condition' => 'id ='.$data->position_id));

		echo CHtml::encode($position->category)." ".CHtml::encode($position->position);
		?>
	</td>
</tr>