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

	getScoringDetails($('#orig-refcode').val(), 1);

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
		getScoringDetails(rep_id);
	});

	$("#edit_proj_photo").click(function(){
		$("#upload_proj_photo").fadeToggle();
	});

	$("#edit_att_sheet").click(function(){
		$("#upload_att_sheet").fadeToggle();
	});

	$("#delete_att_sheet").click(function(){
		$("#upload_att_sheet").fadeOut();
	});

	$(document).on("click","#btn-update",function(){
  		 updateFile(); 
  		 return false;
	});

	$(document).on("click","#btn-draft",function(){
  		 uploadDraft(); 
  		 return false;
	});
})

function getScoringDetails(rep_id, loadanswer) {
	$.ajax({
		   url: location.origin+"/mod03/index.php/account/getDescDetails",
		   method: "POST",
		   data: { rep_id: rep_id } ,
		   success: function(response) {
		   		description = jQuery.parseJSON(response);
		   },
		   complete: function() {
		   		console.log(description);
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
		   				$("#rep_criteria").fadeOut();
		   			}
		   		}

		   		$("#step2Header").fadeIn();
	   			$("#step2Body").fadeIn();
	   			$('#goal-yes').removeClass('active');
	   			$('#goal-no').removeClass('active');
	   			$('#criteria-yes').removeClass('active');
	   			$('#criteria-no').removeClass('active');
	   			$('#quantity').val('');

	   			if(loadanswer != null) {
	   				getScoringAnswers($('#report_id').val());
	   			}
		   },
		   error: function() {
		   		alert("ERROR in loading the scoring section. Page will now reload.");
		   		location.reload();
		   }
		});
}

function getScoringAnswers(report_id) {
	$.ajax({
		   url: location.origin+"/mod03/index.php/account/getScoringAnswers",
		   method: "POST",
		   data: { report_id: report_id } ,
		   success: function(response) {
		   		reports = jQuery.parseJSON(response);
		   },
		   complete: function() {
		   		if(reports.goal_status === 'Y')
		   			 $('#goal-yes').addClass('active');
		   		else
		   			$('#goal-no').addClass('active');

		   		if(reports.criteria_status === 'Y')
		   			$('#criteria-yes').addClass('active');
		   		else
		   			$('#criteria-no').addClass('active');

		   		$('#quantity').val(reports.qty);
		   		$('#orig_quantity').val(reports.qty);
		   		$('#orig_goal').val(reports.goal_status);
		   		$('#orig_criteria').val(reports.criteria_status);
		   },
		   error: function() {
		   		alert("ERROR in loading the scoring answers. Page will now reload.");
		   		location.reload();
		   }
		});
}

function uploadDraft(){
	//filled_fields = 0;
	
	if($('#chairman_id').val() == "") {
		alert("Please select a Project Chairman first.")
        return false;  
	}

	if($('#project_title').val() == "") {
		alert("Please provide a Project Title first.")
        return false;  
	}
	
	if($('#pea-refcode').val() == "") {
		alert("Please select a Reference Code first.")
        return false;  
	}

	// if($('#date_completed').val() == "") {
	// 	alert("Date Project Completed is required.")
	// 	$('#date_completed').focus();
 //        return false;  
	// }

	// $('.to-draft').each(function( index ) {
	// 	if ($(this).val() !== "") {
	// 		filled_fields++;
	//     }
	// });
    
 //    if (filled_fields < 5){
 //    	alert("Please fill out at least 5 fields before saving to draft.");
 //        return false;   
 //    }

    // else if(filled_fields >= 5)
    // {	
    	disableButtons();

	  	var fd = new FormData();
	  	var other_data = $('form').serializeArray();
	  	fd.append('file-report', $('input[type=file]')[0].files[0]);
	  	fd.append('attendance-sheet', $('input#attendance-sheet')[0].files[0]); 
	  	fd.append('to_draft', true); 
	  	$.each(other_data,function(key,input){
	      fd.append(input.name,input.value);
	  	});

	  	ajaxUpload(fd);
	// }
}

