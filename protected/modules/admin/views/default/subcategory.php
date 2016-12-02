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
		<?php echo $subcat->SubCat; ?>
		<small>descriptions for JCI <?php echo $subcat->SubCat; ?></small>
	</h1>
</section>

<section class="content">
	<div class="row">
		<div class="content">
			<div class="box">
				<?php  $this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$descriptionDP,
					'itemView'=>'_view_descriptions',
					'template' => "{sorter}<table id=\"example1\" class=\"table table-bordered table-hover\">
					<thead class='panel-heading'>
					<th>Reference ID</th>
					<th>Description</th>
					<th>Goal</th>
					<th>Criteria</th>
					<th>Details</th>
					<th>Goal Point</th>
					<th>Criteria Point</th>
					<th>MAX</th>

					<th class='text-center'>Action</th>

					</thead>
					<tbody>
					{items}
					</tbody>
					</table>
					{pager}",
					'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
				));  ?>
				<div class="text-center">
					<?php echo CHtml::link('<span class="btn-sm btn-warning"><i class="fa fa-plus"></i> Add Description</span>', array('/admin/description/add', 'id' => $subcat->sub_id), array('class' => 'btn', 'title' => 'Add Description',)); ?>
				</div>
			</div>
			
		</div>
		
	</div>
</section>