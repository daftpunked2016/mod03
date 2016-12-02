<section class="content-header">
	<h1>
		Dashboard
		<small>view</small>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo CHtml::link('Dashboard', array('default/dashboard')); ?></li>
		<li class="active">View</li>
	</ol>
</section>

<section class="content">
	<div class="box">
		<div class="box-header with-border">
			Total REPORTS for AREA LEVEL
		</div>
		<div class="box-body">
			<?php  $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$areasDP,
				'itemView'=>'_view_dashboard_reports',
				'template' => "{sorter}<table id=\"example1\" class=\"table table-bordered table-hover\">
					<thead class='panel-heading'>
						<th>AREA #</th>
						<th>CONNECT</th>
						<th>MOTIVATE</th>
						<th>IMPACT</th>
						<th>INVEST</th>
						<th>COLLABORATE</th>
						<th>OTHERS</th>
					</thead>
					<tbody>
						{items}
					</tbody>
				</table>
				{pager}",
				'emptyText' => "<tr><td colspan=\"7\">No available entries</td></tr>",
			));  ?>
		</div>
		<div class="box-footer">
			Total REPORTS for AREA LEVEL
		</div>
	</div>
</section>