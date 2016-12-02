<?php if($seal_filter == null || $seal_filter === $data['seal'] ||  $seal_filter === "*"): ?>
  <tr <?php 
      if($data['rank'] == 999) { 
        echo "class='danger'"; 
      } else {
        switch ($data['seal']){
          case "Bronze":
            echo "style='background-color:#CD7F32; color:#FFF'";
            break;
          case "Silver":
            echo "style='background-color:#C0C0C0'";
            break;
          case "Gold":
            echo "style='background-color:#FFD700; color:#000'";
            break;
          case "Platinum":
            echo "style='background-color:#E5E4E2; color:#5D5F64'";
            break;
        }
      }
  ?> 
  >
  	<td><strong><?php echo $data['rank']; ?></strong></a></td>
  	<td>
      <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/default/listScoring?chapter_id=<?php echo $data['chapter_id']; ?>">
       <b><?php ?><?php echo $data['chapter']; ?> </b> <small><i><?php echo $data['region']; ?></i></small>
      </a>
    </td>
    <td><?php echo $data['efficient_count']; ?></td>
    <td><?php echo $data['seal']; ?></td>
    <td><b><em><?php echo $data['rating']; ?>%</em></b></td>
    <td><b><?php echo $data['raw']; ?></b></td>
  </tr>
<?php endif; ?>
