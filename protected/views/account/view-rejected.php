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
	</h1>
</section>

<section class="content">
	<div class="row" style="margin-top:10px; margin-bottom:10px;">
		<div class="col-md-8 hidden-sm hidden-xs">
			<span style="margin-right:10px;"><i class="fa fa-file-image-o" style="margin-right:3px;"></i>- <small>Project Photo</small></span>
			<span style="margin-right:10px;"><i class="fa fa-list" style="margin-right:3px;"></i>- <small>Attendance Sheet</small></span>
			<span style="margin-right:10px;"><i class="fa fa-info" style="margin-right:3px;"></i>- <small>Status History</small></span>
			<?php if($pos == 13 || $pos == 11): ?>
				<span style="margin-right:10px;"><i class="fa fa-pencil" style="margin-right:3px;"></i>- <small>Edit & Resubmit</small></span>
			<?php endif; ?>
			<span style="margin-right:10px;"><i class="fa fa-trash-o" style="margin-right:3px;"></i>- <small>Delete Report</small></span>
		</div>
	</div>

	<!-- filters for AVP -->
	<?php if($user_position == 8 ): ?>
	<div class="row">
		<form method="get" action="<?php echo Yii::app()->request->baseUrl; ?>/index.php/account/viewreports">
			
			<input type="hidden" name="st" value="r" />
			<div class="col-sm-4" style="margin-bottom:10px;">
				<select id="region" name="region" class="form-control" >
					<option value=""> - Please Select Region - </option>
					<?php 
						$region = AreaRegion::model()->findAll(array('condition'=>'area_no ='.$user->chapter->area_no));

						foreach($region as $reg)
							echo "<option value = '".$reg->id."'>".$reg->region."</option>";
					?>
				</select>
			</div>

			<div class="col-sm-4" style="margin-bottom:10px;">
				<select id="chapter" name="chapter_id" class="form-control" >
					<option value=""> -- </option>
				</select>
			</div>

			<div class="row"></div>

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
	<!-- filter for RVP -->
	<?php elseif ($user_position == 9): ?>
	<div class="row">
		<form method="get" action="<?php echo Yii::app()->request->baseUrl; ?>/index.php/account/viewreports">
			
			<input type="hidden" name="st" value="r" />
			<div class="col-sm-4" style="margin-bottom:10px;">
				<select id="chapter" name="chapter_id" class="form-control" >
					<option value=''>Please Select Chapter..</option>
					<?php $regionchapters = Chapter::model()->findAll(array('condition'=>'region_id ='.$user->chapter->region_id));
						foreach($regionchapters as $rchaps)
							echo "<option value = '".$rchaps->id."'>".$rchaps->chapter."</option>";
					?>
				</select>
			</div>

			<div class="row"></div>

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
	<?php endif; ?>

	<div class="row">
		<div class="box">
			<div class="table-responsive">
				<?php  $this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$reportDP,
					'viewData' => array( 'display_actions_status' => $display_actions_status, 'pos' => $pos ),   
					'itemView'=>'_view_rejected',
					'template' => "{sorter}<table id=\"example1\" class=\"table table-bordered table-hover\">
					<thead class='panel-heading'>
					<th>REP ID</th>
					<th>Project Title</th>
					<th>Chapter</th>
					<th>Uploaded By</th>
					<th>Date Uploaded</th>
					<th>Remarks</th>
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
