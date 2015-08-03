<table>
  <tr>
    <th>År</th>
    <th>Prosjektnavn</th>
    <th>Faggruppe</th>
    <th>Prosjektleder</th>
    <th>Budsjettramme</th>
    <th>Status</th>
  </tr>
<?php
  if (isset($Prosjekter)) {
    foreach ($Prosjekter as $Prosjekt) {
?>
  <tr>
    <td><?php echo $Prosjekt['ProsjektAr']; ?></td>
    <td><a href="<?php echo site_url(); ?>/prosjekter/prosjekt/<?php echo $Prosjekt['ProsjektID']; ?>"><?php echo $Prosjekt['Prosjektnavn']; ?></a></td>
    <td><?php echo $Prosjekt['FaggruppeNavn']; ?></td>
    <td><?php echo $Prosjekt['PersonProsjektlederNavn']; ?></td>
    <td>kr <?php echo number_format($Prosjekt['Budsjettramme'], 0, ',', '.'); ?></td>
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
