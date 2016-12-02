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
		Region Stats
		<small>view</small>
	</h1>
</section>

<section class="content">
	<div class="box">
		<div class="box-header with-border">
			<div class="pull-left">
				<?php echo CHtml::link('<i class="fa fa-chevron-left"></i>', array('default/index'), array('class'=>'btn btn-default btn-flat'))?>
				<strong><?php echo $card->pea_code; ?></strong> : <?php echo $card->measure; ?>
			</div>
			<div class="pull-right">
				<strong>
					<!-- TOTAL:  -->
				</strong>
			</div>
		</div>
		<div class="box-body">
			<?php
				$scores = EtrainingScorecard::model()->getRegionCount($card->pea_code, $area_no);

				$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$regionsDP,
					'viewData'=> array('pea_code'=>$card->pea_code, 'scores'=>$scores),
					'itemView'=>'_view_region_stats',
					'template' => "{sorter}<table id=\"example1\" class=\"table table-responsive table-bordered table-hover\">
							<thead class='panel-heading'>
								<th>Region</th>
								<th>Total</th>
							</thead>
						<tbody>
							{items}
						</tbody>
					</table>
					{pager}",
					'emptyText' => "<tr><td class='text-center' colspan=\"6\">No available entries</td></tr>",
				));
			?>
		</div>
		<div class="box-footer">Region Level</div>
	</div>
</section>

<!-- chapters Modal -->
<div class="modal fade" id="chaptersModal" tabindex="-1" role="dialog">
  	<div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title">List of Chapters</h4>
          	</div>
          	<div class="modal-body">
          		<div class="box">
	                <div class="box-body">
	         			<div id="chapter-results"></div>
	                </div><!-- /.box-body -->
              	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          	</div>
        </div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->