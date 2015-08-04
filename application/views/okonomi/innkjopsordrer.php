<h3 class="sub-header">Innkjøpsordrer <?php echo anchor('/okonomi/nyinnkjopsordre','<span class="glyphicon glyphicon-plus"></span>'); ?></h3>
<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Dato</th>
        <th>Referanse</th>
        <th>Prosjekt</th>
        <th>Ansvarlig</th>
        <th>Sum</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Ordrer)) {
    foreach ($Ordrer as $Ordre) {
?>
      <tr>
        <td><?php echo anchor('/okonomi/innkjopsordre/'.$Ordre['OrdreID'],date("d.m.Y",strtotime($Ordre['DatoRegistrert']))); ?></td>
        <td><?php echo anchor('/okonomi/innkjopsordre/'.$Ordre['OrdreID'],$Ordre['Referanse']); ?></td>
        <td><?php echo anchor('/okonomi/innkjopsordre/'.$Ordre['OrdreID'],(isset($Ordre['Prosjektnavn']) ? $Ordre['Prosjektnavn'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/okonomi/innkjopsordre/'.$Ordre['OrdreID'],($Ordre['PersonAnsvarligID'] > 0 ? $Ordre['PersonAnsvarligNavn'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/okonomi/innkjopsordre/'.$Ordre['OrdreID'],'kr '.number_format($Ordre['Sum'],2,',','.')); ?></td>
        <td><?php echo anchor('/okonomi/innkjopsordre/'.$Ordre['OrdreID'],$Ordre['Status']); ?></td>
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
    </tbody>
  </table>
</div>
