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
			<div class="well">
				<div class="row">
		    		<h2 style="margin-top:0;text-align:center;">SCORE</h2>
		    		<hr />
		    	</div>

		    	<div class="row">
			    	<h1 style="margin-top:0px;text-align:center;font-size:150px;">
			    		<?php if($score <= 1): ?>
			    			<?php echo $score;?><small style="margin-left:10px;font-size:40px;">Point</small>
			    		<?php else: ?>
			    			<?php echo $score;?><small style="margin-left:10px;font-size:50px;">PTS</small>
			    		<?php endif; ?>
			    	</h1>
			    </div>

			    <div class="row">
			    	<h4 style="text-align:center;">
			    		<label class="label label-danger" style="margin-right:10px; margin-bottom:10px;"><?php echo $description->rep_id; ?></label><?php echo " ".$description->description; ?>
			    	</h4>
			    </div>

			   	<div class="row">
			    	<p style="text-align:center;">
			    			<span>
			    				<?php if($g === "Y"): ?>
			    					<i class="fa fa-check" style="margin-right:10px;font-size:20px;"></i>Goal Accomplished
			    				<?php else: ?>
			    					<span style="color:#FF0000;"><i class="fa fa-times" style="margin-right:10px;font-size:20px;"></i>Goal Failed</span>
			    				<?php endif; ?>
			    			</span>
			    			<?php if($description->qty === "F"): ?>
			    			<br />
			    			<span>
			    				<?php if($description->criteria_point != 0): ?>
				    				<?php if($c === "Y" && $g === "Y"): ?>
				    					<i class="fa fa-check" style="margin-right:10px;font-size:20px;"></i>Criteria Met
				    				<?php else: ?>
				    					<span style="color:#FF0000;"><i class="fa fa-times" style="margin-right:10px;font-size:20px;"></i>Criteria Not Met</span>
				    				<?php endif; ?>
				    			<?php endif; ?>
			    			</span>
			    			<?php endif; ?>
			    	</p>
			    </div>

			    <br/>

			    <div class="row">
			    	<!-- <p style="text-align:center;">
			    		<div class="col-xs-6">
			    			<h4 style="margin-left:20px;">RAW SCORE 
			    				<?php if($summary == null): ?>
			    					<span class="label label-danger">0</span>
			    				<?php else: ?>
			    					<span class="label label-primary"><?php echo $summary->overall_score; ?></span>
			    				<?php endif; ?>
			    			</h4>
			    		</div>
			    		<div class="col-xs-6">
			    			<h4 style="margin-left:20px;">PERCENTAGE
			    				<?php if($summary == null): ?>
			    					<span class="label label-danger">0</span>
			    				<?php else: ?>
			    					<span class="label label-success"><?php echo $summary->percentage; ?></span>
			    				<?php endif; ?>
			    			</h4>
			    		</div>
			    	</p>-->
			    	<p style="text-align:center;"><b><i><small> *IMPORTANT: Your chapter will only gain this score after the Approval of NSG.</small></i></b></p>
			    </div>

			    <div class="row">
			    	<hr />
			    	<a href="<?php echo Yii::app()->baseUrl; ?>/index.php/account/editreport?id=<?php echo $id; ?>">
			    		<button class="btn btn-lg btn-danger pull-left" style="margin-left:20px;"> <i class="fa fa-chevron-left" style="margin-right:10px;"></i> BACK </button>
			    	</a>
			    	<a href="<?php echo Yii::app()->baseUrl; ?>/index.php/account/listscoring">
			    		<button class="btn btn-lg btn-primary pull-right" style="margin-right:20px;"> DONE  <i class="fa fa-chevron-right" style="margin-left:10px;"></i> </button>
			    	</a>
			    </div>

	    	</div>
		</div>

		<div class="col-md-3"></div>
	</div>
</section><!-- /.content -->