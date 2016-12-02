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
      <li class="header">RTD MAIN NAVIGATION</li>
      <li>
        <?php echo CHtml::link('<i class="fa fa-dashboard"></i> <span>Dashboard</span>', array('default/index')); ?>
      </li>
      <!-- <li>
        <?php //echo CHtml::link('<i class="fa fa-list"></i> <span>Training Card</span>', array('etrainingScorecard/index')); ?>
      </li> -->
      <li>
        <?php echo CHtml::link('<i class="glyphicon glyphicon-list-alt"></i><span>Rankings</span>',array('etrainingScorecard/ranking')) ?>
      </li>
    </ul>    
  </section>
  <!-- /.sidebar -->
</aside>