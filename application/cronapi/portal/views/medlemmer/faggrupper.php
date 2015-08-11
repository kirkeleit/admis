<table>
  <tr>
    <th>ID</th>
    <th>Navn</th>
    <th>Leder</th>
    <th>&nbsp;</th>
  </tr>
<?php
  if (isset($Faggrupper)) {
    foreach ($Faggrupper as $Faggruppe) {
?>
  <tr>
    <td><?php echo $Faggruppe['ID']; ?></td>
    <td><?php echo $Faggruppe['Navn']; ?></td>
    <td><?php echo $Faggruppe['Leder']['Fornavn']; ?></td>
    <td><?php echo anchor('medlemmer/faggruppe/'.$Faggruppe['ID'],"Vis"); ?></td>
  </tr>
<?php
    }
  } else {
?>
  <tr>
    <td colspan="3">Ingen faggrupper er registrert.</td>
  </tr>
<?php
  }
?>
</table>
