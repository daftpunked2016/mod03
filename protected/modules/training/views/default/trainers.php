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
		<?php echo $trainer_type; ?>
		<small>list</small>
	</h1>
</section>

<section class="content">
	<div class="box">
		<div class="box-header with-border">
			<div class="pull-left">
				List of <?php echo $trainer_type; ?>
			</div>
			<div class="pull-right">
				<?php echo CHtml::link('<i class="fa fa-user-plus"></i> Add '.$trainer_type, array('#'), array('class'=>'btn btn-primary btn-flat assign-trainer', 'data-type'=>$type)); ?>
			</div>
		</div>
		<div class="box-body">
			<?php  $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$usersDP,
				'itemView'=>'_view_trainers',
				'template' => "{sorter}<table id=\"example1\" class=\"table table-bordered table-hover\">
						<thead class='panel-heading'>
							<th>Picture</th>
							<th>Email Address</th>
							<th>Name</th>
							<th>Area - Region</th>
							<th>Chapter</th>
							<th>Action</th>
						</thead>
					<tbody>
						{items}
					</tbody>
				</table>
				{pager}",
				'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
			));  ?>
		</div>
		<div class="box-footer">
			List of <?php echo $trainer_type; ?>
		</div>
	</div>
</section>

<!-- create account modal -->
<div class="modal fade" id="addTrainerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center">
                <strong>Assign <?php echo $trainer_type; ?></strong>
              </h4>
            </div>
            <div class="modal-body">
              <div class="box">
                  <div class="box-body">
                	<div id="trainer-results"></div>
                  </div><!-- /.box-body -->
                </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="submit" id="submit" class="btn btn-primary btn-flat pull-right">Submit Bet</button>
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>
            </div> -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->