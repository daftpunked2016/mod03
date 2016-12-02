<section class="content-header">
	<?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
		if($key  === 'success')
			{
			echo "<div class='alert alert-success alert-dismissible' role='alert'>
			<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
			$message.'</div>';
			}
		else
			{
			echo "<div class='alert alert-danger alert-dismissible' role='alert'>
			<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
			$message.'</div>';
			}
		}
	?>
	<h1>
		My Report Drafts
	</h1>
</section>

<section class="content">
	<div class="row" style="margin-top:10px; margin-bottom:10px;">
		<div class="col-md-8 hidden-sm hidden-xs">
			<span style="margin-right:10px;"><i class="fa fa-pencil" style="margin-right:3px;"></i>- <small>Edit & Resubmit</small></span>
			<span style="margin-right:10px;"><i class="fa fa-trash-o" style="margin-right:3px;"></i>- <small>Delete Report</small></span>
		</div>
	</div>

	<div class="row">
		<div class="box">
			<div class="table-responsive">
				<?php  $this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$reportDP,
					'viewData' => array( 'display_actions_status' => $display_actions_status, 'pos' => $pos ),   
					'itemView'=>'_view_drafts',
					'template' => "{sorter}<table id=\"example1\" class=\"table table-bordered table-hover\">
					<thead class='panel-heading'>
					<th>REP ID</th>
					<th>Project Title</th>
					<th>Date Created</th>
					<th>Actions</th>
					</thead>
					<tbody>
					{items}
					</tbody>
					</table>
					{pager}",
					'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
				));  ?>
			</div>	
		</div>	
	</div>
</section>
