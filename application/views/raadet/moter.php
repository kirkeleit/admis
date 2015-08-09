<h3 class="sub-header">Møter</h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Type</th>
        <th>Dato</th>
        <th>Start/slutt</th>
        <th>Lokasjon</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Moter)) {
    foreach ($Moter as $Mote) {
?>
      <tr>
        <td><?php echo $Mote['Motetype']; ?></td>
        <td><?php echo date('d.m.Y',strtotime($Mote['DatoPlanlagtStart'])); ?></td>
        <td><?php echo date('H:i',strtotime($Mote['DatoPlanlagtStart']))." - ".date('H:i',strtotime($Mote['DatoPlanlagtSlutt'])); ?></td>
        <td><?php echo $Mote['Lokasjon']; ?></td>
        <td><a href="<?php echo site_url(); ?>/raadet/moteskjerm/?mid=<?php echo $Mote['MoteID']; ?>">Møteskjerm</a></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="5">Ingen møter i utvalg.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
