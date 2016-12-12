<!-- Content Header (Page header) -->
<!-- <section class="content-header">
  <h1>
    Create/Submit Report
    <small>Reports</small>
  </h1>
</section>-->
<style>
	hr{
		margin-top: 10px;
	}

	label{
		font-size:14px;
	}

	input[type="text"]
	{
	    font-size:14px;
	}

	option
	{
	    font-size:14px;
	}

	.progress{
		display:none;
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

<script>

$(function () {
	var rep_id;

	$.ajax({
	   url: location.origin+"/mod03/index.php/account/checkActivePres",
	   success: function(response) {
	   		is_active_pres = response;
	   },
	   complete: function() {
	   		if(is_active_pres == 0)
	   		{
	   			alert('Report Filing Form disabled! There\'s no Active President registered in your chapter. Please notify your Chapter President about this issue.');
	   			window.location.href = location.origin+"/mod03/index.php/account/";
	   		}
	   },
	});

  	$('[data-toggle="popover"]').popover({
  	 container: 'body'
  	});

	$("#pea-refcode").change(function(){
		rep_id  = $(this).val();

		$.ajax({
		   url: location.origin+"/mod03/index.php/account/getDescDetails",
		   method: "POST",
		   data: { rep_id: rep_id } ,
		   success: function(response) {
		   		description = jQuery.parseJSON(response);
		   },
		   complete: function() {
		   		$("#rep_id").html(description.rep_id);
		   		$("#rep_description").html(description.description);
		   		$("#rep_details").html(description.details);
		   		$("#rep_goal").fadeIn();
		   		$("#rep_goal_print").html(description.details);

		   		if(description.qty === "T") {
		   			$("#rep_criteria").fadeOut();
		   			$("#rep_qty").fadeIn();
		   		} else {
		   			if(description.criteria_point != 0) {
		   				$("#rep_qty").fadeOut();
		   				$("#rep_criteria").fadeIn();
		   				$("#rep_criteria_print").html(description.remarks);
		   			} else {
		   				$("#rep_qty").fadeOut();
		   				$("#rep_criteria").fadeOut();
		   			}
		   		}

		   		$("#step2Header").fadeIn();
	   			$("#step2Body").fadeIn();
		   },
		   error: function() {
		   		alert("ERROR in loading the scoring section. Page will now reload.");
		   		location.reload();
		   }
		});
	});

	$(document).on("click","#btn-upload",function(){
  		 uploadFile(); 
  		 return false;
	});

	$(document).on("click","#btn-draft",function(){
  		 uploadDraft(); 
  		 return false;
	});

	$(document).on("click","#btn-disabled", function(){
	  	 	return false;
	});
})

function uploadDraft(){
	filled_fields = 0;
	
	if($('#pea-refcode').val() == "") {
		alert("Please select a Reference Code first.")
        return false;  
	}

	if($('#date_completed').val() == "") {
		alert("Date Project Completed is required.")
		$('#date_completed').focus();
        return false;  
	}

	$('.to-draft').each(function( index ) {
		if ($(this).val() !== "") {
			filled_fields++;
	    }
	});
    
    if (filled_fields < 5){
    	alert("Please fill out at least 5 fields before saving to draft.");
        return false;   
    }

    else if(filled_fields >= 5)
    {	
    	disableButtons();

	  	var fd = new FormData();
	  	var other_data = $('form').serializeArray();
	  	fd.append('file-report', $('input[type=file]')[0].files[0]);
	  	fd.append('attendance-sheet', $('input[type=file]')[1].files[0]); 
	  	fd.append('to_draft', true); 
	  	$.each(other_data,function(key,input){
	      fd.append(input.name,input.value);
	  	});

	  	ajaxUpload(fd);
	}
}

function uploadFile(){
	errors = 0;
	
	$('.report').each(function( index ) {
		if ($(this).val() === "") {
		  	$(this).next("span").html( "<b>Required!</b>" ).show().delay(6000).fadeOut( 6000 );
	      	errors++;
	    }
	});
    
    if (errors>0){
    	alert("Please fill out all fields.")
        return false;   
    }
    else if(errors == 0)
    {	
    	disableButtons();

	  	var fd = new FormData();
	  	var other_data = $('form').serializeArray();
	  	fd.append('file-report', $('input[type=file]')[0].files[0]);
	  	fd.append('attendance-sheet', $('input[type=file]')[1].files[0]); 
	  	$.each(other_data,function(key,input){
	      fd.append(input.name,input.value);
	  	});

	  	ajaxUpload(fd);
	}
}

function ajaxUpload(formData) {
	if (typeof location.origin === 'undefined')
    	location.origin = location.protocol + '//' + location.host;

  	$('.progress').show();
  	$("#progress-bar").css('width', 1+'%');

	var ajax = new XMLHttpRequest();
  	ajax.upload.addEventListener("progress", progressHandler, false);
  	ajax.addEventListener("load", completeHandler, false);
  	ajax.addEventListener("error", errorHandler, false);
  	ajax.addEventListener("abort", abortHandler, false);
  	ajax.open("POST", location.origin+"/mod03/index.php/account/submitreport");
  	ajax.send(formData);
} 

function progressHandler(event){
  var percent = (event.loaded / event.total) * 100;
  $("#progress-bar").css('width', Math.round(percent)+'%');
  $("#progress-bar").html(Math.round(percent) + "% uploaded... please wait");
}

function completeHandler(event){
  response = jQuery.parseJSON(event.target.responseText);
  $("#progress-bar").html(response.message);

  if(response.status) {
  	alert(response.message);
  	window.location.href = location.origin+response.redirect_url;
  } else {
  	alert(response.message);
  	location.reload();
  }	
}

function errorHandler(event){
  $("#progress-bar").html("UPLOAD FAILED!");
  alert("Upload Failed!");
}

function abortHandler(event){
  $("#progress-bar").html("UPLOAD ABORTED!");
  alert("Upload Aborted");
}

function disableButtons() {
	$("#btn-upload").attr("disabled", true);
	$("#btn-upload").attr("id", "btn-disabled");
	$("#btn-draft").attr("disabled", true);
	$("#btn-draft").attr("id", "btn-disabled");
}
</script>

<section class="content">
	<form method="post" enctype="multipart/form-data" id="upload-report">
	<div class="row" style="padding:20px;">

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

		<div class="col-md-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h2 style="text-align:center;margin-top:0px;margin-bottom:0px;">Project Completion Report</h2>
					<h3 style="text-align:center;margin-top:0px;"><small>All fields are required</small></h3>
				</div>

				<div class="panel-body" style="padding:15px 50px;">
					<h3 style="margin-left:20px; margin-bottom:20px;" id="step1Header">STEP 1 <small>Enter Project Report Details & Upload Image Report</small></h3>
					<div class="well" style="padding:35px;" id="step1Body">
						<div class="row">
							<div class="col-xs-12">
								<div class="col-md-2">
									<label>Local Organization</label>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<input type="text" name="chapter" class="report form-control" disabled value="<?php echo "JCI ".$chapter->chapter; ?>" />
										<input type="hidden" name="chapter_id" value="<?php echo $chapter->id; ?>" />
									</div>
								</div>
							</div>
						</div>
						
						<hr>
						
						<div class="row">
							<div class="col-md-6">
								<div class="col-md-4">
									<label>L.O. President</label>
								</div>
								<div class="col-md-8">
									<div class="form-group">
										<input type="text" name="president" class="report form-control" disabled 
										value="<?php echo ucwords(strtolower($president->firstname.' '.$president->lastname)); ?>" 
										/>
										<input type="hidden" name="president_id" value="<?php echo $president->account_id; ?>" />
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="col-md-4">
									<label>Project Chairman</label>
								</div>
								<div class="col-md-8">
									<div class="form-group">
										<select class="report form-control" name="chairman_id" id="chairman_id" required>
											<option value=''>Please Select..</option>
											<?php 
												foreach($members as $member)
													echo "<option value = '".$member->account_id."'>".$member->firstname." ".$member->middlename." ".$member->lastname."</option>";
											?>	
										</select>
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>
						</div>
						
						<hr>

						<div class="row">
							<div class="col-xs-12">
								<div class="col-md-2">
									<label>Project Title</label>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<input type="text" name="project_title" id="project_title" class="to-draft report form-control" required />
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>
						</div>
						
						<hr>

						<div class="row">
							<div class="col-md-4">
								<div class="col-xs-12">
									<label>Key Result Area</label>
									<div class="form-group">
										<select class="report form-control" name="category" id="pea-category" required>
											<option value=''>Please Select..</option>
											<?php 
												$categories = PeaCategory::model()->findAll();

												foreach($categories as $category)
													echo "<option value = '".$category->cat_id."'>".$category->category."</option>";
											?>	
										</select>
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="col-xs-12">
									<label>Category</label>
									<div class="form-group">
										<select class="report form-control" name="subcat" id="pea-subcat" required>
											<option value=''>Please Select..</option>
										</select>
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="col-xs-12">
									<label>Reference Code</label>
										<select class="to-draft report form-control" name="refcode" id="pea-refcode" required>
											<option value=''>Please Select..</option>
										</select>
										<span class="label label-danger"></span>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-xs-12">
								<div class="col-md-2">
									<label>Brief Description
										(<a data-toggle="collapse" data-target="#instructionsDesc" aria-expanded="false" aria-controls="instructionsDesc">?</a>)
									</label>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<div class="collapse" id="instructionsDesc">
										  <div class="well">
										    <strong>Brief Description of the Project (Active Citizen Framework at work!) </strong> <br/> <br/>
										    How can this project unite different sectors of the community? How can this address relevant community needs and create sustainable impact? <br /><br/>
										    How can this projet unite various sectors of the community? How can this address relevant community needs and create sustainable impact? How can this create positive change?
										  </div>
										</div>
										<textarea name="brief_description" id="brief_description" class="to-draft report form-control" rows="5" style="resize:none" required></textarea>
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-xs-12">
								<div class="col-md-2">
									<label>Objectives</label>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<textarea name="objectives" id="objectives" class="to-draft report form-control" rows="3" style="resize:none" required></textarea>
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-xs-12">
								<div class="col-md-2">
									<label>Action Taken</label>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<textarea name="action_taken" id="action_taken" class="to-draft report form-control" rows="3" style="resize:none" required></textarea>
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-xs-12">
								<div class="col-md-2">
									<label>Results Achieved</label>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<textarea name="results_achieved" id="results_achieved" class="to-draft report form-control" rows="3" style="resize:none" required></textarea>
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12">
								<div class="col-md-2">
									<label>Program Partners</label>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<input type="text" name="program_partners" id="program_partners" class="to-draft report form-control" required />
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-xs-12">
								<div class="col-md-2">
									<label>Recommendations</label>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<textarea name="recommendations" id="recommendations" class="to-draft report form-control" rows="3" style="resize:none" required></textarea>
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-md-4">
								<div class="col-xs-12">
									<label>Date Project Completed</label>
									<div class="form-group">
										<?php
											$this->widget('zii.widgets.jui.CJuiDatePicker', array(
												'options'=>array(
													'showAnim'=>'slideDown',
													'yearRange'=>'-05:-00',
													'changeMonth' => true,
													'changeYear' => true,
													'dateFormat' => 'yy-mm-dd'
													),
												'htmlOptions' => array(
													'name'=>'date_completed',
													'id'=>'date_completed',
													'size' => 20,         // textField size
													'class' => 'to-draft report form-control',
												),	
											));
										?>
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="col-xs-12">
									<label>No. of JCI Members Involved</label>
										<input type="text" class="to-draft quantity report form-control" name="jci_members" id="jci_members" />
										<span class="label label-danger"></span>
								</div>
							</div>

							<div class="col-md-4">
								<div class="col-xs-12">
									<label>No. of Non-JCI Sectors Involved</label>
										<input type="text" class="to-draft quantity report form-control" name="non_jci" id="non_jci" />
										<span class="label label-danger"></span>
								</div>
							</div>
						</div>

						<hr>

						<hr>

						<div class="row">
							<div class="col-md-3">
								<div class="col-xs-12">
									<label>Projected Income</label>
									<div class="form-group">
										<input type="text" class="to-draft quantity report form-control" name="proj_income" id="proj_income" placeholder="9999.99" />
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="col-xs-12">
									<label>Projected Expenditures</label>
									<div class="form-group">
										<input type="text" class="to-draft quantity report form-control" name="proj_exp" id="proj_exp" placeholder="9999.99" />
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="col-xs-12">
									<label>Actual Income</label>
										<input type="text" class="to-draft quantity report form-control" name="actual_income" id="actual_income" placeholder="9999.99" />
										<span class="label label-danger"></span>
								</div>
							</div>

							<div class="col-md-3">
								<div class="col-xs-12">
									<label>Actual Expenditures</label>
										<input type="text" class="to-draft quantity report form-control" name="actual_exp" id="actual_exp" placeholder="9999.99" />
										<span class="label label-danger"></span>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-md-6">
								<div class="col-md-3">
									<label>Project Picture 
										(<a data-placement="right" data-toggle="popover" 
										data-content="Collage or combine all the photos into one file. File upload only accepts .jpeg,.png and .bmp file format. Maximum file upload size will be 2MB.">?</a>)
									</label>
								</div>
								<div class="col-md-9">
									<div class="form-group">
										<input type="file" name="file-report" id="file-report" class="to-draft report btn btn-default file-upload" 
										accept='image/*' style="margin-bottom:5px;" required />
										<span class="label label-danger"></span>
										<small>Maximum size is 2MB.</small>
									</div>
								</div>

								<p style="margin-left:20px; font-size:11px;">
									<strong> Important: </strong>Please upload your Project Photo Collage with the following: <br/>
										<em>1. Actual Project Banner in the event itself (with members and/or participants)</em><br/>
										<em>2. Action Photos (minimum of 4 photos)</em>
								</p>
							</div>
							<div class="col-md-6">
								<div class="col-md-3">
									<label>Attendance Sheet</label>
								</div>
								<div class="col-md-9">
									<div class="form-group"> 
										<input type="file" name="attendance-sheet" id="attendance-sheet" class="to-draft btn btn-default file-upload" 
										accept='image/*' style="margin-bottom:5px;" />
										<small>Maximum size is 2MB.</small>
									</div>
								</div>
							</div>
						</div>
					</div>

					<br />
					<hr />

					<h3 style="margin-left:20px; margin-bottom:0px; display:none;" id="step2Header">STEP 2 <small>Answer the following questions for scoring</small></h3>

						<div class="row" style="padding:30px;margin-top:0px; display:none;" id="step2Body">
							<div class="panel panel-info">
								<div class="panel-heading">
									<h3 style="margin-top:0;">
										<label class="label label-danger" id="rep_id" style="margin-right:10px;">A1</label>  
										<span id="rep_description">Lorem Ipsum Dolor</span>
									</h3>
								</div>

								<div class="panel-body" style="padding:20px">
									<hr/>

									<div class="row" style="margin-left:15px; margin-bottom:20px; display:none;" id="rep_goal">
										<h4 style="margin-bottom:20px;"> 
											<span class="fa fa-check-square-o" style="margin-right:10px;"> </span>
											<b><i>GOAL</i></b> : <span id="rep_goal_print">Lorem Ipsum Dolor Lorem Ipsum Dolor</span>
										</h4>

										<div class="well" style="margin-right:50px;margin-left:20px;">
											<h4 style="margin-top:0px;">Was the goal achieved?</h4> 
						    				<br/>
						    				<div class="btn-group" data-toggle="buttons">
											  <label class="btn btn-info btn-lg">
											    <input type="radio" name="goal" value="Y" autocomplete="off" required> Yes
											  </label>
											  <label class="btn btn-info btn-lg">
											    <input type="radio" name="goal"  value="N" autocomplete="off" required> No
											  </label>
											</div>
						    			</div>
						    		</div>

						    		<hr/>

						    		<div class="row" style="margin-left:15px; margin-bottom:20px; display:none;" id="rep_criteria">
										<h4 style="margin-bottom:20px;">
											<span class="fa fa-check-square-o" style="margin-right:10px;"> </span> 
											<b><i>CRITERIA</i></b> : <span id="rep_criteria_print">Lorem Ipsum Dolor Lorem Ipsum Dolor</span>
										</h4>

										<div class="well" style="margin-right:50px;margin-left:20px;">
											<h4 style="margin-top:0px;">Was the criteria met?</h4> 
											
											<br/>
						    				<div class="btn-group" data-toggle="buttons">
											  <label class="btn btn-info btn-lg">
											    <input type="radio" name="criteria" value="Y" autocomplete="off" required> Yes
											  </label>
											  <label class="btn btn-info btn-lg">
											    <input type="radio" name="criteria"  value="N" autocomplete="off" required> No
											  </label>
											</div>
						    			</div>
						    		</div>

						    		<hr/>

						    		<div class="row" style="margin-left:15px; margin-bottom:20px;display:none;" id="rep_qty">
										<h4 style="margin-bottom:20px;">
											<span class="fa fa-calculator" style="margin-right:10px;"> </span> 
											<b><i>QUANTITY</i></b>
										</h4>
										
										<div class="row">
											<div class="form-group col-md-6">
						    					<input type="text" class="quantity form-control" id="quantity" name="quantity" placeholder="Enter Quantity / Amount" required />
						    				</div>
						    			</div>
						    		</div>

						    	</div>
					    	</div>
						</div>

						<div class="progress" style="margin-bottom:0px; margin-top:20px;">
						  <div class="progress-bar progress-bar-striped active" id="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
						  </div>
						</div>
				</div>

				<div class="panel-footer">
					<div class="row">
						<div class="pull-right">
							<button type="submit" class="btn btn-lg btn-warning" name="submit" style="margin-right:20px" <?php if($president == null) echo "disabled id='btn-disabled'"; else echo "id='btn-draft'"; ?> > 
								 <span class="fa fa-folder-o" style="margin-right:10px"></span>Save to Drafts
							</button>
							<button type="submit" class="btn btn-lg btn-primary" name="submit" style="margin-right:20px" <?php if($president == null) echo "disabled id='btn-disabled'"; else echo "id='btn-upload'"; ?> > 
								 <span class="fa fa-upload" style="margin-right:10px"></span>S U B M I T
							</button>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div>
	</form>
</section><!-- /.content -->