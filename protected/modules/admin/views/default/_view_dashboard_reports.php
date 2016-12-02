<tr>
	<!-- AREA #s -->
	<td>
		<strong><?php echo CHtml::link("AREA - ".$data->area_no, array('default/regionreport', 'ano'=>$data->area_no)); ?></strong>
	</td>
	<!-- CONNECT == 1-->
	<td>
		<?php echo PeaReports::model()->getCount("AREA", $data->area_no, 1); ?>
	</td>
	<!-- MOTIVATE == 2-->
	<td>
		<?php echo PeaReports::model()->getCount("AREA", $data->area_no, 2); ?>
	</td>
	<!-- IMPACT == 3-->
	<td>
		<?php echo PeaReports::model()->getCount("AREA", $data->area_no, 3); ?>
	</td>
	<!-- INVEST == 4-->
	<td>
		<?php echo PeaReports::model()->getCount("AREA", $data->area_no, 4); ?>
	</td>
	<!-- COLLABORATE == 5-->
	<td>
		<?php echo PeaReports::model()->getCount("AREA", $data->area_no, 5); ?>
	</td>
	<!-- OTHERS == 6-->
	<td>
		<?php echo PeaReports::model()->getCount("AREA", $data->area_no, 6); ?>
	</td>
</tr>