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
		Dashboard
		<small>view</small>
	</h1>
</section>

<section class="content">
	<div class="box">
		<div class="content-header with-border">
			<div class="pull-left">
				<form method="get" action="<?php echo Yii::app()->createUrl('training/default/index'); ?>">
					<div class="row">
						<div class="col-md-6">
							<select class="form-control" name="filters" required >
								<option value="" disabled selected>Select Category</option>
								<option value="blue" <?php if($_GET['filters'] == 'blue'){echo "selected"; } ?> >LO Tranining Management</option>
								<option value="green" <?php if($_GET['filters'] == 'green'){echo "selected"; } ?> >JCI Training Course Implemented</option>
								<option value="red" <?php if($_GET['filters'] == 'red'){echo "selected"; } ?> >Training Program/Initiatives</option>
								<option value="yellow" <?php if($_GET['filters'] == 'yellow'){echo "selected"; } ?> >Avante National Training Summit/Others</option>
							</select>
						</div>
						<div class="col-md-3">
							<input type="submit" value="Search" class="btn btn-success btn-flat">
						</div>
						<div class="col-md-3">
							<?php echo CHtml::link('<i class="fa fa-refresh"></i>', array('default/index'), array('class'=>'btn btn-success btn-flat')) ?>
						</div>
					</div>
				</form>
			</div>
			<div class="pull-right">
				<span class="fa fa-list"></span>
			</div>
		</div>
		<div class="box-body">
			<?php  $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$cardsDP,
				'itemView'=>'_view_area_stats',
				'template' => "{sorter}<table id=\"example1\" class=\"table table-responsive table-bordered table-hover\">
						<thead class='panel-heading'>
							<th>Rep ID</th>
							<th>Measure</th>
							<th>AREA 1</th>
							<th>AREA 2</th>
							<th>AREA 3</th>
							<th>AREA 4</th>
							<th>AREA 5</th>
							<th>Total</th>
						</thead>
					<tbody>
						{items}
					</tbody>
				</table>
				{pager}",
				'emptyText' => "<tr><td class='text-center' colspan=\"6\">No available entries</td></tr>",
			));  ?>
		</div>
		<div class="box-footer">List of Score Cards</div>
	</div>
</section>

<script>
$(function() {
	$('.scorecard').each(function() {
		var total_count = 0;

		$(this).children('.area-count').each(function() {
			 total_count += parseInt($(this).data('val'));
		});

		$(this).children('#total-count').html("<strong>"+total_count+"</strong>");
	});
});
</script>