<script>
$(function () {
	$('#search_filters').on("click",function(e){
		e.preventDefault();
		$("#search-well").slideToggle();
	});

	$('[data-toggle="tooltip"]').tooltip();
	$("#ranking-table").DataTable({
	  "pageLength": 20,
	});

});
</script>
<style>
a {
   color:inherit;
}
</style>

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
	<h2 style="text-align:center; margin-top:5px;">
		<i class="glyphicon glyphicon-list-alt" style="margin-right:10px;"></i>JCI eTraining Ranking 
		<small>
			<?php 
				if($area >= 1 && $area <= 5)
					echo "AREA ".$area;
				else
					echo "NATIONAL";

			?>
		</small>
	</h2>
</section>

<section class="content" style="padding:10px 30px;">
	<div class="row">
		<div class="col-xs-12" style="margin-bottom:5px;">
			<div class="pull-right">
				<a href="#" id="search_filters"><i class="fa fa-search" style="margin-right:5px;"></i>Ranking Filters</a>
			</div>
		</div>
	</div>

	<div class="well" style="margin:20px 20px; display:none;" id="search-well">
		<div class="row">
			<form name="search" method="GET" action="<?php echo Yii::app()->baseUrl; ?>/index.php/training/etrainingScorecard/ranking">
				<div class="col-md-6">
					<div class="form-group">
						Area
						<select name="area" class="form-control" required>
							<option value="">Select Area..</option>
							<option value="*" <?php if($area == "*") echo "selected"; ?>>National* (ALL)</option>
							<option value="1" <?php if($area == "1") echo "selected"; ?>>Area 1</option>
							<option value="2" <?php if($area == "2") echo "selected"; ?>>Area 2</option>
							<option value="3" <?php if($area == "3") echo "selected"; ?>>Area 3</option>
							<option value="4" <?php if($area == "4") echo "selected"; ?>>Area 4</option>
							<option value="5" <?php if($area == "5") echo "selected"; ?>>Area 5</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						List Count
						<select name="count" class="form-control" required>
							<option value="">Select Count..</option>
							<option value="*" <?php if($count == "*") echo "selected"; ?>>ALL</option>
							<option value="10" <?php if($count == "10") echo "selected"; ?>>Top 10</option>
							<option value="20" <?php if($count == "20") echo "selected"; ?>>Top 20</option>
						</select>
					</div>
				</div>
				<input type="submit" class="btn btn-primary pull-right" style="margin-right:10px;" value="Search" name="submit"> 
			</form>
		</div>
	</div>

	<div class="row">
		<div class="box">
			<div class="table-responsive">
			<?php  $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$rankingDP,
				'itemView'=>'_view_ranking',
				'template' => "{sorter}<table id=\"ranking-table\" class=\"table table-bordered table-hover\" style=\"font-size:110%\">
					<thead class='panel-heading'>
						<th width='10%'>Rank</th>
						<th width='50%'>Chapter</th>
						<th width='20%'>Raw Score</th>
						<th width='20%'>Percentage</th>
					</thead>
					<tbody>
						{items}
					</tbody>
				</table>
				{pager}",
				'emptyText' => "<tr><td colspan=\"3\">No available entries</td></tr>",
			));  ?>
			</div>

			<span class="pull-right" style="margin:20px 10px;">
				<strong>Date: </strong><?php echo date('M d, Y'); ?>
			</span>
		</div>
	</div>
	<br></br>
</section>
