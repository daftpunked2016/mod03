<section class="content-header">
	<h1>
		Dashboard
		<small>list</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Dashboard', array('site/dashboard')); ?>
		</li>
		<li class="active">List</li>
	</ol>
</section>

<section class="content">
	<div class="box box-solid">
		<div class="box-header with-border">
			<?php echo Chapter::model()->getChapter($user->chapter_id); ?>
			<div class="pull-right">
				<span class="fa fa-list"></span>
			</div>
		</div>
		<div class="box-body">
			<table class="table table-bordered table-hover">
				<thead>
					<?php foreach ($categories as $cat): ?>
						<th><?php echo $cat->category; ?></th>
					<?php endforeach; ?>
				</thead>
				<tr>
					<?php foreach ($categories as $cat): ?>
						<td>
							<strong><?php echo PeaReports::model()->getCount("CHAPTER", $user->chapter_id, $cat->cat_id); ?></strong>
						</td>
					<?php endforeach ?>
				</tr>
			</table>
		</div>
	</div>
</section>