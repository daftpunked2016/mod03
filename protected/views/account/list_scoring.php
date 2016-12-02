<style>
	hr{
		margin-top: 10px;
	}

	table tr td#subcat a.glass { display:none;}
  	table tr:hover td#subcat a.glass { display:inline-block; margin-left:20px;}
</style>
<script>
$(function () {
	var raw_overall = 0;
	var rating_overall = 0;
	var efficient_count = 0; 

	$( ".subcat" ).each(function( index ) {
		  	var raw_score = parseInt($(this).children("#raw").children("#raw_wo_green").text());
		  	var max_score = parseInt($(this).children("#max").text());

		  	if(max_score == 0) {
		  		var weight = 0;
		  	} else {
		  		var weight = Math.round((raw_score/(max_score/2))*100);
		  	}

		  	$(this).children("#weight").html('<i>'+weight+'%</i>');

		  	if(weight < 100) {
		  		$(this).children("#rating").html(weight+'%');
 		  	} else {
 		  		$(this).children("#rating").html('100%');
 		  	}
	    });


	$( ".categories" ).each(function( index ) {
			var raw_score_total = 0;
			var max_score_total = 0;
			var rating_total = 0;
		  	var cat_id = $(this).children("#cat_id").text();

		  	$(".subcat."+cat_id).each(function( index ) {
		  		raw_score_total = raw_score_total + parseInt($(this).children("#raw").text());
		  		max_score_total = max_score_total + parseInt($(this).children("#max").text());
		  		rating_total = rating_total + parseInt($(this).children("#rating").text());
	    	});

	    	$(this).children("#raw_total").html(raw_score_total);
			$(this).children("#max_total").html('<i>'+max_score_total+'</i>');
			$(this).children("#rating_total").html(parseInt(rating_total/3)+'%');
	});

	$( ".raw_total" ).each(function( index ) {
		  	var raw_score = parseInt($(this).text());
		  	raw_overall = raw_overall + raw_score;
	});

	$( ".rating_total" ).each(function( index ) {
		  	var rating_score = parseInt($(this).text());
		  	rating_overall = rating_overall + rating_score;
		  	//rating_overall = (rating_overall/5)*100;

		  	if(rating_overall > 99) {
		  		rating_overall = parseInt(100);
		  	}
	});


	$( ".rating" ).each(function( index ) {
		  	var rating_row = parseInt($(this).text());
		 
		  	if(rating_row == 100) {
		  		efficient_count = efficient_count + 1;
		  	}
	});


	if(parseInt($( "#rating_overall" ).text()) == 100) {
		$( "#pea_gavel_ans" ).removeClass( "label-danger" ).addClass( "label-success").html("YES");
	}

	if(efficient_count >= 1 && efficient_count <= 7) {
		$("#seal").removeClass( "label-danger" ).css("background-color","#CD7F32").html("BRONZE");
	} else if (efficient_count >= 8 && efficient_count <= 11) {
		$("#seal").removeClass( "label-danger" ).css("background-color","#C0C0C0").html("SILVER");
	} else if (efficient_count >= 12 && efficient_count <= 14) {
		$("#seal").removeClass( "label-danger" ).css({"background-color": "#FFD700", "color": "#000"}).html("GOLD");
	} else if (efficient_count == 15) {
		$("#seal").removeClass( "label-danger" ).css({"background-color": "#E5E4E2", "color": "#5D5F64"}).html("PLATINUM");
	}

	$("#rating_overall").html(rating_overall+'%');
	$("#efficient_count").html(efficient_count);
	$("#raw_overall").html(raw_overall);
});
</script>
<!-- Main content -->
<div class="row">
	<section class="content">
		<div class="row">
			<h2 style="margin-left:30px; margin-right:30px;"> 
				<i class="fa fa-bar-chart" style="margin-right:10px;"></i>Performance Snapshot <small><?php echo $chapter->chapter; ?></small>
				<?php if($topdf == null): ?>
					<span class="pull-right hidden-sm hidden-xs" style="font-size:100%">
						<a href="?topdf=1" class="btn btn-primary btn-xs"><i class="fa fa-print" style="margin-right:5px;"></i>Print Page</a>
					</span>
				<?php endif; ?>
			</h2>
		</div>
			
		<div class="row" style="margin:20px 20px 20px;">
			<div class="col-md-4">
				<span>RAW SCORE <span class="label label-info" style="font-size:20px; margin-left:5px;" id="raw_overall">0</span></span>
			</div>
			<br class="hidden-lg hidden-md" />
			<div class="col-md-4">
				<span>RATING <span class="label label-success" style="font-size:20px; margin-left:5px;" id="rating_overall">0%</span></span>
			</div>
			<br class="hidden-lg hidden-md" />
			<div class="col-md-4">
				<span style="font-size: 14px;">
					<span class="hidden-sm hidden-xs"><strong>JCIPEA Seal of Efficiency</strong></span>
					<span class="hidden-md hidden-lg"><strong>SEAL</strong></span>  
					<span class="label label-danger" style="font-size:25px;" id="seal">N/A</span>
				</span>
			</div>
			<!--<div class="col-md-3 col-xs-6">
				<span class="visible-xs visible-sm" style="margin-top: 18px;"></span>
				<span>Qualified for JCIPEA Gavel? <span class="label label-danger" style="font-size:17px; margin-left:5px;" id="pea_gavel_ans">No</span></span>
			</div>
			<div class="col-md-4 col-xs-6">
				<span class="visible-xs visible-sm" style="margin-top: 18px;"></span>
				<span>Number of Categories w/ 100% Efficiency <span class="label label-warning" style="font-size:17px; margin-left:5px;" id="efficient_count">0</span></span>
			</div> -->
		</div>
		
		<div class="box">
			<div class="row" style="padding:20px;">
				<div class="table-responsive">
					<table class="table table-hover">
					  	<thead>
						  	<tr>
						  		<th width="5%">Annex</th>
							  	<th width="55%">SubCategories</th>
							  	<th width="10%">Raw Score</th>
							  	<th width="10%">Max Score</th>
							  	<th width="10%">Weight</th>
							  	<th width="10%">Rating</th>
						  	</tr>
					  	</thead>
					  	<tbody>
					  		<?php foreach($pea_categories as $cat): 
					  			$x = 0;
					  		?>
					  			<tr style="font-size:20px;" class="info categories">
					  				<td id="cat_id"><strong><?php echo $cat->cat_id; ?></strong></td>
								  	<td>
								  		<center><strong><?php echo $cat->category; ?></strong></center>
								  	</td>
								  	<td id="raw_total" class="raw_total"></td>
									<td id="max_total" style="font-size:18px;"></td>
									<td id="weight_total"></td>
									<td <?php if($cat->cat_id != 6) echo 'id="rating_total" class="rating_total"'; ?>></td>
								</tr>
					  		<?php 
					  			foreach($pea_subcat as $subcat):
					  				if($subcat->cat_id == $cat->cat_id):
						  	?>
										<tr class="subcat <?php echo $cat->cat_id; ?>">
											<td>
												<strong><?php echo $cat->cat_id.$cat_code[$x]; $x++; ?></strong>
											</td>
										  	<td id="subcat">
										  		<a href="<?php echo Yii::app()->baseUrl;?>/index.php/account/listdescscoring?sub_id=<?php echo $subcat->sub_id; ?>">
										  			<i><?php echo $subcat->SubCat; ?> </i>
										  		</a>
										  		<a href="<?php echo Yii::app()->baseUrl;?>/index.php/account/listdescscoring?sub_id=<?php echo $subcat->sub_id; ?>" class="glass">
										  			<i class="fa fa-search"></i>
										  		</a>
										  	</td>
										  	<td id="raw">
										  		<span id="raw_w_green" style="display:none;"><?php echo PeaDescriptions::model()->computeRaw($subcat->sub_id, $chapter->id); ?></span>
										  		<span id="raw_wo_green"><?php echo PeaDescriptions::model()->computeRawWoGreen($subcat->sub_id, $chapter->id); ?></span> 
										  	</td>
										  	<td id="max"><i><?php echo PeaDescriptions::model()->computeMax($subcat->sub_id); ?></i></td>
										  	<td <?php if($cat->cat_id != 6) echo 'id="weight"'; ?>>0</td>
										  	<td <?php if($cat->cat_id != 6) echo 'id="rating" class="rating"'; ?>>0</td>
										</tr>
									<?php endif; ?>
								<?php endforeach; ?>		
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>

			<span class="pull-right" style="margin:20px 10px;">
				<strong>Date: </strong><?php echo date('M d, Y'); ?>
			</span>
		</div>
	</section><!-- /.content -->
</div>