<tr>
	<td>
		<?php
			$seatcode = Seats::model()->findByPk($data->seat_id);
			echo CHtml::encode($seatcode->code);
		?>
	</td>
	<td><?php echo CHtml::encode($data->ticket_no); ?></td>
	<td><?php echo CHtml::encode($data->first_name); ?>, <?php echo CHtml::encode($data->last_name); ?> </td>
	<td><?php echo CHtml::encode($data->contact_no); ?></td>
	<td><?php echo CHtml::encode($data->email_address); ?></td>
	<td><?php echo CHtml::encode($data->date_reserved); ?></td>
	<td>
		<?php
			$ticket = Ticket::model()->find(array('condition' => 'ticket_no ='.$data->ticket_no));

			echo CHtml::encode($ticket->care_of);
		?>
	</td>
	<td style="width:200px">		
		<div class="pull-left">
			<?php echo CHtml::link('<span class="btn-sm btn-success">Approve</span>', array('/admin/default/approve', 'id' => $data->seat_id), array('class' => 'btn', 'title' => 'Approve Reservation', 'confirm'=>'Are you sure you want to approve this reservation?')); ?>
		</div>
		<div class="pull-right">
			<?php echo CHtml::link('<span class="btn-sm btn-danger">Delete</span>', array('/admin/default/reject', 'id' => $data->seat_id), array('class' => 'btn', 'title' => 'Edit', 'confirm'=>'Are you sure you want to reject this reservation?')); ?>
		</div>
		<br clear="all" />
	</td>
</tr>