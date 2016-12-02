<section class="content-header">
	<h1>
		Dashboard
		<small>list</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Dashboard', array('site/index')); ?>
		</li>
		<li class="active">List</li>
	</ol>
</section>

<section class="content">
	<div class="box box-solid">
		<div class="box-header with-border">
			AREA <?php echo $ano; ?>
			<div class="pull-right">
				<span class="fa fa-cogs"></span>
			</div>
		</div>
		<div class="box-body">
			<?php  $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$regionsDP,
				'itemView'=>'_view_region_report',
				'template' => "{sorter}<table id=\"example1\" class=\"table table-bordered table-hover\">
					<thead class='panel-heading'>
						<th>REGIONS</th>
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
	</div>
</section>