<tr>
	<td>
		<?php
			$seatcode = Seats::model()->findByPk($data->seat_id);
			echo CHtml::encode($seatcode->code);
		?>
	</td>
	<td><?php echo CHtml::encode($data->ticket_no); ?></td>
	<td><?php echo CHtml::encode($data->first_name); ?>, <?php echo CHtml::encode($data->last_name); ?> </td>
	<td>
		<?php
			$ticket = Ticket::model()->find(array('condition' => 'ticket_no ='.$data->ticket_no));

			echo CHtml::encode($ticket->care_of);
		?>
	</td>
</tr>