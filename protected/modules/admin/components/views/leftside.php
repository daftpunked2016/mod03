<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <!-- <img src="<?php //echo Yii::app()->request->baseUrl; ?>/dist/img/user2-160x160.png" class="img-circle" alt="User Image" /> -->
        <img class="img-circle" alt="User Image" src="http://www.jci.org.ph/mod02/user_avatars/<?php echo $user_avatar; ?>">
      </div>
      <div class="pull-left info">
        <p>
          <?php echo $user->firstname." ".$user->lastname; ?>
        </p>

        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <!-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search..."/>
        <span class="input-group-btn">
          <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form> -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li><?php echo CHtml::link('<i class="fa fa-dashboard"></i><span>Dashboard</span>',array('default/dashboard')) ?></li>
      <!-- reports -->
      <li class="active treeview">
        <a href="#">
          <i class="fa fa-file-o"></i> <span>Reports</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><?php echo CHtml::link('<i class="fa fa-question"></i><span>Pending</span><small class="label pull-right bg-blue">'.count(PeaReports::model()->isApprovedRVP()->findAll()).'</small>',array('default/index')) ?></li>
          <li><?php echo CHtml::link('<i class="fa fa-check"></i><span>Approved</span><small class="label pull-right bg-green">'.count(PeaReports::model()->isApproved()->findAll()).'</small>',array('default/approved')) ?></li>
          <li><?php echo CHtml::link('<i class="fa fa-times"></i><span>Rejected</span><small class="label pull-right bg-red">'.count(PeaReports::model()->isRejected()->findAll()).'</small>',array('default/reject')) ?></li>
          <?php if ($settings->bypass_status == 1): ?>
            <li><?php echo CHtml::link('<i class="fa fa-sign-in"></i><span>For Approval-By Pass</span><small class="label pull-right bg-yellow">'.count(PeaReports::model()->isApprovedPres()->findAll()).'</small>',array('default/bypass')) ?></li>
          <?php endif; ?>
        </ul>
      </li>

      <!-- category -->
      <li class="active treeview">
        <a href="#">
          <i class="fa fa-dashboard"></i>
          <span>Categories</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <?php foreach ($category as $cat): ?>
            <li class="treeview">
              <?php echo CHtml::link('<i class="fa fa-circle"></i><span>'.ucfirst(strtolower($cat->category)).'</span> <i class="fa fa-angle-left pull-right"></i>',array('default/category', 'id'=>$cat->cat_id)) ?>
              <ul class="treeview-menu">
                <?php
                  $subcat = PeaSubcat::model()->findAll('cat_id ='.$cat->cat_id);
                  foreach ($subcat as $scat):
                ?>
                  <li>
                    <?php echo CHtml::link('<i class="fa fa-circle-o"></i><span>'.ucfirst(strtolower($scat->SubCat)).'</span>',array('default/subcategory', 'id'=>$scat->sub_id)) ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </li>
          <?php endforeach; ?>
        </ul>
      </li>

      <!-- Scorecards -->
      <li>
        <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/default/selectchapter">
          <i class="fa fa-bar-chart"></i>
          <span>Scorecards</span>
        </a>
      </li>

      <li>
        <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/default/ranking">
          <i class="glyphicon glyphicon-list-alt"></i>
          <span>Rankings</span>
        </a>
      </li>

    </ul>

    <!-- activae / deactivate AVP -->
    <div style="position:absolute; bottom:0px; width:100%;">
      <ul class="sidebar-menu">
        <li class="header text-red"><b>PEA SETTINGS</b></li>
        <li>
          <?php
            // if($avp->status_id == 1) {
            //   echo CHtml::link('<i class="fa fa-lock"></i><span> Deactivate AVP</span>', array('avpactivate/deactivate'),array('confirm' => 'Are you sure you want to Deactivate AVP for the approval of reports?'));
            // } else {
            //   echo CHtml::link('<i class="fa fa-unlock"></i><span> Activate AVP</span>', array('avpactivate/activate'),array('confirm' => 'Are you sure you want to Activate AVP for the approval of reports?'));
            // }

            echo CHtml::link('<span class="fa fa-cogs"></span> Settings', array('settings/index'));
          ?>
        </li>
      </ul>
    </div>
    
  </section>
  <!-- /.sidebar -->
</aside>