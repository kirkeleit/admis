<h3 class="sub-header">Utstyrsgrupper <a href="<?php echo site_url('/materiell/nygruppe'); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span></a></h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Navn</th>
        <th>Beskrivelse</th>
        <th>Antall</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Grupper)) {
    foreach ($Grupper as $Gruppe) {
?>
      <tr>
        <td><?php echo anchor('/materiell/gruppe/'.$Gruppe['GruppeID'],$Gruppe['Navn']); ?></td>
        <td><?php echo anchor('/materiell/gruppe/'.$Gruppe['GruppeID'],($Gruppe['Beskrivelse'] != '' ? $Gruppe['Beskrivelse'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/materiell/gruppe/'.$Gruppe['GruppeID'],$Gruppe['Antall'].' stk'); ?></td>
      </tr>
<?php
    }
  }
?>
    </tbody>
  </table>
</div>
