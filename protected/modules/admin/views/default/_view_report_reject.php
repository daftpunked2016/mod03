<tr>
  <td><?php echo CHtml::encode($data->rep_id); ?></td>
	<td><a href="#myModal-<?php echo CHtml::encode($data->id); ?>" data-toggle="modal" data-target="#myModal-<?php echo CHtml::encode($data->id); ?>"><strong><?php echo CHtml::encode($data->project_title); ?></strong></a></td>
	<td><?php echo Chapter::model()->getChapter($data->chapter_id); ?></td>
	<td><?php echo User::model()->getCompleteName2($data->account_id); ?></td>
	<td><?php echo CHtml::encode(date('F d, Y', strtotime($data->date_upload))); ?></td>
  <td class="text-center"><?php echo CHtml::encode($data->score->qty); ?></td>
  <td class="text-center"><?php echo CHtml::encode($data->score->goal_status); ?></td>
  <td class="text-center"><?php echo CHtml::encode($data->score->criteria_status); ?></td>
  <td><a href="#remarksModal-<?php echo CHtml::encode($data->id); ?>" data-toggle="modal" data-target="#remarksModal-<?php echo CHtml::encode($data->id); ?>">
        View Remarks
      </a>
  </td>
	<td class='text-center'>
		<?php
      echo CHtml::link('<span class="fa fa-file-image-o" style="margin-right:3px;"></span>', array('/admin/default/viewprojphoto', 'id' => $data->id), array('title' => 'View Report', 'target'=>'_blank', 'style'=>'margin-right:3px;'));

      if($data->attendance_sheet != 0)
      {
        echo CHtml::link('<span class="fa fa-list" style="margin-right:3px;"></span>', array('/admin/default/viewattsheet', 'id' => $data->id), array('title' => 'View Attendance Sheet', 'target'=>'_blank', 'style'=>'margin-right:3px;'));
      }
      
      echo '<a href="#statusModal-'.CHtml::encode($data->id).'" data-toggle="modal" data-target="#statusModal-'.CHtml::encode($data->id).'" style="margin-right:3px;">
        <span class="fa fa-info" style="margin-right:3px;"></span>
      </a>';

      echo CHtml::link('<span class="fa fa-check" style="margin-right:3px;"></span>',array('/admin/default/approvereport', 'id' => $data->id), array('title' => 'Approve Report', 'confirm' => "Are you sure you want to Approve this report?"));
    ?>
	</td>
</tr>

