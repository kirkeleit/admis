<table>
  <tr>
    <th>ID</th>
    <th>Dato</th>
    <th>Navn</th>
    <th>Ansvarlig</th>
    <th>Sum</th>
    <th>Status</th>
  </tr>
<?php
  if (isset($Ordrer)) {
    foreach ($Ordrer as $Ordre) {
?>
  <tr>
    <td><?php echo $Ordre['ID']; ?></td>
    <td><?php echo $Ordre['DatoRegistrert']; ?></td>
    <td><?php echo anchor('okonomi/innkjopsordre/'.$Ordre['ID'],$Ordre['Navn']); ?></td>
    <td><?php echo anchor('kontakter/person/'.$Ordre['PersonID'],$Ordre['PersonNavn']); ?></td>
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
