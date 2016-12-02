<?php $chapter = Chapter::model()->findByPk($data->chapter_id); ?>
<tr>
	<td>
		<?php
			$fileupload = Fileupload::model()->findByPk($data->user_avatar);
			$user_avatar = $fileupload->filename;
		?>
		<img class="img-circle" style="width:50px; height:50px;" src="http://www.jci.org.ph/mod02/user_avatars/<?php echo $user_avatar; ?>">
	</td>
	<td>
		<?php echo CHtml::encode($data->account->username); ?>
	</td>
	<td>
		<?php echo CHtml::encode($data->firstname." ".$data->lastname); ?>
	</td>
	<td>
		<?php echo "AREA ".$chapter->area_no." - ".AreaRegion::model()->getRegion($chapter->region_id); ?>
	</td>
	<td><?php echo Chapter::model()->getChapter($data->chapter_id); ?></td>
	<td>
		<?php echo CHtml::link('<i class="fa fa-user-times"></i> Unassign Trainer', array('default/remove', 'type'=>$data->training_position_id, 'id'=>$data->id), array('class'=>'btn btn-danger btn-flat', 'confirm'=>'Are you sure you want to Unassign this Trainer?')) ?>
	</td>
</tr>