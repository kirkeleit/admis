<table>
  <tr>
    <th>Type</th>
    <th>Dato</th>
    <th>Start/slutt</th>
    <th>Lokasjon</th>
    <th>&nbsp;</th>
  </tr>
<?php
  if (isset($Moter)) {
    foreach ($Moter as $Mote) {
?>
  <tr>
    <td><?php echo $Mote['Motetype']; ?></td>
    <td><?php echo date('d.m.Y',strtotime($Mote['DatoPlanlagtStart'])); ?></td>
    <td><?php echo date('H:i',strtotime($Mote['DatoPlanlagtStart']))." - ".date('H:i',strtotime($Mote['DatoPlanlagtSlutt'])); ?></td>
    <td><?php echo $Mote['Lokasjon']; ?></td>
    <td><a href="<?php echo site_url(); ?>/raadet/moteskjerm/?mid=<?php echo $Mote['MoteID']; ?>">Møteskjerm</a></td>
  </tr>
<?php
    }
  } else {
?>
  <tr>
    <td colspan="3">Ingen møter registrert.</td>
  </tr>
<?php
  }
?>
</table>