function updateFile() {
	errors = 0;
	var rejected = $('#rejected').val();
	
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
	  	fd.append('attendance-sheet', $('input#attendance-sheet')[0].files[0]); 
	  	$.each(other_data,function(key,input){
	      fd.append(input.name,input.value);
	  	});

	  	ajaxUpload(fd);
	}
}

function ajaxUpload(formData) {
	var report_id = $('#report_id').val();

	if (typeof location.origin === 'undefined')
    	location.origin = location.protocol + '//' + location.host;

  	$('.progress').show();
  	$("#progress-bar").css('width', 1+'%');

	var ajax = new XMLHttpRequest();
  	ajax.upload.addEventListener("progress", progressHandler, false);
  	ajax.addEventListener("load", completeHandler, false);
  	ajax.addEventListener("error", errorHandler, false);
  	ajax.addEventListener("abort", abortHandler, false);
  	ajax.open("POST", location.origin+"/mod03/index.php/account/editreport?id="+report_id);
  	ajax.send(formData);
} 

function progressHandler(event){
  var percent = (event.loaded / event.total) * 100;
  $("#progress-bar").css('width', Math.round(percent)+'%');
  $("#progress-bar").html(Math.round(percent) + "% updating... please wait");
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
  $("#progress-bar").html("UPDATE FAILED!");
  alert("Update Failed!");
}

function abortHandler(event){
  $("#progress-bar").html("UPDATE ABORTED!");
  alert("Update Aborted");
}

