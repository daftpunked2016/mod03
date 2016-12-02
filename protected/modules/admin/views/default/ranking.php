<script>
$(function () {
	$('#search_filters').on("click",function(e){
		e.preventDefault();
		$("#search-well").slideToggle();
	});

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
		<i class="glyphicon glyphicon-list-alt" style="margin-right:10px;"></i>JCIPEA Ranking 
		<small>
			<?php 
				if($area_filter == '1' || $area_filter == "2" ||  $area_filter == "3" ||  $area_filter == "4" ||  $area_filter == "5")
					echo "AREA ".$area_filter;
				else
					echo "NATIONAL";

			?>
		</small>
		<?php if($topdf == null): ?>
			<span class="pull-right hidden-sm hidden-xs" style="font-size:100%">
				<a href="<?php echo Yii::app()->request->url; if($area == null) echo "?"; else echo "&"; ?>topdf=1" class="btn btn-primary btn-xs"><i class="fa fa-print" style="margin-right:5px;"></i>Print Page</a>
			</span>
		<?php endif; ?>
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
			<form name="search" method="GET" action="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/default/ranking">
				<div class="col-md-4">
					<div class="form-group">
						Area
						<select name="area" class="form-control" required>
							<option value="">Select Area..</option>
							<option value="*">National* (ALL)</option>
							<option value="1">Area 1</option>
							<option value="2">Area 2</option>
							<option value="3">Area 3</option>
							<option value="4">Area 4</option>
							<option value="5">Area 5</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						List Count
						<select name="count" class="form-control" required>
							<option value="">Select Count..</option>
							<option value="*">ALL</option>
							<option value="10">Top 10</option>
							<option value="20">Top 20</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						Seal
						<select name="seal" class="form-control">
							<option value="*">Select Seal..</option>
							<option value="*">ALL</option>
							<option value="Bronze">Bronze</option>
							<option value="Silver">Silver</option>
							<option value="Gold">Gold</option>
							<option value="Platinum">Platinum</option>
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
				'viewData' => array('seal_filter'=>$seal_filter),
				'template' => "{sorter}<table id=\"ranking-table\" class=\"table table-bordered table-hover\" style=\"font-size:110%\">
					<thead class='panel-heading'>
						<th width='5%'>Rank</th>
						<th width='40%'>Chapter</th>
						<th width='15%'>No. of 100% Efficiency</th>
						<th width='20%'>Seal</th>
						<th width='20%'>Rating</th>
						<th width='20%'>Raw Score</th>
					</thead>
					<tbody>
						{items}
					</tbody>
				</table>
				{pager}",
				'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
			));  ?>
			</div>

			<span class="pull-right" style="margin:20px 10px;">
				<strong>Date: </strong><?php echo date('M d, Y'); ?>
			</span>
		</div>
	</div>
	<br></br>
</section>
