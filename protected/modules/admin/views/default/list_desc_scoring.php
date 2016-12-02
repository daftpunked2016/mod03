<style>
	hr{
		margin-top: 10px;
	}
</style>
<script>
$(function () {
	var raw_total = parseInt($('#raw_total_wo_green').text());
	var max_total = parseInt($('#max_total').text());
	var rating = (raw_total/(max_total/2))*100;

	if(rating > 99)
		rating = 100;

	$('#rating_total').html(Math.round(rating)+'%');


	$('#search_filters').on("click",function(e){
		e.preventDefault();
		$("#search-well").slideToggle();
	});

});
</script>
<!-- Main content -->
<div class="row">
	<section class="content">
		<h3 style="margin-left:20px;"> 
			<i class="fa fa-bar-chart" style="margin-right:10px;"></i>Scorecard for <i><?php echo $pea_subcat->SubCat; ?></i> <small>JCI <?php echo $chapter->chapter; ?></small> 
			<?php if($topdf == null): ?>
				<span class="pull-right hidden-sm hidden-xs" style="font-size:100%">
					<a href="<?php echo Yii::app()->request->url; ?>&topdf=1" class="btn btn-primary btn-xs" style="margin-bottom:15px; margin-right:10px;"><i class="fa fa-print" style="margin-right:5px;"></i>Print Page</a>
				</span>
			<?php endif; ?>
		</h3>

		<div class="row">
			<div class="col-md-7">
				<span class="label label-danger" style="margin-right:5px; margin-left:20px"> </span> <small>No Report Uploaded</small>
				<span class="label label-primary" style="margin-right:5px; margin-left:10px"> </span> <small>Bonus Score</small>
				<span class="label label-success" style="margin-right:5px; margin-left:10px"> </span> <small>Bonus Score</small>
			</div>
			<br style="margin-bottom:20px;" class="visible-xs visible-sm" />
			<div class="col-md-5">
				<span style="margin-left:10px; font-size:15px">RAW SCORE  
					<span class="label label-info" style="font-size:20px" id="raw_total">
						<?php echo PeaDescriptions::model()->computeRaw($pea_subcat->sub_id, $chapter->id); ?>
					</span>
				</span>
				<span style="margin-left:10px;margin-right:20px; font-size:15px" class="pull-right">RATING <span class="label label-success" style="font-size:20px" id="rating_total">0%</span></span>
			</div>
		</div>

		<div class="row" style="margin-top:20px; margin-right:10px;">
			<div class="col-xs-12">
				<div class="pull-right">
					<a href="#" id="search_filters"><i class="fa fa-search" style="margin-right:5px;"></i>Search Filters</a>
				</div>
			</div>
		</div>

		<div class="well" style="margin:10px 20px 0px; display:none;" id="search-well">
			<div class="row">
				<form name="search" method="GET">
					<div class="col-md-6">
						<div class="form-group">
							<?php if($chapter_id != null): ?>
								<input type="hidden" id="chapter_id" name="chapter_id" value="<?php echo $chapter_id; ?>" />
							<?php endif; ?>
							<input type="hidden" id="sub_id" name="sub_id" value="<?php echo $sub_id; ?>" />
							Annex <input type="text" id="annex" name="annex" class="form-control" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							Status 
							<select name="status" class="form-control">
								<option value="">Select Status..</option>
								<option value="">All</option>
								<option value="A">Approved</option>
								<option value="P">Pending</option>
								<option value="N">No Report Uploaded </option>
								<option value="B">Bonus (Blue)</option>
								<option value="G">Bonus (Green)</option>
							</select>
						</div>
					</div>
					<input type="submit" class="btn btn-primary pull-right" style="margin-right:10px;" value="Search" name="submit"> 
				</form>
			</div>
		</div>
		
		<br />

		<div class="box">
			<div class="row" style="padding:30px;">
				<div class="table-responsive">
				<?php 
					$this->widget('zii.widgets.CListView', array(
						'dataProvider'=>$descriptionsDP,
						'viewData' => array( 'chapter' => $chapter ),   
						'itemView'=>'_view_desc_scoring',
						'template' => "{sorter}<table id=\"example1\" class=\"table table-hover\">
						<thead class='panel-heading'>
							<th>Annex</th>
							<th>Description</th>
							<th>Goal Done?</th>
							<th>Criteria Met?</th>
							<th>How Many?</th>
							<th>Raw Score</th>
							<th>Actions</th>
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
		</div>

		<span id="max_total" style="display:none;"><?php echo PeaDescriptions::model()->computeMax($pea_subcat->sub_id); ?></span>
		<span id="raw_total_wo_green" style="display:none;"><?php echo PeaDescriptions::model()->computeRawWoGreen($pea_subcat->sub_id, $chapter->id); ?></span>
	</section><!-- /.content -->
</div>