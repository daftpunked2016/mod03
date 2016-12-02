<section class="content-header">
	<h1>
		Chapters Report
		<small>view</small>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo CHtml::link(AreaRegion::model()->getRegion($region->id), array('site/dashboard')); ?></li>
		<li class="active">View</li>
	</ol>
</section>

<section class="content">
	<div class="box">
		<div class="box-header with-border">
			<div class="pull-left">
				<?php echo CHtml::link('<i class="fa fa-chevron-left"></i>', array('site/dashboard'), array('class'=>'btn btn-success btn-flat', 'title'=>'Back')); ?>
				Total REPORTS for CHAPTER LEVEL
			</div>
			<div class="pull-right">
				<i class="fa fa-cogs"></i>
			</div>
		</div>
		<div class="box-body">
			<?php  $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$chaptersDP,
				'itemView'=>'_view_chapter_report',
				'template' => "{sorter}<table id=\"example1\" class=\"table table-bordered table-hover\">
					<thead class='panel-heading'>
						<th>CHAPTERS</th>
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
			Total REPORTS for CHAPTER LEVEL
		</div>
	</div>
</section>