<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/training" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>N</b>TD</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>e</b>Training</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="<?php //echo Yii::app()->request->baseUrl; ?>/dist/img/user2-160x160.png" class="user-image" alt="User Image"/> -->
              <img class="user-image" src="http://www.jci.org.ph/mod02/user_avatars/<?php echo $user_avatar; ?>">
              <span class="hidden-xs">
                <?php echo $user->firstname." ".$user->lastname; ?>
              </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <!-- <img src="<?php //echo Yii::app()->request->baseUrl; ?>/dist/img/user2-160x160.png" class="img-circle" alt="User Image" /> -->
                <img class="img-circle" alt="User Image" src="http://www.jci.org.ph/mod02/user_avatars/<?php echo $user_avatar; ?>">
                <p>
                  <strong><?php echo $user->firstname." ".$user->lastname; ?></strong>
                  <small><?php echo User::model()->getPosition2($id); ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- <li class="user-body">
                <div class="col-xs-4 text-center">
                  <a href="#">Followers</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Sales</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Friends</a>
                </div>
              </li> -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <!-- <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div> -->
                <div class="text-center">
                  <!-- <a href="#" class="btn btn-default btn-flat">Sign out</a> -->
                  <?php echo CHtml::link('Sign Out', array('default/logout'),array('class'=>'btn btn-default btn-flat')); ?>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>