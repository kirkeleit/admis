<table>
  <tr>
    <th>Kode</th>
    <th>Navn</th>
    <th>Antall</th>
  </tr>
<?php
  if (isset($Lagerplasser)) {
    foreach ($Lagerplasser as $Lagerplass) {
?>
  <tr>
    <td><?php echo $Lagerplass['Kode']; ?></td>
    <td><a href="<?php echo site_url(); ?>/materiell/lagerplass/<?php echo $Lagerplass['ID']; ?>"><?php echo $Lagerplass['Navn']; ?></a></td>
    <td><?php echo $Lagerplass['Antall']; ?> stk</td>
  </tr>
<?php
    }
  }
?>
</table>
