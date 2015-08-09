<h3 class="sub-header">Innkjøpsordrer <a href="<?php echo site_url('/okonomi/nyinnkjopsordre'); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span></a></h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Dato</th>
        <th>Referanse</th>
        <th>Ansvarlig</th>
        <th>Ordresum</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Ordrer)) {
    $TotalSum = 0;
    foreach ($Ordrer as $Ordre) {
      $TotalSum = $TotalSum + $Ordre['OrdreSum'];
?>
      <tr>
        <td><?php echo anchor('/okonomi/innkjopsordre/'.$Ordre['OrdreID'],date("d.m.Y",strtotime($Ordre['DatoRegistrert']))); ?></td>
        <td><?php echo anchor('/okonomi/innkjopsordre/'.$Ordre['OrdreID'],$Ordre['Referanse']); ?></td>
        <td><?php echo anchor('/okonomi/innkjopsordre/'.$Ordre['OrdreID'],($Ordre['PersonAnsvarligID'] > 0 ? $Ordre['PersonAnsvarligNavn'] : '&nbsp;')); ?></td>
        <td class="text-right"><?php echo anchor('/okonomi/innkjopsordre/'.$Ordre['OrdreID'],'kr '.number_format($Ordre['OrdreSum'],2,',','.')); ?></td>
        <td><?php echo anchor('/okonomi/innkjopsordre/'.$Ordre['OrdreID'],$Ordre['Status']); ?></td>
      </tr>
<?php
    }
?>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td class="text-right"><?php echo 'kr '.number_format($TotalSum,2,',','.'); ?></td>
        <td>&nbsp;</td>
      </tr>
<?php
  } else {
?>
      <tr>
        <td colspan="5">Ingen innkjopsordrer i utvalg.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
