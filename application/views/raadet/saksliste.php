<h3 class="sub-header">Saksliste</h3>
<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Saksnummer</th>
        <th>Registrert</th>
        <th>Person</th>
        <th>Tittel</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Saksliste)) {
    foreach ($Saksliste as $Sak) {
?>
      <tr>
        <td><?php echo anchor('/raadet/sak/'.$Sak['SakID'],($Sak['SaksAr'] > '0' ? $Sak['SaksAr']."/".$Sak['SaksNummer'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/raadet/sak/'.$Sak['SakID'],date('d.m.Y',strtotime($Sak['DatoRegistrert']))); ?></td>
        <td><?php echo anchor('/raadet/sak/'.$Sak['SakID'],$Sak['PersonNavn']); ?></td>
        <td><?php echo anchor('/raadet/sak/'.$Sak['SakID'],$Sak['Tittel']); ?></a></td>
        <td><?php echo anchor('/raadet/sak/'.$Sak['SakID'],$Sak['Status']); ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="6">Ingen saker registrert.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
