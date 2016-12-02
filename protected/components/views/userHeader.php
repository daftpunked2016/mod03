<header class="main-header">
  <!-- Logo -->
  <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/account/listscoring" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">
      <!-- <img src="<?php //echo Yii::app()->request->baseUrl; ?>/dist/img/navbar_mini_jci.png" alt="JCI LOGO" height="42" width="35" /> -->
      JCI
    </span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg">
      <!-- <img src="<?php //echo Yii::app()->request->baseUrl; ?>/dist/img/navbar_jci.png" alt="JCI LOGO" height="45" width="102" /> -->
      JCI<strong>PEA</strong>
    </span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="http://www.jci.org.ph/mod02/user_avatars/<?php echo $user_avatar; ?>" class="user-image" alt="User Image"/>
            <span class="hidden-xs"><?php echo User::model()->getCompleteName(); ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="http://www.jci.org.ph/mod02/user_avatars/<?php echo $user_avatar; ?>" class="img-circle" alt="User Image" />
              <p>
                <?php echo User::model()->getCompleteName(); ?>
                <small><?php echo User::model()->getPosition(); ?></small>
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
                <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/site/logout" class="btn btn-primary btn-flat">Sign out</a>
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