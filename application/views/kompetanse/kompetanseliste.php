<h3 class="sub-header">Kompetanseliste <a href="<?php echo site_url('/kompetanse/nykompetanse'); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span></a></h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Type</th>
        <th>Navn</th>
        <th>Timer</th>
        <th>Gyldighet</th>
        <th>Antall</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Kompetanseliste)) {
    foreach ($Kompetanseliste as $Kompetanse) {
?>
      <tr>
        <td><?php echo anchor('/kompetanse/kompetanseinfo/'.$Kompetanse['KompetanseID'],$Kompetanse['TypeNavn']); ?></td>
        <td><?php echo anchor('/kompetanse/kompetanseinfo/'.$Kompetanse['KompetanseID'],$Kompetanse['Navn']); ?></td>
        <td><?php echo anchor('/kompetanse/kompetanseinfo/'.$Kompetanse['KompetanseID'],($Kompetanse['Timer'] > 0 ? $Kompetanse['Timer'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/kompetanse/kompetanseinfo/'.$Kompetanse['KompetanseID'],($Kompetanse['Gyldighet'] > 0 ? $Kompetanse['Gyldighet'].' måneder' : '&nbsp;')); ?></td>
        <td><?php echo anchor('/kompetanse/kompetanseinfo/'.$Kompetanse['KompetanseID'],$Kompetanse['Antall']); ?></td>
      </tr>
<?php
    }
  } else {
?>
  <tr>
    <td colspan="4">Ingen kompetanse er registrert.</td>
  </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
