<tr>
	<td><strong><?php echo $data['rank']; ?></strong></a></td>
	<td>
    <?php echo $data['chapter_name']; ?> <em><small><?php echo $data['region']; ?></small></em>
  	</td>
  	<td><strong><?php echo $data['score']; ?></strong></td>
  	<td><strong data-toggle="tooltip" data-placement="top" title="<?php echo "RAW SCORE: {$data['score']}"; ?>"><?php echo "{$data['percentage']}%"; ?></strong></td>
</tr>
