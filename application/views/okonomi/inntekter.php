<h3 class="sub-header">Inntekter <a href="<?php echo site_url('/okonomi/nyinntekt'); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span></a></h3>
<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Dato</th>
        <th>Aktivitet</th>
        <th>Konto</th>
        <th>Medlem</th>
        <th>Beskrivelse</th>
        <th>Beløp</th>
      </tr>
    </thead>
    <tbody>
<?php
  $Totalt = 0;
  if (isset($Inntekter)) {
    foreach ($Inntekter as $Inntekt) {
?>
      <tr>
        <td><?php echo $Inntekt['DatoBokfort']; ?></td>
        <td><span title="<?php echo $Inntekt['Aktivitet']; ?>"><?php echo $Inntekt['AktivitetID']; ?></span></td>
        <td><span title="<?php echo $Inntekt['Konto']; ?>"><?php echo $Inntekt['KontoID']; ?></span></td>
<?php if ($Inntekt['PersonID'] > 0) { ?>
        <td><a href="<?php echo site_url(); ?>/kontakter/person/<?php echo $Inntekt['PersonID']; ?>" title="<?php echo $Inntekt['Person']; ?>"><?php echo $Inntekt['PersonInitialer']; ?></a></td>
<?php } else { ?>
        <td>&nbsp;</td>
<?php } ?>
        <td><a href="<?php echo site_url(); ?>/okonomi/inntekt/<?php echo $Inntekt['InntektID']; ?>"><?php echo $Inntekt['Beskrivelse']; ?></a></td>
        <td style="text-align: right;"><?php echo "kr ".number_format($Inntekt['Belop'],2,',','.'); ?></td>
      </tr>
<?php
      $Totalt = $Totalt + $Inntekt['Belop'];
    }
?>
      <tr>
        <td colspan="5">&nbsp;</td>
        <td style="text-align: right;"><b><?php echo "kr ".number_format($Totalt,2,',','.'); ?></b></td>
      </tr>
<?php
  } else {
?>
      <tr>
        <td colspan="6">Ingen inntekter i år!</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
