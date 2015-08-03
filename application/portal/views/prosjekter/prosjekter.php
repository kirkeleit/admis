<table>
  <tr>
    <th>År</th>
    <th>Navn</th>
    <th>Faggruppe</th>
    <th>Ansvarlig</th>
    <th>Kostnad</th>
    <th>Oppdatert</th>
    <th>Status</th>
  </tr>
<?php
  if (isset($Prosjekter)) {
    foreach ($Prosjekter as $Prosjekt) {
?>
  <tr>
    <td><?php echo $Prosjekt['ProsjektAr']; ?></td>
    <td><a href="<?php echo site_url(); ?>/prosjekter/prosjekt/<?php echo $Prosjekt['ID']; ?>"><?php echo $Prosjekt['Navn']; ?></a></td>
    <td><?php echo $Prosjekt['Faggruppe']; ?></td>
    <td><?php echo $Prosjekt['Ansvarlig']; ?></td>
    <td>kr <?php echo number_format($Prosjekt['KostnadTotal'], 0, ',', '.'); ?></td>
    <td><?php echo $Prosjekt['DatoOppdatert']; ?></td>
    <td><?php echo $Prosjekt['Status']; ?></td>
  </tr>
<?php
    }
  } else {
?>
  <tr>
    <td colspan="7">Ingen prosjekter er registrert.</td>
  </tr>
<?php } ?>
</table>
