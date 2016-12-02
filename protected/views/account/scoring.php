<style>
	hr{
		margin-top: 10px;
	}

	label{
		font-size:17px;
	}

	input[type="text"]
	{
	    font-size:17px;
	}

	option
	{
	    font-size:17px;
	}

	input[type=checkbox]
	{
	  /* Double-sized Checkboxes */
	  -ms-transform: scale(1.5); /* IE */
	  -moz-transform: scale(1.5); /* FF */
	  -webkit-transform: scale(1.5); /* Safari and Chrome */
	  -o-transform: scale(1.5); /* Opera */
	  padding: 5px;
	}
</style>
<!-- Main content -->
<section class="content">
	<form method="post" enctype="multipart/form-data">
	<div class="row" style="padding:20px;">
		<form method="post">

		<div class="col-md-1"></div>

		<div class="col-md-10">
			<!--<h2 style="text-align:center;">Report Scoring</h2>
			<h4 style="text-align:center;">Answer the following questions</h2>
			<hr> -->
			<br />
			<div class="panel panel-info">
				<div class="panel-heading">
					<h2 style="margin-top:0;">
						<label class="label label-danger" style="margin-right:10px;"><?php echo $description->rep_id; ?></label>  
						<?php echo $description->description; ?>
					</h2>
				</div>

				<div class="panel-body" style="padding:20px">
					<?php if($description->goal_point != null): ?>
					<div class="row" style="margin-left:15px; margin-bottom:20px;">
						<h3 style="margin-bottom:20px;"> 
							<span class="fa fa-check-square-o" style="margin-right:10px;"> </span>
							<b><i>GOAL</i></b> : <?php echo $description->details; ?>
						</h3>

						<div class="well" style="margin-right:50px;margin-left:20px;">
							<h3 style="margin-top:0px;">Was the goal achieved?</h3> 
							
		    				<!--<input type="checkbox" class="score" value="1" name="goal" /><label style="margin-left:10px;"> Yes </label>
		    				<br/>
		    				<input type="checkbox" class="score" value="2" name="goal" /> <label style="margin-left:10px;"> No </label> -->
		    				<br/>
		    				<div class="btn-group" data-toggle="buttons">
							  <label class="btn btn-info btn-lg">
							    <input type="radio" name="goal" value="1" autocomplete="off" required> Yes
							  </label>
							  <label class="btn btn-info btn-lg">
							    <input type="radio" name="goal"  value="2" autocomplete="off" required> No
							  </label>
							</div>
		    			</div>
		    		</div>
		    		<?php endif; ?>

		    		<hr/>

		    		<?php if($description->criteria_point != null): ?>
		    		<div class="row" style="margin-left:15px; margin-bottom:20px;">
						<h3 style="margin-bottom:20px;">
							<span class="fa fa-check-square-o" style="margin-right:10px;"> </span> 
							<b><i>CRITERIA</i></b> : <?php echo $description->remarks; ?>
						</h3>

						<div class="well" style="margin-right:50px;margin-left:20px;">
							<h3 style="margin-top:0px;">Was the criteria met?</h3> 
							
							<br/>
		    				<div class="btn-group" data-toggle="buttons">
							  <label class="btn btn-info btn-lg">
							    <input type="radio" name="criteria" value="1" autocomplete="off" required> Yes
							  </label>
							  <label class="btn btn-info btn-lg">
							    <input type="radio" name="criteria"  value="2" autocomplete="off" required> No
							  </label>
							</div>
		    			</div>
		    		</div>
		    		<?php endif; ?>

		    		<?php if($description->max != null): ?>
		    		<hr/>

		    		<div class="row" style="margin-left:15px; margin-bottom:20px;">
						<h3 style="margin-bottom:20px;">
							<span class="fa fa-calculator" style="margin-right:10px;"> </span> 
							<b><i>QUANTITY</i></b>
						</h3>
						
						<div class="row">
							<div class="form-group col-md-6">
		    					<input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity / Amount" required />
		    				</div>
		    			</div>
		    		</div>
		    		<?php endif; ?>
		    	</div>

		    	<div class="panel-footer">
		    		<div class="row">
		    			<button type="submit" class="btn btn-lg btn-primary pull-right" style="margin-right:20px;" name="submit" > 
		    				<span class="fa fa-check" style="margin-right:10px"></span>S U B M I T
		    			</button>
		    		</div>
		    	</div>
		    	
	    	</div>
		</div>

		<div class="col-md-1"></div>
	</div>
	
	</form>
</section><!-- /.content -->