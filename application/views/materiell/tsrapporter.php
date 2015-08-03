<table>
  <tr>
    <th>ID</th>
    <th>Dato</th>
    <th>Rapportert av</th>
    <th>UID</th>
    <th>Status</th>
  </tr>
<?php
  if (isset($Rapporter)) {
    foreach ($Rapporter as $Rapport) {
?>
  <tr>
    <td><a href="<?php echo site_url(); ?>/materiell/tsrapport/<?php echo $Rapport['TapSkadeRapportID']; ?>"><?php echo $Rapport['TapSkadeRapportID']; ?></a></td>
    <td><?php echo date('d.m.Y',strtotime($Rapport['DatoRegistrert'])); ?></td>
    <td><?php echo $Rapport['PersonRapportertNavn']; ?></td>
    <td><?php echo $Rapport['UtstyrNavn']; ?></td>
    <td><?php echo $Rapport['Status']; ?></td>
  </tr>
<?php
    }
  }
?>
</table>
