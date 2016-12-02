<div class="login-box">
  <div class="login-logo">
    <img src = "<?php echo Yii::app()->request->baseUrl; ?>/dist/img/navbar_jci.png" width="300px" height="150px" ></img>
  </div><!-- /.login-logo -->
  <div class="login-box-body">

    <?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
      if($key  === 'success')
      {
        echo "<div class='alert alert-success alert-dismissible fade-in' role='alert'>
        <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
        $message.'</div>';
      }
      else
      {
        echo "<div class='alert alert-danger alert-dismissible fade-in' role='alert' id='myAlert'>
        <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
        $message.'</div>';
      }
    }
    ?>


    <h4 class="login-box-msg">Member Login</h4>
    <?php $form=$this->beginWidget('CActiveForm', array(
    	'id'=>'login-form',
    	'enableClientValidation'=>true,
    	'clientOptions'=>array(
    		'validateOnSubmit'=>true,
       ),
       )); ?>
       <div class="form-group has-feedback">
         <?php echo $form->textField($model,'username', array('class'=>'form-control', 'type'=>'email', 'placeholder'=>'Email')); ?><span class="glyphicon glyphicon-user form-control-feedback"></span>
         <?php echo $form->error($model,'username'); ?>
       </div>

      <div class="form-group has-feedback">
         <?php echo $form->passwordField($model,'password', array('class'=>'form-control', 'placeholder'=>'Password')); ?><span class="glyphicon glyphicon-lock form-control-feedback"></span>
         <small class="pull-right" style="margin-top:5px;">
        </small>
      </div>

      <div class="row text-center">
        <div class="checkbox icheck">
         <small>
          <?php echo $form->checkbox($model,'rememberMe'); ?>
          <?php echo $form->label($model,'rememberMe'); ?>
          <?php echo $form->error($model,'rememberMe'); ?>
        </small>
      </div>
    </div>

    <div class="form-group">
      <?php echo CHtml::submitButton('Sign in', array('class'=>'btn btn-primary btn-block btn-flat pull-right')); ?>
    </div>

    <?php $this->endWidget(); ?>
    <br></br>
    <div class="row text-center">
      <small><i>* Note: Only <strong>LO President</strong>, <strong>LO Secretary</strong>, <strong>RVP</strong> and <strong>AVP</strong> can log in this page. *</i></small>
    </div>

    <div class="row">
      <small>
        <i>* <b class="text-red">Important Message</b>: 
        <br>
        If you're having difficulty in uploading files. </i>
        <br>
        Please do the following:
        <br>
        1. Clear Browser <strong>Cache</strong> and <strong>Cookies</strong>
        <br>
        2. Hold down <strong>Ctrl</strong> and press <strong>F5</strong>
        <br>
        Or
        <br>
        If you’re doing copy and paste through <strong>MSWord</strong>, try to copy and paste through <strong>Notepad</strong> or <strong>Wordpad</strong>. This will <strong>reset</strong> the formatting of your text.
      </small>
    </div>

    <br/>
  </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

<script>
function showAlert(){
  $("#myAlert").addClass("in")
}
</script>