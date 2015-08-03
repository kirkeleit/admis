<table>
  <tr>
    <th>Dato</th>
    <th>Referanse</th>
    <th>Prosjekt</th>
    <th>Ansvarlig</th>
    <th>Sum</th>
    <th>Status</th>
  </tr>
<?php
  if (isset($Ordrer)) {
    foreach ($Ordrer as $Ordre) {
?>
  <tr>
    <td><?php echo $Ordre['DatoRegistrert']; ?></td>
    <td><?php echo anchor('okonomi/innkjopsordre/'.$Ordre['OrdreID'],$Ordre['Referanse']); ?></td>
    <td><?php if (isset($Ordre['Prosjektnavn'])) { echo $Ordre['Prosjektnavn']; } else { echo "&nbsp;"; } ?></td>
    <td><?php if ($Ordre['PersonAnsvarligID'] > 0) { echo anchor('kontakter/person/'.$Ordre['PersonAnsvarligID'],$Ordre['PersonAnsvarligNavn']); } else { echo "&nbsp;"; } ?></td>
    <td style="text-align:right;">kr <?php echo number_format($Ordre['Sum'],2,',','.'); ?></td>
    <td style="text-align:right;"><?php echo $Ordre['Status']; ?></td>
  </tr>
<?php
    }
  } else {
?>
  <tr>
    <td colspan="5">Ingen innkjopsordrer er registrert.</td>
  </tr>
<?php
  }
?>
</table>
