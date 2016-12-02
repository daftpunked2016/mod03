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
		Training Card
		<small>list</small>
	</h1>
</section>

<section class="content">
	<div class="box">
		<div class="box-header with-border">
			<div class="pull-left">
				List of Trainings
			</div>
			<div class="pull-right">
				<?php echo CHtml::link('<i class="fa fa-plus"></i> Add Training Score card', array('etrainingScorecard/create'), array('class'=>'btn btn-primary btn-flat')); ?>
			</div>
		</div>
		<div class="box-body">
			<?php  $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$cardsDP,
				'itemView'=>'_view_cards',
				'template' => "{sorter}<table id=\"example1\" class=\"table table-responsive table-bordered table-hover\">
						<thead class='panel-heading'>
							<th width='20%'>Category</th>
							<th width='5%'>Rep ID</th>
							<th width='40%'>Measure</th>
							<th width='10%'>Goal Point</th>
							<th class='text-center' width='10%'>Action</th>
						</thead>
					<tbody>
						{items}
					</tbody>
				</table>
				{pager}",
				'emptyText' => "<tr><td class='text-center' colspan=\"5\">No available entries</td></tr>",
			));  ?>
		</div>
		<div class="box-footer">
			List of Trainings
		</div>
	</div>
</section>