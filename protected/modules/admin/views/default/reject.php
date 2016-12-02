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
		Rejected Reports
		<small>Rejected Reports</small>
	</h1>
</section>

<section class="content">
	<div class="row" style="margin-top:10px; margin-bottom:10px;">
		<div class="col-md-8 hidden-sm hidden-xs">
			<span style="margin-right:10px;"><i class="fa fa-file-image-o" style="margin-right:3px;"></i>- <small>Project Photo</small></span>
			<span style="margin-right:10px;"><i class="fa fa-list" style="margin-right:3px;"></i>- <small>Attendance Sheet</small></span>
			<span style="margin-right:10px;"><i class="fa fa-info" style="margin-right:3px;"></i>- <small>Status History</small></span>
			<span style="margin-right:10px;"><i class="fa fa-check" style="margin-right:3px;"></i>- <small>Approve</small></span>
		</div>
	</div>

	<div class="row">
		<form method="get" action="<?php echo Yii::app()->request->baseUrl; ?>/index.php/admin/default/reject">
			<?php $regions = AreaRegion::model()->findAll(array('select'=>'area_no', 'distinct'=>true)); ?>
			<div class="col-sm-4" style="margin-bottom:10px;">
				<select id="area_no" name="area_no" class="form-control" >
					<option value =''>Select Area No.</option>
					<?php 
						foreach($regions as $region)
							echo "<option value=".$region->area_no.">".$region->area_no."</option>";
					?>
				</select>
			</div>

			<div class="col-sm-4" style="margin-bottom:10px;">
				<select id="region" name="region" class="form-control" >
					<option value=""> -- </option>
				</select>
			</div>

			<div class="col-sm-4" style="margin-bottom:10px;">
				<select id="chapter" name="chapter_id" class="form-control" >
					<option value=""> -- </option>
				</select>
			</div>

			<?php $categories = PeaCategory::model()->findAll(); ?>
			<div class="col-md-4" style="margin-bottom:10px;">
				<select class="report form-control" name="category" id="pea-category-admin">
					<option value=''>Please Select Key Result Area..</option>
					<?php 
						$categories = PeaCategory::model()->findAll();

						foreach($categories as $category)
							echo "<option value = '".$category->cat_id."'>".$category->category."</option>";
					?>	
				</select>
			</div>

			<div class="col-md-4" style="margin-bottom:10px;">
				<select class="report form-control" name="subcat" id="pea-subcat-admin">
					<option value=''>Please Select Category..</option>
				</select>
			</div>

			<div class="col-md-4" style="margin-bottom:10px;">
				<select class="report form-control" name="rep_id" id="pea-refcode-admin">
					<option value=''>Please Select Reference Code..</option>
				</select>
			</div>

			<div class="col-sm-12" style="margin-bottom:10px;">
				<input type="submit" value="Search" class="btn btn-primary pull-right"/>
			</div>
		</form>
	</div>

	<div class="row">
		<div class="box">
			<div class="table-responsive">
			<?php  $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$reportDP,
				'itemView'=>'_view_report_reject',
				'template' => "{sorter}<table id=\"example1\" class=\"table table-bordered table-hover\">
					<thead class='panel-heading'>
						<th>REP CODE</th>
						<th>Project Title</th>
						<th>Chapter</th>
						<th>Uploaded By</th>
						<th>Date Uploaded</th>
						<th class='text-center'>QTY</th>
						<th class='text-center'>GOAL STATUS</th>
						<th class='text-center'>CRITERIA STATUS</th>
						<th>Remarks</th>
						<th class='text-center'>Action</th>
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
	<br></br>
</section>
