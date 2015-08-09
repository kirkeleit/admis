<h3 class="sub-header">Prosjekter <a href="<?php echo site_url('/prosjekter/nyttprosjekt'); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span></a></h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>År</th>
        <th>Prosjektnavn</th>
        <th>Faggruppe</th>
        <th>Prosjektleder</th>
        <th>Budsjettramme</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Prosjekter)) {
    $TotalBudsjettramme = 0;
    foreach ($Prosjekter as $Prosjekt) {
      $TotalBudsjettramme = $TotalBudsjettramme + $Prosjekt['Budsjettramme'];
?>
      <tr>
        <td><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],$Prosjekt['ProsjektAr']); ?></td>
        <td><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],$Prosjekt['Prosjektnavn']); ?></td>
        <td><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],($Prosjekt['FaggruppeNavn'] != '' ? $Prosjekt['FaggruppeNavn'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],($Prosjekt['PersonProsjektlederNavn'] != '' ? $Prosjekt['PersonProsjektlederNavn'] : '&nbsp;')); ?></td>
        <td class="text-right"><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],'kr '.number_format($Prosjekt['Budsjettramme'], 0, ',', '.')); ?></td>
        <td><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],$Prosjekt['Status']); ?></td>
      </tr>
<?php
    }
?>
      <tr>
        <td colspan="4">&nbsp;</td>
        <td class="text-right"><?php echo 'kr '.number_format($TotalBudsjettramme,0,',','.'); ?></td>
        <td>&nbsp;</td>
      </tr>
<?php
  } else {
?>
      <tr>
        <td colspan="7">Ingen prosjekter i utvalg.</td>
      </tr>
<?php } ?>
    </tbody>
  </table>
</div>
