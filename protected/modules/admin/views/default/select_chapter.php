<script>
$(document).ready(function(){
	//LIST REGIONS
    $("#area_no").change(function(){
        if (typeof location.origin === 'undefined')
          location.origin = location.protocol + '//' + location.host;

        $.post(location.origin+"/mod02/index.php/account/listRegions?area_no="+$(this).val(), function(data) {
        		$("select#region").html("<option value=''>Select Region.. </option>" + data);
        		$("select#chapter").html("<option value=''> -- </option>");
        });
    });

    //LIST CHAPTERS
    $("#region").change(function(){
        if (typeof location.origin === 'undefined')
          location.origin = location.protocol + '//' + location.host;

        $.post(location.origin+"/mod02/index.php/account/listChapters?region="+$(this).val(), function(data) {
        		$("select#chapter").html("<option value=''>Select Chapter.. </option>" + data);
        });
    });
 });
</script>

<style>
	hr{
		margin-top: 10px;
	}
</style>
<!-- Main content -->
<section class="content">
	<form method="POST">
		<div class="row" style="padding:30px;">
			<div class="col-md-3"></div>

			<div class="col-md-6">
				<div class="well" style="padding:20px 50px;">
					<div class="row">
			    		<h4 style="margin-top:0;text-align:center;">Select Chapter</h4>
			    		<hr />
			    	</div>


				    <div class="row">

				    	<div class="row">
					    	<div class="col-md-2"> Area </div>
					    	<div class="col-md-10">
					    		<select class="form-control" id="area_no" required>
					    			<option value="">Select Area..</option>
					    			<?php $areas = AreaRegion::model()->findAll(array('select'=>'area_no', 'distinct'=>true)); 

					    				foreach($areas as $area) {
					    					echo "<option value='".$area->area_no."'>".$area->area_no."</option>";
					    				}

					    			?>
					    		</select>
					    	</div>
					    </div>

				    	<div class="row" style="margin-top:20px;">
					    	<div class="col-md-2"> Region </div>
					    	<div class="col-md-10">
					    		<select class="form-control" id="region" required>
					    			<option value=""> -- </option>
					    		</select>
					    	</div>
					    </div>

					    <div class="row" style="margin-top:20px;">
					    	<div class="col-md-2"> Chapter </div>
					    	<div class="col-md-10">
					    		<select class="form-control" id="chapter" name="chapter" required>
					    			<option value=""> -- </option>
					    		</select>
					    	</div>
					    </div>


				    	<div class="row" style="margin-top:20px;">
				    		<div class="col-xs-12">
				    			<input type="submit" class="btn btn-primary pull-right" name="submit" value="VIEW SCORE">
				    		</div>
						</div>
				    </div>

		    	</div>
			</div>

			<div class="col-md-3"></div>
		</div>
	</form>	
</section><!-- /.content -->