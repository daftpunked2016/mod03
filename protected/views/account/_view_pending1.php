<tr>
	<td><a href="#myModal-<?php echo CHtml::encode($data->id); ?>" data-toggle="modal" data-target="#myModal-<?php echo CHtml::encode($data->id); ?>"><strong><?php echo CHtml::encode($data->project_title); ?></strong></a></td>
	<td><?php echo Chapter::model()->getChapter($data->chapter_id); ?></td>
	<td><?php echo User::model()->getCompleteName2($data->account_id); ?></td>
	<td><?php echo CHtml::encode(date('F d, Y', strtotime($data->date_upload))); ?></td>
	<td>
		<?php
			echo CHtml::link('<span class="fa fa-search" style="margin-right:3px;"></span>View', array('/account/viewreportpdf', 'id' => $data->id), array('class' => 'btn btn-warning btn-sm', 'title' => 'View Report', 'target'=>'_blank', 'style'=>'margin-right:3px;'));
      echo CHtml::link('<span class="fa fa-pencil" style="margin-right:3px;"></span>Edit', array('/account/viewreportpdf', 'id' => $data->id), array('class' => 'btn btn-primary btn-sm', 'title' => 'View Report', 'target'=>'_blank', 'style'=>'margin-right:3px;'));
			
      if($display_actions_status)
      {
        echo CHtml::link('<span class="fa fa-check" style="margin-right:3px;"></span>Approve',array('/account/approvereport', 'id' => $data->id, 'st'=>'p'), array('class' => 'btn btn-success btn-sm', 'title' => 'Approve Report', 'confirm' => "Are you sure you want to Approve this report?", 'style'=>'margin-right:3px;'));
  			echo CHtml::link('<span class="fa fa-remove" style="margin-right:3px;"></span>Reject', array('/account/rejectreport', 'id' => $data->id, 'st'=>'p'), array('class' => 'btn btn-danger btn-sm', 'confirm' => "Are you sure you want to Reject this report?", 'title' => 'Reject Report', 'style'=>'margin-right:3px;'));
		  } 

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
	    <h4 class="modal-title text-center"><strong>PROJECT COMPLETION REPORT</strong></h4>
	        <p>
	        	<strong>
	        		<small>This report highlights how JCI Active Citizen Framework is used to drive sustainable impact at local level. This Captures relevant information about our impact Stories of how we are providing opportunities to empower young people to create positive change locally.</small>
	        	</strong>
	        </p>
	    </div>
      	<div class="modal-body">
        <!-- <p>Some text in the modal.</p> -->

        <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Local Organization (LO)</strong></div>
        <div class="text-center" style="border-style: solid; padding: 10px;"><?php echo Chapter::model()->getChapter($data->chapter_id); ?></div>
        
    	<div class="col-lg-6 text-center" style="padding:0px;">
    		<div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Name of L.O. President</strong></div>
    		<div style="border-style: solid; padding: 10px;"><?php echo User::model()->getCompleteName2($data->president_id); ?></div>
    	</div>
    	<div class="col-lg-6 text-center" style="padding:0px;">
    		<div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Name of Project Chairman</strong></div>
   			<div style="border-style: solid; padding: 10px;"><?php echo User::model()->getCompleteName2($data->chairman_id); ?></div>
    	</div>

    	<div class="row"></div>

	    <div class="text-center" style="background-color: grey; border-style: solid; padding: 10px;"><strong>Project Title</strong></div>
       	<div class="text-center" style="border-style: solid; padding: 10px;"><?php echo CHtml::encode($data->project_title); ?></div>

       	<div class="col-lg-6 text-center" style="padding:0px;">
    		<div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Key Result Area</strong></div>
    		<div style="border-style: solid; padding: 10px;"><strong><?php echo PeaCategory::model()->getCat($data->rep_id); ?></strong></div>
    	</div>
    	<div class="col-lg-3 text-center" style="padding:0px;">
    		<div style="background-color: grey; border-style: solid; padding: 10px;"><strong>Category</strong></div>
    		<div style="border-style: solid; padding: 10px;"><small><strong><?php echo PeaSubcat::model()->getSubCat($data->rep_id); ?></strong></small></div>
    	</div>
    	<div class="col-lg-3 text-center" style="padding:0px;">
    		<div style="background-color: grey; border-style: solid; padding: 10px;"><strong>JCIPEA Reference Code[1]</strong></div>
    		<div style="border-style: solid; padding: 10px;"><strong><?php echo CHtml::encode($data->rep_id); ?></strong></div>
    	</div>

    	<div class="row"></div>
    	</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>