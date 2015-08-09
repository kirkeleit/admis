<h3 class="sub-header">Utleggskvitteringer</h3>

<?php echo form_open(); ?>
<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>&nbsp;</th>
        <th>Dato</th>
        <th>Person</th>
        <th>Beskrivelse</th>
        <th>Konto</th>
        <th>Beløp</th>
        <th>Godkjent</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
<?php
  $Totalt = 0;
  if (isset($Utleggskvitteringer)) {
    foreach ($Utleggskvitteringer as $Utlegg) {
?>
      <tr>
        <td><input type="checkbox" name="UtleggUtbetalt[]" value="<?php echo $Utlegg['ID']; ?>" <?php if (!in_array('310',$UABruker['UAP'])) { echo "disabled"; } ?>/></td>
        <td><?php echo date("d.m.Y",strtotime($Utlegg['DatoUtlegg'])); ?></td>
        <td><?php echo $Utlegg['PersonNavn']; ?></td>
        <td><?php echo $Utlegg['Beskrivelse']; ?></td>
        <td><?php echo substr($Utlegg['Kontonummer'],0,4).".".substr($Utlegg['Kontonummer'],4,2).".".substr($Utlegg['Kontonummer'],6); ?></td>
        <td class="text-right">kr <?php echo number_format($Utlegg['Belop'],2,',',' '); ?></td>
        <td><span title="Godkjent av <?php echo $Utlegg['GodkjentAvNavn']; ?>" style="background-color: <?php if ($Utlegg['GodkjentStatus'] == 1) { echo "#90EE90"; } else { echo "#FF3030"; } ?>;"><?php echo date("d.m.Y",strtotime($Utlegg['DatoGodkjent'])); ?></span></td>
        <td><a href="http://admis.bomlork.no/index.php/okonomi/utleggskvittering/<?php echo $Utlegg['ID']; ?>" target="_new">Vis utlegg</a></td>
      </tr>
<?php
    }
?>
      <tr>
        <td colspan="5">&nbsp;</td>
        <td>kr <?php echo number_format($Totalt,2,',',' '); ?></td>
        <td colspan="2">&nbsp;</td>
      </tr>
<?php
  } else {
?>
      <tr>
        <td colspan="8">Ingen utlegg til utbetaling.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
<input type="submit" class="btn btn-primary"value="Registrer utleggene som utbetalt" <?php if (!in_array('310',$UABruker['UAP'])) { echo "disabled"; } ?>/>
<?php echo form_close(); ?>
