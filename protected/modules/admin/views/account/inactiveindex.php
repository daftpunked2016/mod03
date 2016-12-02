<section class="content-header">
	<?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
		if($key  === 'success')
			{
			echo "<div class='alert alert-success alert-dismissible' role='alert'>
			<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
			$message.'</div>';
			}
		else
			{
			echo "<div class='alert alert-danger alert-dismissible' role='alert'>
			<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
			$message.'</div>';
			}
		}
	?>
	<h1>Inactive Accounts</h1>
</section>
<div class="row">
	<section class="content">
		<?php  $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$inactiveDP,
			'itemView'=>'_view_users_inactive',
			'template' => "{sorter}<table id=\"example1\" class=\"table table-bordered table-hover\">
			<thead class='panel-heading'>
			<th>Picture</th>
			<th>Email Address</th>
			<th>Name</th>
			<th>Action</th>
			</thead>
			<tbody>
			{items}
			</tbody>
			</table>
			{pager}",
			'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
		));  ?>
	</section>
</div>