function disableButtons() {
	$("#btn-update").attr("disabled", true);
	$("#btn-update").attr("id", "btn-disabled");
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
					<h2 style="margin-top:0px;margin-bottom:10px;"><i class="fa fa-pencil-square-o" style="margin-right:10px;"></i>Edit Project Report</h2>
				</div>

				<div class="panel-body" style="padding:15px 50px;">
					<h3 style="margin-left:20px; margin-bottom:20px;" id="step1Header"><i class="fa fa-minus-square" style="margin-right:10px;"></i>Project Report Details</h3>
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
													if($member->account_id == $report->chairman_id)
														echo "<option value = '".$member->account_id."' selected>".$member->firstname." ".$member->middlename." ".$member->lastname."</option>";
													else
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
										<input type="text" name="project_title" id="project_title" class="report form-control to-draft" value="<?php echo $report->project_title; ?>" required />
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
											<?php $subcat = PeaSubcat::model()->find('sub_id = '.$report->description->sub_id); ?>
											<option value='<?php echo $subcat->category->cat_id; ?>' disabled selected><?php echo $subcat->category->category; ?></option>
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
											<option value='<?php echo $report->description->sub_id; ?>' disabled selected><?php echo $subcat->SubCat; ?></option> 
										</select>
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="col-xs-12">
									<label>Reference Code</label> 
										<select class="report form-control to-draft" name="refcode" id="pea-refcode" required>
											<option value='<?php echo $report->description->rep_id; ?>' selected><?php echo $report->description->rep_id; ?></option> 
										</select>
										<span class="label label-danger"></span>
										<input type="hidden" name="orig_refcode" id="orig-refcode" value="<?php echo $report->rep_id; ?>" />
										<input type="hidden" name="report_id" id="report_id" value="<?php echo $report->id; ?>" />
										<input type="hidden" name="rejected" id="rejected" value="<?php echo $rejected; ?>" />
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
										<textarea name="brief_description" id="brief_description" class="report form-control to-draft" rows="5" style="resize:none" required><?php echo $report->brief_description; ?></textarea>
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
										<textarea name="objectives" id="objectives" class="report form-control to-draft" rows="3" style="resize:none" required><?php echo $report->objectives; ?></textarea>
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
										<textarea name="action_taken" id="action_taken" class="report form-control to-draft" rows="3" style="resize:none" required><?php echo $report->action_taken; ?></textarea>
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
										<textarea name="results_achieved" id="results_achieved" class="report form-control to-draft" rows="3" style="resize:none" required><?php echo $report->results_achieved; ?></textarea>
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
										<input type="text" name="program_partners" id="program_partners" class="report form-control to-draft"  value="<?php echo $report->program_partners; ?>" required />
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
										<textarea name="recommendations" id="recommendations" class="report form-control to-draft" rows="3" style="resize:none" required><?php echo $report->recommendation; ?></textarea>
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
												'value'=> $report->data_completed,
												'options'=>array(
													'showAnim'=>'slideDown',
													'yearRange'=>'-05:-00',
													'changeMonth' => true,
													'changeYear' => true,
													'dateFormat' => 'yy-mm-dd',
													),
												'htmlOptions' => array(
													'name'=>'date_completed',
													'id'=>'date_completed',
													'size' => 20,         // textField size
													'class' => 'report form-control to-draft',
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
										<input type="text" class="quantity report form-control to-draft" name="jci_members" id="jci_members" value="<?php echo $report->members_involved; ?>"/>
										<span class="label label-danger"></span>
								</div>
							</div>

							<div class="col-md-4">
								<div class="col-xs-12">
									<label>No. of Non-JCI Sectors Involved</label>
										<input type="text" class="quantity report form-control to-draft" name="non_jci" id="non_jci" value="<?php echo $report->sectors_involved; ?>" />
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
										<input type="text" class="quantity report form-control to-draft" name="proj_income" id="proj_income" placeholder="9999.99" value="<?php echo $report->projected_income; ?>" />
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="col-xs-12">
									<label>Projected Expenditures</label>
									<div class="form-group">
										<input type="text" class="quantity report form-control to-draft" name="proj_exp" id="proj_exp" placeholder="9999.99" value="<?php echo $report->projected_expenditures; ?>" />
										<span class="label label-danger"></span>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="col-xs-12">
									<label>Actual Income</label>
										<input type="text" class="quantity report form-control to-draft" name="actual_income" id="actual_income" placeholder="9999.99" value="<?php echo $report->actual_income; ?>" />
										<span class="label label-danger"></span>
								</div>
							</div>

							<div class="col-md-3">
								<div class="col-xs-12">
									<label>Actual Expenditures</label>
										<input type="text" class="quantity report form-control to-draft" name="actual_exp" id="actual_exp" placeholder="9999.99" value="<?php echo $report->actual_expenditures; ?>" />
										<span class="label label-danger"></span>
								</div>
							</div>
						</div>

						<hr>
					</div>

					<br />
					<hr />

					<h3 style="margin-left:20px; margin-bottom:20px;" id="step1Header"><i class="fa fa-minus-square" style="margin-right:10px;"></i>Project Photo and Attendance Sheet</h3>
					<div class="well">
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-3"></div>
									<div class="col-md-6"><h4 style="margin-top:0px;">Project Picture</h4></div>
									<div class="col-md-3"></div>
								</div>
								<div class="row" style="margin-bottom:10px;">
									<div class="col-md-3">
										<label>Original File</label>
									</div>
									<div class="col-md-9">
										<?php if($report->fileupload_id != 0): ?>
											<a href="<?php echo Yii::app()->baseUrl; ?>/index.php/account/viewprojphoto?id=<?php echo $report->id; ?>" target="_blank"><i class="fa fa-search" style="margin-right:10px"></i>View Project Photo</a>
											<br style="margin-top:5px;" />
											<input type="checkbox" id="edit_proj_photo" style="margin-right:8px;" /> Change Photo
										<?php else: ?>
											<i>NO FILE UPLOADED. <br /> <small>You must upload a project photo before re-submitting.</small></i>
											<br style="margin-top:5px;"/>
											<input type="file" name="file-report" id="file-report" class="btn btn-default file-upload report to-draft" 
											accept='image/*' style="margin-bottom:5px;" />
											<span class="label label-danger"></span>
											<small>Maximum size is 2MB.</small>
										<?php endif; ?>
									</div>
								</div>
								<div class="row" style="display:none;" id="upload_proj_photo">
									<div class="col-md-3">
										<label>New Project Picture 
											(<a data-placement="right" data-toggle="popover" 
											data-content="Collage or combine all the photos into one file. File upload only accepts .jpeg,.png and .bmp file format. Maximum file upload size will be 2MB.">?</a>)
										</label>
									</div>
									<div class="col-md-9">
										<div class="form-group">
											<input type="file" name="file-report" id="file-report" class="btn btn-default file-upload to-draft" 
											accept='image/*' style="margin-bottom:5px;" />
											<span class="label label-danger"></span>
											<small>Maximum size is 2MB.</small>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-3"></div>
									<div class="col-md-6"><h4 style="margin-top:0px;">Attendance Sheet</h4></div>
									<div class="col-md-3"></div>
								</div>
								<div class="row" style="margin-bottom:10px;">
									<div class="col-md-3">
										<label>Original File</label>
									</div>
									<div class="col-md-9">
										<?php if($report->attendance_sheet != 0): ?>
											<a href="<?php echo Yii::app()->baseUrl; ?>/index.php/account/viewattsheet?id=<?php echo $report->id; ?>" target="_blank"><i class="fa fa-search" style="margin-right:10px"></i>View Attendance Sheet</a>
											<br style="margin-top:5px;" />
											<input type="checkbox" name="edit-delete-att" value="E" id="edit_att_sheet" style="margin-right:8px;" /> Change Photo
											<input type="checkbox" name="edit-delete-att" value="D" id="delete_att_sheet" style="margin-left:15px;margin-right:8px;" /> Delete
										<?php else: ?>
											<i>NO FILE UPLOADED</i>
											<br style="margin-top:5px;"/>
											<input type="checkbox" id="edit_att_sheet" style="margin-right:5px;" /> Upload Attendance Sheet
										<?php endif; ?>
									</div>
								</div>
								<div class="row" style="display:none;" id="upload_att_sheet">
									<div class="col-md-3">
										<label>New Att. Sheet</label>
									</div>
									<div class="col-md-9">
										<div class="form-group"> 
											<input type="file" name="attendance-sheet" id="attendance-sheet" class="btn btn-default file-upload to-draft" 
											accept='image/*' style="margin-bottom:5px;" />
											<small>Maximum size is 2MB.</small>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<p style="margin-left:20px">
						<strong> Important: </strong>Please upload your Project Photo Collage with the following: <br/>
							<em>1. Actual Project Banner in the event itself (with members and/or participants)</em><br/>
							<em>2. Action Photos (minimum of 4 photos)</em>
					</p>

					<br />
					<hr />

					<h3 style="margin-left:20px; margin-bottom:20px;" id="step1Header"><i class="fa fa-minus-square" style="margin-right:10px;"></i>Scoring</h3>

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
											<input type="hidden" name="orig_goal" id="orig_goal" value="N">
										</h4>

										<div class="well" style="margin-right:50px;margin-left:20px;">
											<h4 style="margin-top:0px;">Was the goal achieved?</h4> 
						    				<br/>
						    				<div class="btn-group" data-toggle="buttons">
											  <label class="btn btn-info btn-lg" id="goal-yes">
											    <input type="radio" name="goal" value="Y" autocomplete="off" required> Yes
											  </label>
											  <label class="btn btn-info btn-lg" id="goal-no">
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
											<input type="hidden" name="orig_criteria" id="orig_criteria" value="N">
										</h4>

										<div class="well" style="margin-right:50px;margin-left:20px;">
											<h4 style="margin-top:0px;">Was the criteria met?</h4> 
											
											<br/>
						    				<div class="btn-group" data-toggle="buttons">
											  <label class="btn btn-info btn-lg" id="criteria-yes">
											    <input type="radio" name="criteria" value="Y" autocomplete="off" required> Yes
											  </label>
											  <label class="btn btn-info btn-lg" id="criteria-no">
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
												<input type="hidden" name="orig_quantity" id="orig_quantity" value="0">
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
							<?php if($report->account_id == Yii::app()->user->id && ($report->status_id != 1 || $report->status_id != 2)): ?>
							<button type="submit" class="btn btn-lg btn-warning" name="submit" style="margin-right:20px" <?php if($president == null) echo "disabled id='btn-disabled'"; else echo "id='btn-draft'"; ?> > 
									 <span class="fa fa-folder-o" style="margin-right:10px"></span>Save to Drafts
							</button>
							<?php endif; ?>
							<button type="submit" class="btn btn-lg btn-primary" name="update_report" style="margin-right:20px" <?php if($president == null) echo "disabled"; else echo "id='btn-update'"; ?> > 
								 <span class="fa fa-upload" style="margin-right:10px"></span>Update & Submit
							</button>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div>
	</form>
</section><!-- /.content -->