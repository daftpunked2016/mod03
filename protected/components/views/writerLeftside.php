<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel" style="margin-bottom:20px;">
      <div class="pull-left image">
        <img src="http://www.jci.org.ph/mod02/user_avatars/<?php echo $user_avatar; ?>" class="img-circle" alt="User Image" />
      </div>
      <div class="pull-left info">
        <p><?php echo User::model()->getCompleteName(); ?></p>

        <small>JCI Philippines</small>
      </div>
    </div>

    <ul class="sidebar-menu">
      <li class="header">NAVIGATION</li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file"></i> <span>Reports</span> <i class="fa fa-angle-left pull-right"></i>
          <?php 
            $pcount = PeaReports::model()->countReports('p');
            $rcount = PeaReports::model()->countReports('r');  
            $acount = PeaReports::model()->countReports('a');
            $dcount = PeaReports::model()->countReports('d');

            if($user->position_id != 13){
              if($pcount != 0)
                echo '<span class="badge" style="background-color:#0000FF; margin-left:3px;">!</span>'; 
            }

            if($rcount != 0)
              echo '<span class="badge" style="background-color:#FF0000; margin-left:3px;">!</span>';
          ?>
        </a>

        <ul class="treeview-menu">
          <li>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/account/viewreports?st=p">
              <i class="fa fa-question"></i><span style="margin-right:5px;">Pending</span>
              <?php 
                if($user->position_id != 13){
                  if($pcount == 0)
                    echo '<span class="badge">0</span>';
                  else
                  echo '<span class="badge" style="background-color:#0000FF;">'.$pcount.'</span>';
                }
              ?>
            </a>
          </li>
          <li>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/account/viewreports?st=a">
              <i class="fa fa-check"></i><span style="margin-right:5px;">Approved</span>
              <?php 
                echo '<span class="badge"  style="background-color:#32CD32;">'.$acount.'</span>';
              ?>
            </a>
          </li>
          <li>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/account/viewreports?st=r">
              <i class="fa fa-times"></i><span style="margin-right:5px;">Rejected</span>
              <?php
                if($rcount == 0)
                  echo '<span class="badge">0</span>';
                else
                  echo '<span class="badge" style="background-color:#FF0000;">'.$rcount.'</span>';
              ?>
            </a>
          </li>

          <li>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/account/viewreports?st=d">
              <i class="fa fa-folder-o"></i><span style="margin-right:5px;">My Reports</span>
              <?php
                if($dcount == 0)
                  echo '<span class="badge">0</span>';
                else
                  echo '<span class="badge">'.$dcount.'</span>';
              ?>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>