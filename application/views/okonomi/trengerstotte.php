<h3 class="sub-header">Prosjekter som trenger støtte</h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>År</th>
        <th>Prosjektnavn</th>
        <th>Faggruppe</th>
        <th>Prosjektleder</th>
        <th>Budsjettramme</th>
        <th>Støttebehov</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  $TotalBudsjettramme = 0;
  $TotalStottebehov = 0;
  if (isset($Prosjekter)) {
    foreach ($Prosjekter as $Prosjekt) {
      if (($Prosjekt['Budsjettramme']-$Prosjekt['Inntekter']) > 0) {
        $TotalBudsjettramme = $TotalBudsjettramme + $Prosjekt['Budsjettramme'];
        $TotalStottebehov = $TotalStottebehov + ($Prosjekt['Budsjettramme']-$Prosjekt['Inntekter']);
?>
      <tr>
        <td><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],$Prosjekt['ProsjektAr']); ?></td>
        <td><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],$Prosjekt['Prosjektnavn']); ?></td>
        <td><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],($Prosjekt['FaggruppeNavn'] != '' ? $Prosjekt['FaggruppeNavn'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],($Prosjekt['PersonProsjektlederNavn'] != '' ? $Prosjekt['PersonProsjektlederNavn'] : '&nbsp;')); ?></td>
        <td class="text-right"><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],'kr '.number_format($Prosjekt['Budsjettramme'], 0, ',', '.')); ?></td>
        <td class="text-right"><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],'kr '.number_format($Prosjekt['Budsjettramme']-$Prosjekt['Inntekter'], 0, ',', '.')); ?></td>
        <td><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],$Prosjekt['Status']); ?></td>
      </tr>
<?php
      }
    }
  } else {
?>
      <tr>
        <td colspan="7">Ingen prosjekter i utvalg.</td>
      </tr>
<?php
  }
?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4">&nbsp;</td>
        <td class="text-right"><?php echo 'kr '.number_format($TotalBudsjettramme, 0, ',', '.'); ?></td>
        <td class="text-right"><?php echo 'kr '.number_format($TotalStottebehov, 0, ',', '.'); ?></td>
        <td>&nbsp;</td>
      </tr>
    </tfoot>
  </table>
</div>
