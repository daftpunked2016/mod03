<section class="content">
	<form method="post" action="<?php echo Yii::app()->request->baseUrl; ?>/index.php/training/default/createtrainer/type/<?php echo $type; ?>">
		<div class="form-group has-feedback">
		  <?php $regions = AreaRegion::model()->findAll(array('select'=>'area_no', 'distinct'=>true)); ?>
		  <select id="area_no" name="Account[area_no]" class="form-control" required >
		    <option disabled selected >Select Area No.</option>
		    <?php 
		      foreach($regions as $region)
		        echo "<option value=".$region->area_no.">".$region->area_no."</option>";
		    ?>
		  </select>
		</div>
		<div class="form-group has-feedback">
		  <select id="region_id" name="region" class="form-control" required >
		    <option value=""> -- <option>
		  </select>
		</div>
		<div class="form-group has-feedback">
		  <select id="chapter_id" name="User[chapter_id]" class="form-control" data-type="<?php echo $type; ?>" required >
		    <option value=""> -- <option>
		  </select>
		</div>
		<div class="form-group has-feedback">
		  <select id="member" name="member" class="form-control" required >
		    <option value=""> -- <option>
		  </select>
		</div>
		<input type="submit" value="Assign" class="btn btn-primary btn-flat">
	</form>
</section>