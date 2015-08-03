<table>
  <tr>
    <th>ID</th>
    <th>Dato</th>
    <th>Status</th>
  </tr>
<?php
  if (isset($Rapporter)) {
    foreach ($Rapporter as $Rapport) {
?>
  <tr>
    <td><a href="<?php echo site_url(); ?>/materiell/tsrapport/<?php echo $Rapport['ID']; ?>"><?php echo $Rapport['ID']; ?></a></td>
    <td><?php echo $Rapport['DatoRegistrert']; ?></td>
    <td><?php echo $Rapport['Status']; ?></td>
  </tr>
<?php
    }
  }
?>
</table>
