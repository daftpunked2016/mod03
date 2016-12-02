<style>
	hr{
		margin-top: 10px;
	}
</style>
<!-- Main content -->
<section class="content">
	<div class="row" style="padding:30px;">
		<div class="col-md-3"></div>

		<div class="col-md-6">
			<div class="well" style="padding:20px;">
				<div class="row">
		    		<h4 style="margin-top:0;text-align:center;">Select Chapter</h4>
		    		<hr />
		    	</div>


			    <div class="row">
			    	<?php if($user->position_id == 8): ?>
				    	<div class="row">
					    	<div class="col-md-2"> Region </div>
					    	<div class="col-md-10">
					    		<select class="form-control" id="region_no" required>
					    			<option value="">Select Region..</option>
					    			<?php 
					    			$regions = AreaRegion::model()->findAll('area_no = '.$user->chapter->area_no);

					    			foreach($regions as $region)
					    				echo "<option value=".$region->id.">".$region->region."</option>";
					    			?>
					    		</select>
					    	</div>
					    </div>

					    <div class="row" style="margin-top:20px;">
					    	<div class="col-md-2"> Chapter </div>
					    	<div class="col-md-10">
					    		<select class="form-control" id="chapter" required>
					    			<option value="">Select Chapter..</option>
					    		</select>
					    	</div>
					    </div>
					<?php elseif($user->position_id == 9): ?>
						<div class="row">
					    	<div class="col-md-2"> Chapter </div>
					    	<div class="col-md-10">
					    		<select class="form-control" id="chapter" required>
					    			<option value="">Select Chapter..</option>
					    			<?php 
					    			$chapters = Chapter::model()->findAll('region_id = '.$user->chapter->region_id);

					    			foreach($chapters as $chapter)
					    				echo "<option value=".$chapter->id.">".$chapter->chapter."</option>";
					    			?>
					    		</select>
					    	</div>
					    </div>
			    	<?php endif; ?>

			    	<div class="row" style="margin-top:20px;">
			    		<button class="btn btn-primary">VIEW SCORE</button>
					</div>
			    </div>

	    	</div>
		</div>

		<div class="col-md-3"></div>
	</div>
</section><!-- /.content -->