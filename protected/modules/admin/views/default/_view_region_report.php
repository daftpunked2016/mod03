<tr>
	<td>
		<?php echo CHtml::link($data->region, array('default/chapterreport', 'rid'=>$data->id)); ?>
	</td>
	<!-- CONNECT == 1-->
	<td>
		<?php echo PeaReports::model()->getCount("REGION", $data->id, 1); ?>
	</td>
	<!-- MOTIVATE == 2-->
	<td>
		<?php echo PeaReports::model()->getCount("REGION", $data->id, 2); ?>
	</td>
	<!-- IMPACT == 3-->
	<td>
		<?php echo PeaReports::model()->getCount("REGION", $data->id, 3); ?>
	</td>
	<!-- INVEST == 4-->
	<td>
		<?php echo PeaReports::model()->getCount("REGION", $data->id, 4); ?>
	</td>
	<!-- COLLABORATE == 5-->
	<td>
		<?php echo PeaReports::model()->getCount("REGION", $data->id, 5); ?>
	</td>
	<!-- OTHERS == 6-->
	<td>
		<?php echo PeaReports::model()->getCount("REGION", $data->id, 6); ?>
	</td>
</tr>