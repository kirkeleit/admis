<h3>Grupper</h3>
<table>
  <tr>
    <th>Navn</th>
    <th>Antall</th>
  </tr>
<?php
  if (isset($Grupper)) {
    foreach ($Grupper as $Gruppe) {
?>
  <tr>
    <td><a href="<?php echo site_url(); ?>/kontakter/gruppe/<?php echo $Gruppe['ID']; ?>"><?php echo $Gruppe['Navn']; ?></a></td>
    <td><?php echo $Gruppe['Antall']; ?></td>
  </tr>
<?php
    }
  }
?>
</table>