<!-- Modal -->
<div id="myModal-<?php echo CHtml::encode($data->id); ?>" class="modal fade" role="dialog">
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
                <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/account/printreport/<?php echo $data->id; ?>" target="_blank" class="btn btn-primary btn-xs pull-right" style="margin-bottom:15px; margin-right:10px;"><i class="fa fa-print" style="margin-right:5px;"></i>Print Report</a>
              </p>
        </div>
      </div>
      </div>
        <div class="modal-body">
        <!-- <p>Some text in the modal.</p> -->

        <!-- name of LO chapter -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Local Organization (LO)</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo Chapter::model()->getChapter($data->chapter_id); ?></div>
        
        <!-- name of LO president -->
        <div class="col-lg-6 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Name of L.O. President</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo User::model()->getCompleteName2($data->president_id); ?></div>
        </div>

        <!-- name of project chairman -->
        <div class="col-lg-6 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Name of Project Chairman</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo User::model()->getCompleteName2($data->chairman_id); ?></div>
        </div>

        <div class="row"></div>

        <!-- project title -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Project Title</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($data->project_title); ?></div>

        <!-- key results area -->
        <div class="col-lg-4 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Key Result Area</strong></div>
          <div style="border-style: solid; padding: 10px; height:100px;"><strong><?php echo PeaCategory::model()->getCat($data->rep_id); ?></strong></div>
        </div>

        <!-- category -->
        <div class="col-lg-3 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Category</strong></div>
          <div style="border-style: solid; padding: 10px; height:100px;"><small><strong><?php echo PeaSubcat::model()->getSubCat($data->rep_id); ?></strong></small></div>
        </div>

        <!-- reference code -->
        <div class="col-lg-3 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>JCIPEA Reference Code[1]</strong></div>
          <div style="border-style: solid; padding: 10px; height:100px;"><strong><?php echo CHtml::encode($data->rep_id); ?></strong></div>
        </div>

        <!-- quantity if provided -->
        <div class="col-lg-2 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Quantity</strong></div>
          <div style="border-style: solid; padding: 10px; height:100px;"><strong><?php echo CHtml::encode($data->score->qty); ?></strong></div>
        </div>

        <div class="row"></div>

        <!-- description -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Description</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($data->brief_description); ?></div>

        <!-- objectives -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Objectives</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($data->objectives); ?></div>

        <!-- action taken -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Action Taken</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($data->action_taken); ?></div>

        <!-- results achieved -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Results Achieved</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($data->results_achieved); ?></div>

        <!-- program partners -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Program Partners</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($data->program_partners); ?></div>

        <!-- recommendations -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Recommendation</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($data->recommendation); ?></div>

        <!-- date completed -->
        <div class="col-lg-4 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Date Completed</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo CHtml::encode(date('F d, Y', strtotime($data->data_completed))); ?></div>
        </div>

        <!-- No. of JCI Members Involved -->
        <div class="col-lg-4 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>No. of JCI Members Involved</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($data->members_involved); ?></div>
        </div>

        <!-- No. of Non-JCI Sectors Involved -->
        <div class="col-lg-4 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>No. of Non-JCI Sectors Involved</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($data->sectors_involved); ?></div>
        </div>

        <!-- projected income -->
        <div class="col-lg-3 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Projected Income</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($data->projected_income); ?></div>
        </div>

        <!-- projected expenditures -->
        <div class="col-lg-3 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Projected Expenditures</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($data->projected_expenditures); ?></div>
        </div>

        <!-- actual income -->
        <div class="col-lg-3 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Actual Income</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($data->actual_income); ?></div>
        </div>

        <!-- actual expenditures -->
        <div class="col-lg-3 text-center" style="padding:0px;">
          <div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Actual Expenditures</strong></div>
          <div style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($data->actual_expenditures); ?></div>
        </div>

        <div class="row"></div>

        <!-- report avatar -->
        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Picture</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;">
          <img src="<?php echo Yii::app()->baseUrl; ?>/jcipea_reports/<?php echo Chapter::model()->getAreaNo($data->chapter_id); ?>/<?php echo PeaReports::model()->getReportPictures($data->fileupload_id); ?>" class="img-responsive" />
        </div>

      </div>
      <div class="modal-footer">
        <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/default/printreport?id=<?php echo $data->id; ?>" target="_blank" class="btn btn-primary" style="margin-right:10px;"><i class="fa fa-print" style="margin-right:5px;"></i>Print Report</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="statusModal-<?php echo CHtml::encode($data->id); ?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong> Status </strong></h4>
      </div>
      <div class="modal-body">
        <center>
          <?php 
              $status = PeaTransactions::model()->findAll('report_id = '.$data->id); 

              if(!empty($status)) {
                foreach($status as $key=>$status) {
                  echo '<b>'.($key+1).'</b>.  '.$status->detail.' <br><i><small>('.date('F d, Y g:i A', strtotime($status->date_created)).')</small></i><br /><br />';
                }
              } else {
                echo "<b>No Status Available</b>";
              }
          ?>
        </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<!-- Modal -->
<div id="remarksModal-<?php echo CHtml::encode($data->id); ?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong> Remarks </strong></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-3"><b>Rejected By</b></div>
          <div class="col-md-9"><?php echo PeaReportsRemarks::model()->getRejector($data->id); ?></div>
        </div>
        <div class="row" style="margin-top:10px;">
          <div class="col-md-3"><b>Remarks</b></div>
          <div class="col-md-9"><?php echo PeaReportsRemarks::model()->getRemarks($data->id); ?></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>