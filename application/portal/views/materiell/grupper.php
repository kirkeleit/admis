<a href="<?php echo site_url(); ?>/materiell/nygruppe">Ny gruppe</a><br />
<br />
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
    <td><a href="<?php echo site_url(); ?>/materiell/gruppe/<?php echo $Gruppe['ID']; ?>"><?php echo $Gruppe['Navn']; ?></a></td>
    <td><?php echo $Gruppe['Antall']; ?> stk</td>
  </tr>
<?php
    }
  }
?>
</table>
