<section class="content-header">
	<h1>Manage Members</h1>
</section>
<div class="row">
	<section class="content">
		<?php  $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$memberDP,
			'itemView'=>'_view_members',
			'template' => "{sorter}<table id=\"example1\" class=\"table table-bordered table-hover\">
			<thead class='panel-heading'>
			<th>Picture</th>
			<th>Email Address</th>
			<th>Name</th>
			<th>Position</th>
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