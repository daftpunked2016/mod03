<tr>
	<td><?php echo CHtml::encode($data->rep_id); ?></td>
	<td><a href="<?php echo Yii::app()->baseUrl; ?>/index.php/account/editreport?id=<?php echo $data->id; ?>"><strong><?php echo CHtml::encode($data->project_title); ?></strong></a></td>
	<td><?php echo CHtml::encode(date('F d, Y', strtotime($data->date_upload))); ?></td>
	<td>
		<?php
        echo CHtml::link('<span class="fa fa-pencil" style="margin-right:3px;"></span>', array('/account/editreport', 'id' => $data->id), array('title' => 'Edit Report', 'target'=>'_blank', 'style'=>'margin-right:3px;'));
        echo CHtml::link('<span class="fa fa-trash-o" style="margin-right:3px;"></span>', array('/account/deletereport', 'id' => $data->id, 'view' => 'r'), array('confirm' => "Are you sure you want to DELETE this report?", 'title' => 'Delete Report', 'style'=>'margin-right:3px;'));
    ?>
	</td>
</tr>