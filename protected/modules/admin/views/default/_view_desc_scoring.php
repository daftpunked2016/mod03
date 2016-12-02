<?php $scoring = PeaScores::model()->with('report')->find('t.rep_id = "'.$data->rep_id.'" AND t.chapter_id = '.$chapter->id); 
//if($scoring != null)
//{$scoring->report = PeaReports::model()->find(array('condition'=>'id ='. $scoring->report_id));} ?>
<tr class='desc <?php if($scoring == null) echo "danger"; else { if($data->color === "BLUE") echo "info"; elseif($data->color === "GREEN") echo "success"; }; ?>'>
	<td>
    <a href="#reportModal-<?php echo CHtml::encode($data->rep_id); ?>" data-toggle="modal" data-target="#reportModal-<?php echo CHtml::encode($data->rep_id); ?>"><strong>
      <?php echo CHtml::encode($data->rep_id); ?>
    </strong></a>
  </td>
  <td style="color:<?php if($data->color === "BLUE") echo "#0000FF"; elseif($data->color === "GREEN") echo "#6B8E23"; else echo "#000";  ?>;">
    <?php echo CHtml::encode($data->description); ?>
  </td>
  <td>
    <?php if($scoring == null) echo "<b>N/A</b>"; else {if($scoring->goal_status === "Y") echo "<b>Yes</b>"; else echo "<i style='font-color:red'>No</i>";} ; ?>
  </td>
  <td>
    <?php if($scoring == null) echo "<b>N/A</b>"; else  {if($scoring->criteria_status === "Y") echo "<b>Yes</b>"; else echo "<i style='font-color:red'>No</i>";} ?>
  </td>
  <td class='scores <?php if($data->color === "BLUE") echo "blue"; elseif($data->color === "GREEN") echo "green"; else echo "black";?>'>
    <?php if($scoring == null) echo "<b>N/A</b>"; else echo $scoring->qty; ?>
  </td>
  <td>
    <span id="raw_score"><?php if($scoring == null) echo "0"; else { if($scoring->report->status_id == 1) echo "<B>".$scoring->score."</B>"; else echo "<small>Pending</small>"; }; ?></span>
  </td>
	<td>
     <?php if($scoring != null): ?>
        <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/default/printreport?id=<?php echo $scoring->report->id; ?>" target="_blank">
    <?php endif; ?>
      <button class="btn btn-danger btn-sm" style="margin-top:3px;" <?php if($scoring == null) echo "disabled='disabled'"; ?>>
          <i class="fa fa-print" style="margin-right:3px"></i> Print Report
      </button>
    <?php if($scoring != null): ?>
        </a>
    <?php endif; ?>
    <button class="btn btn-primary btn-sm" style="margin-top:3px;" <?php if($scoring == null) echo "disabled='disabled'"; ?> data-toggle="modal" data-target="#reportModal-<?php echo CHtml::encode($data->rep_id); ?>"><i class="fa fa-file" style="margin-right:3px;"></i>View Report</button>
	</td>
</tr>

