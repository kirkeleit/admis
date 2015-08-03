<table>
  <tr>
    <th>Saksnummer</th>
    <th>Registrert</th>
    <th>Person</th>
    <th>Tittel</th>
    <th>Status</th>
  </tr>
<?php
  if (isset($Saksliste)) {
    foreach ($Saksliste as $Sak) {
?>
  <tr>
    <td><?php echo anchor('/raadet/sak/'.$Sak['SakID'],($Sak['SaksAr'] > '0' ? $Sak['SaksAr']."/".$Sak['SaksNummer'] : '&nbsp;')); ?></td>
    <td><?php echo anchor('/raadet/sak/'.$Sak['SakID'],date('d.m.Y',strtotime($Sak['DatoRegistrert']))); ?></td>
    <td><?php echo anchor('/raadet/sak/'.$Sak['SakID'],$Sak['PersonNavn']); ?></td>
    <td><?php echo anchor('/raadet/sak/'.$Sak['SakID'],$Sak['Tittel']); ?></a></td>
    <td><?php echo anchor('/raadet/sak/'.$Sak['SakID'],$Sak['Status']); ?></td>
  </tr>
<?php
    }
  } else {
?>
  <tr>
    <td colspan="6">Ingen saker registrert.</td>
  </tr>
<?php
  }
?>
</table>
