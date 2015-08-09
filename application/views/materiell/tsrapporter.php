<h3 class="sub-header">Tap og Skaderapporter <a href="<?php echo site_url('/materiell/nytsrapport'); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span></a></h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Dato</th>
        <th>Rapportert av</th>
        <th>UID</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Rapporter)) {
    foreach ($Rapporter as $Rapport) {
?>
      <tr>
        <td><?php echo anchor('/materiell/tsrapport/'.$Rapport['TapSkadeRapportID'],date('d.m.Y',strtotime($Rapport['DatoRegistrert']))); ?></td>
        <td><?php echo anchor('/materiell/tsrapport/'.$Rapport['TapSkadeRapportID'],$Rapport['PersonRapportertNavn']); ?></td>
        <td><?php echo anchor('/materiell/tsrapport/'.$Rapport['TapSkadeRapportID'],$Rapport['UtstyrNavn']); ?></td>
        <td><?php echo anchor('/materiell/tsrapport/'.$Rapport['TapSkadeRapportID'],$Rapport['Status']); ?></td>
      </tr>
<?php
    }
  }
?>
    </tbody>
  </table>
</div>