<?php if($scoring->report != null): ?>
<!-- Modal -->
<div id="reportModal-<?php echo CHtml::encode($data->rep_id); ?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <div class="row">
        <div class="col-sm-4">
          <img src="<?php echo Yii::app()->baseUrl; ?>/images/report-logo.jpg"  style="margin-top:10px;"></img> 
        </div>
        <div class="col-sm-8">
          <h4 class="modal-title text-center" style="margin-top:0px;"><strong>PROJECT COMPLETION REPORT</strong></h4>
              <p>
                <strong>
                  <small>This report highlights how JCI Active Citizen Framework is used to drive sustainable impact at local level. This Captures relevant information about our impact Stories of how we are providing opportunities to empower young people to create positive change locally.</small>
                </strong>
                <br/>
                <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/account/printreport/<?php echo $scoring->report->id ?>" target="_blank" class="btn btn-primary btn-xs pull-right" style="margin-bottom:15px; margin-right:10px;"><i class="fa fa-print" style="margin-right:5px;"></i>Print Report</a>
              </p>
        </div>
      </div>
      </div>
        <div class="modal-body">
        <!-- <p>Some text in the modal.</p> -->

        <!-- name of LO chapter -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Local Organization (LO)</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo Chapter::model()->getChapter($scoring->report->chapter_id); ?></div>
        
        <!-- name of LO president -->
        <div class="col-lg-6 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Name of L.O. President</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo User::model()->getCompleteName2($scoring->report->president_id); ?></div>
        </div>

        <!-- name of project chairman -->
        <div class="col-lg-6 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Name of Project Chairman</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo User::model()->getCompleteName2($scoring->report->chairman_id); ?></div>
        </div>

        <div class="row"></div>

        <!-- project title -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Project Title</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($scoring->report->project_title); ?></div>

        <!-- key results area -->
        <div class="col-lg-6 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Key Result Area</strong></div>
          <div style="border-style: solid; padding: 10px; height:100px;"><strong><?php echo PeaCategory::model()->getCat($scoring->report->rep_id); ?></strong></div>
        </div>

        <!-- category -->
        <div class="col-lg-3 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Category</strong></div>
          <div style="border-style: solid; padding: 10px; height:100px;"><small><strong><?php echo PeaSubcat::model()->getSubCat($scoring->report->rep_id); ?></strong></small></div>
        </div>

        <!-- reference code -->
        <div class="col-lg-3 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>JCIPEA Reference Code[1]</strong></div>
          <div style="border-style: solid; padding: 10px; height:100px;"><strong><?php echo CHtml::encode($scoring->report->rep_id); ?></strong></div>
        </div>

        <div class="row"></div>

        <!-- description -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Description</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($scoring->report->brief_description); ?></div>

        <!-- objectives -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Objectives</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($scoring->report->objectives); ?></div>

        <!-- action taken -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Action Taken</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($scoring->report->action_taken); ?></div>

        <!-- results achieved -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Results Achieved</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($scoring->report->results_achieved); ?></div>

        <!-- program partners -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Program Partners</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($scoring->report->program_partners); ?></div>

        <!-- recommendations -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Recommendation</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($scoring->report->recommendation); ?></div>

        <!-- date completed -->
        <div class="col-lg-4 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Date Completed</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo CHtml::encode(date('F d, Y', strtotime($scoring->report->data_completed))); ?></div>
        </div>

        <!-- No. of JCI Members Involved -->
        <div class="col-lg-4 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>No. of JCI Members Involved</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($scoring->report->members_involved); ?></div>
        </div>

        <!-- No. of Non-JCI Sectors Involved -->
        <div class="col-lg-4 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>No. of Non-JCI Sectors Involved</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($scoring->report->sectors_involved); ?></div>
        </div>

        <!-- projected income -->
        <div class="col-lg-3 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Projected Income</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($scoring->report->projected_income); ?></div>
        </div>

        <!-- projected expenditures -->
        <div class="col-lg-3 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Projected Expenditures</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($scoring->report->projected_expenditures); ?></div>
        </div>

        <!-- actual income -->
        <div class="col-lg-3 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Actual Income</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($scoring->report->actual_income); ?></div>
        </div>

        <!-- actual expenditures -->
        <div class="col-lg-3 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Actual Expenditures</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($scoring->report->actual_expenditures); ?></div>
        </div>

        <div class="row"></div>

        <!-- report avatar -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Picture</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;">
          <img src="<?php echo Yii::app()->baseUrl; ?>/jcipea_reports/<?php echo Chapter::model()->getAreaNo($scoring->report->chapter_id); ?>/<?php echo PeaReports::model()->getReportPictures($scoring->report->fileupload_id); ?>" class="img-responsive" />
        </div>

      </div>
      <div class="modal-footer">
        <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/default/printreport?id=<?php echo $scoring->report->id; ?>" target="_blank" class="btn btn-primary" style="margin-right:10px;"><i class="fa fa-print" style="margin-right:5px;"></i>Print Report</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<?php endif; ?>