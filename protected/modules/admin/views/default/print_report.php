<section class="content">
  <div class="row">
    <div class="col-xs-4">
      <img src="<?php echo Yii::app()->baseUrl; ?>/images/report-logo.jpg"  style="margin-top:10px;"></img> 
    </div>
    <div class="col-xs-8">
      <h4 class="modal-title text-center" style="margin-top:20px;"><strong>PROJECT COMPLETION REPORT</strong></h4>
          <p>
            <strong>
              This report highlights how JCI Active Citizen Framework is used to drive sustainable impact at local level. This Captures relevant information about our impact Stories of how we are providing opportunities to empower young people to create positive change locally.
            </strong>
            <br/>
          </p>
    </div>
  </div>

  <div class="row">
  <!-- name of LO chapter -->
    <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Local Organization (LO)</u></strong></div>
    <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo Chapter::model()->getChapter($report->chapter_id); ?></div>
  </div>

  <div class="row">
    <!-- name of LO president -->
    <div class="col-xs-6 text-center" style="padding:0px;">
      <div style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Name of L.O. President</u></strong></div>
      <div style="border-style: solid; padding: 10px;"><?php echo User::model()->getCompleteName2($report->president_id); ?></div>
    </div>

    <!-- name of project chairman -->
    <div class="col-xs-6 text-center" style="padding:0px;">
      <div style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Name of Project Chairman</u></strong></div>
      <div style="border-style: solid; padding: 10px;"><?php echo User::model()->getCompleteName2($report->chairman_id); ?></div>
    </div>
  </div>

  <div class="row">
    <!-- project title -->
    <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Project Title</u></strong></div>
    <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo $report->project_title; ?></div>
  </div>

  <div class="row">
    <!-- key results area -->
    <div class="col-xs-4 text-center" style="padding:0px;">
      <div style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Key Result Area</u></strong></div>
      <div style="border-style: solid; padding: 10px; height:70px;"><strong><?php echo PeaCategory::model()->getCat($report->rep_id); ?></strong></div>
    </div>

    <!-- category -->
    <div class="col-xs-3 text-center" style="padding:0px;">
      <div style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Category</u></strong></div>
      <div style="border-style: solid; padding: 10px; height:70px;"><small><strong><?php echo PeaSubcat::model()->getSubCat($report->rep_id); ?></strong></small></div>
    </div>

    <!-- reference code -->
    <div class="col-xs-3 text-center" style="padding:0px;">
      <div style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>JCIPEA Reference Code[1]</u></strong></div>
      <div style="border-style: solid; padding: 10px; height:70px;"><strong><?php echo $report->rep_id; ?></strong></div>
    </div>

    <div class="col-xs-2 text-center" style="padding:0px;">
      <div style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Quantity</u></strong></div>
      <div style="border-style: solid; padding: 10px; height:70px;"><strong><?php echo $report->score->qty; ?></strong></div>
    </div>
  </div>

  <div class="row">
    <!-- description -->
    <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Description</u></strong></div>
    <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo $report->brief_description; ?></div>
  </div>

  <div class="row">
    <!-- objectives -->
    <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Objectives</u></strong></div>
    <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo $report->objectives; ?></div>
  </div>


  <div class="row">
    <!-- action taken -->
    <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Action Taken</u></strong></div>
    <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo $report->action_taken; ?></div>
  </div>

  <div class="row">
    <!-- results achieved -->
    <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Results Achieved</u></strong></div>
    <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo $report->results_achieved; ?></div>
  </div>

  <div class="row">
    <!-- program partners -->
    <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Program Partners</u></strong></div>
    <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo $report->program_partners; ?></div>
  </div>

  <div class="row">
    <!-- recommendations -->
    <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Recommendation</u></strong></div>
    <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo $report->recommendation; ?></div>
  </div>

  <div class="row">
    <!-- date completed -->
    <div class="col-xs-4 text-center" style="padding:0px;">
      <div style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Date Completed</u></strong></div>
      <div style="border-style: solid; padding: 10px;"><?php echo date('F d, Y', strtotime($report->data_completed)); ?></div>
    </div>

    <!-- No. of JCI Members Involved -->
    <div class="col-xs-4 text-center" style="padding:0px;">
      <div style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>No. of JCI Members Involved</u></strong></div>
      <div style="border-style: solid; padding: 10px;"><?php echo $report->members_involved; ?></div>
    </div>

    <!-- No. of Non-JCI Sectors Involved -->
    <div class="col-xs-4 text-center" style="padding:0px;">
      <div style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>No. of Non-JCI Sectors Involved</u></strong></div>
      <div style="border-style: solid; padding: 10px;"><?php echo $report->sectors_involved; ?></div>
    </div>
  </div>

  <div class="row">
    <!-- projected income -->
    <div class="col-xs-3 text-center" style="padding:0px;">
      <div style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Projected Income</u></strong></div>
      <div style="border-style: solid; padding: 10px;"><?php echo $report->projected_income; ?></div>
    </div>

    <!-- projected expenditures -->
    <div class="col-xs-3 text-center" style="padding:0px;">
      <div style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Projected Expenditures</u></strong></div>
      <div style="border-style: solid; padding: 10px;"><?php echo $report->projected_expenditures; ?></div>
    </div>

    <!-- actual income -->
    <div class="col-xs-3 text-center" style="padding:0px;">
      <div style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Actual Income</u></strong></div>
      <div style="border-style: solid; padding: 10px;"><?php echo $report->actual_income; ?></div>
    </div>

    <!-- actual expenditures -->
    <div class="col-xs-3 text-center" style="padding:0px;">
      <div style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Actual Expenditures</u></strong></div>
      <div style="border-style: solid; padding: 10px;"><?php echo $report->actual_expenditures; ?></div>
    </div>
  </div>

  <div class="row">

    <!-- report avatar -->
    <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong><u>Picture</u></strong></div>
    <div class="text-center" style="border-style: solid; padding: 10px;">
      <img src="<?php echo Yii::app()->baseUrl; ?>/jcipea_reports/<?php echo Chapter::model()->getAreaNo($report->chapter_id); ?>/<?php echo PeaReports::model()->getReportPictures($report->fileupload_id); ?>" class="img-responsive" />
    </div>
  </div>
</section>