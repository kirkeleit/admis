<h3 class="sub-header">Fakturaer <a href="<?php echo site_url('/okonomi/nyfaktura'); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span></a></h3>
<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>ID</th>
        <th>Dato</th>
        <th>Mottaker</th>
        <th>Referanse</th>
        <th>Ansvarlig</th>
        <th>Sum</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Fakturaer)) {
    $TotalSum = 0;
    foreach ($Fakturaer as $Faktura) {
      $TotalSum = $TotalSum + $Faktura['FakturaSum'];
?>
      <tr>
        <td><?php echo anchor('/okonomi/faktura/'.$Faktura['FakturaID'],$Faktura['FakturaID']); ?></a></td>
        <td><?php echo anchor('/okonomi/faktura/'.$Faktura['FakturaID'],date("d.m.Y",strtotime($Faktura['DatoFakturadato']))); ?></td>
        <td><?php echo anchor('/okonomi/faktura/'.$Faktura['FakturaID'],($Faktura['OrganisasjonID'] > 0 ? $Faktura['OrganisasjonNavn'] : $Faktura['PersonNavn'])); ?></td>
        <td><?php echo anchor('/okonomi/faktura/'.$Faktura['FakturaID'],$Faktura['Referanse']); ?></td>
        <td><?php echo anchor('/okonomi/faktura/'.$Faktura['FakturaID'],$Faktura['PersonAnsvarligNavn']); ?></td>
        <td><?php echo anchor('/okonomi/faktura/'.$Faktura['FakturaID'],"kr ".number_format($Faktura['FakturaSum'],2,',','.')); ?></td>
        <td><?php echo anchor('/okonomi/faktura/'.$Faktura['FakturaID'],$Faktura['Status']); ?></td>
      </tr>
<?php
    }
?>
      <tr>
        <td colspan="5">&nbsp;</td>
        <td><?php echo 'kr '.number_format($TotalSum,2,',','.'); ?></td>
        <td>&nbsp;</td>
      </tr>
<?php
  } else {
?>
      <tr>
        <td colspan="7">Ingen fakturaer i utvalg.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
