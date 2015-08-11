<h3 class="sub-header">Inntekter <a href="<?php echo site_url('/okonomi/nyinntekt'); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span></a></h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Dato</th>
        <th>Aktivitet</th>
        <th>Konto</th>
        <th>Person</th>
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
        <td><?php echo anchor('/okonomi/inntekt/'.$Inntekt['InntektID'],date('d.m.Y',strtotime($Inntekt['DatoBokfort']))); ?></td>
        <td><?php echo anchor('/okonomi/inntekt/'.$Inntekt['InntektID'],($Inntekt['AktivitetID'] != '' ? $Inntekt['AktivitetID'] : '&nbsp;'),'title="'.$Inntekt['AktivitetNavn'].'"'); ?></td>
        <td><?php echo anchor('/okonomi/inntekt/'.$Inntekt['InntektID'],($Inntekt['KontoID'] > 0 ? $Inntekt['KontoID'] : '&nbsp;'),'title="'.$Inntekt['KontoNavn'].'"'); ?></td>
        <td><?php echo ($Inntekt['PersonID'] > 0 ? anchor('/okonomi/inntekt/'.$Inntekt['InntektID'],$Inntekt['PersonInitialer'],'title="'.$Inntekt['PersonNavn'].'"') : ''); ?></td>
        <td><?php echo anchor('/okonomi/inntekt/'.$Inntekt['InntektID'],$Inntekt['Beskrivelse']); ?></a></td>
        <td class="text-right"><?php echo anchor('/okonomi/inntekt/'.$Inntekt['InntektID'],'kr '.number_format($Inntekt['Belop'],2,',','.')); ?></td>
      </tr>
<?php
      $Totalt = $Totalt + $Inntekt['Belop'];
    }
?>
      <tr>
        <td colspan="5">&nbsp;</td>
        <td class="text-right"><?php echo "kr ".number_format($Totalt,2,',','.'); ?></td>
      </tr>
<?php
  } else {
?>
      <tr>
        <td colspan="6">Ingen inntekter i utvalg.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
