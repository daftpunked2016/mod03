<tr>
	<td><?php echo CHtml::encode($data->chapter); ?></td>
	<!-- CONNECT == 1-->
	<td>
		<?php echo PeaReports::model()->getCount(CHAPTER, $data->id, 1); ?>
	</td>
	<!-- MOTIVATE == 2-->
	<td>
		<?php echo PeaReports::model()->getCount(CHAPTER, $data->id, 2); ?>
	</td>
	<!-- IMPACT == 3-->
	<td>
		<?php echo PeaReports::model()->getCount(CHAPTER, $data->id, 3); ?>
	</td>
	<!-- INVEST == 4-->
	<td>
		<?php echo PeaReports::model()->getCount(CHAPTER, $data->id, 4); ?>
	</td>
	<!-- COLLABORATE == 5-->
	<td>
		<?php echo PeaReports::model()->getCount(CHAPTER, $data->id, 5); ?>
	</td>
	<!-- OTHERS == 6-->
	<td>
		<?php echo PeaReports::model()->getCount(CHAPTER, $data->id, 6); ?>
	</td>
</tr>