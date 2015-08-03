<table>
  <tr>
    <th>ID</th>
    <th>Type</th>
    <td>Sted</td>
    <td>SARnr</td>
    <td>Start</td>
    <th>&nbsp;</th>
  </tr>
<?php
  if (isset($Aksjoner)) {
    foreach ($Aksjoner as $Aksjon) {
?>
  <tr>
    <td><?php echo $Aksjon['ID']; ?></td>
    <td><?php echo $Aksjon['Type']; ?></td>
    <td><?php echo $Aksjon['Sted']; ?></td>
    <td><?php echo $Aksjon['SARnr']; ?></td>
    <td><?php echo $Aksjon['DatoStart']; ?></td>
    <td><?php echo anchor('aktiviteter/aksjon/'.$Aksjon['ID'],"Vis"); ?></td>
  </tr>
<?php
    }
  } else {
?>
  <tr>
    <td colspan="3">Ingen aksjoner registrert.</td>
  </tr>
<?php
  }
?>
</table>
