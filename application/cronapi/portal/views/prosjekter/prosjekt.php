<?php
  $Redigerbar1 = 0;
  $Redigerbar2 = 0;
  if (($Prosjekt['ID'] == 0) and (in_array('502',$UABruker['UAP']))) {
    $Redigerbar1 = 1;
    $Redigerbar2 = 1;
  } elseif (($Prosjekt['StatusID'] < 2) and (($UABruker['ID'] == $Prosjekt['AnsvarligID']) or (in_array('503',$UABruker['UAP']))))  {
    $Redigerbar1 = 1;
  }
  if (($UABruker['ID'] == $Prosjekt['AnsvarligID']) or (in_array('503',$UABruker['UAP'])))  {
    $Redigerbar2 = 1;
  }
?>
<?php echo form_open('prosjekter/prosjekt'); ?>
<input type="hidden" name="ID" id="ID" value="<?php echo set_value('ID',$Prosjekt['ID']); ?>" />
<fieldset>
  <legend>Prosjekt</legend>

  <p>
    <label for="ProsjektAr">Prosjektår:</label>
    <input type="number" name="ProsjektAr" id="ProsjektAr" value="<?php echo set_value('ProsjektAr',$Prosjekt['ProsjektAr']); ?>"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?> required />
  </p>

  <p>
    <label for="FaggruppeID">Faggruppe:</label>
    <select name="FaggruppeID" id="FaggruppeID"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?>>
      <option value="0" <?php echo set_select('FaggruppeID',0,($Prosjekt['FaggruppeID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Faggrupper)) {
    foreach ($Faggrupper as $Faggruppe) {
?>
      <option value="<?php echo $Faggruppe['ID']; ?>" <?php echo set_select('FaggruppeID',$Faggruppe['ID'],($Prosjekt['FaggruppeID'] == $Faggruppe['ID']) ? TRUE : FALSE); ?>><?php echo $Faggruppe['Navn']; ?></option>
<?php
    }
  }
?>
    </select>
  </p>

  <p>
    <label for="AnsvarligID">Ansvarlig:</label>
    <select name="AnsvarligID" id="AnsvarligID"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?>>
      <option value="0" <?php echo set_select('AnsvarligID',0,($Prosjekt['AnsvarligID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Medlemmer)) {
    foreach ($Medlemmer as $Medlem) {
?>
      <option value="<?php echo $Medlem['ID']; ?>" <?php echo set_select('AnsvarligID',$Medlem['ID'],($Prosjekt['AnsvarligID'] == $Medlem['ID']) ? TRUE : FALSE); ?>><?php echo $Medlem['Fornavn']." ".$Medlem['Etternavn']; ?></option>
<?php
    }
  }
?>
    </select>
  </p>

  <p>
    <label for="Navn">Navn:</label>
    <input type="text" name="Navn" id="Navn" value="<?php echo set_value('Navn',$Prosjekt['Navn']); ?>"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?> required />
  </p>

  <p>
    <label for="Beskrivelse">Beskrivelse:</label>
    <textarea name="Beskrivelse" id="Beskrivelse" rows="6" cols="46"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?> required><?php echo set_value('Beskrivelse',$Prosjekt['Beskrivelse']); ?></textarea>
  </p>

  <p>
    <label for="Arbeidstimer">Arbeidstimer:</label>
    <input type="number" name="Arbeidstimer" value="<?php echo set_value('Arbeidstimer',$Prosjekt['Arbeidstimer']); ?>"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?> />
  </p>

  <p>
    <label for="KostnadTotal">Kostnad:</label>
    <input type="number" name="KostnadTotal" id="KostnadTotal" value="<?php echo set_value('KostnadTotal',$Prosjekt['KostnadTotal']); ?>" step="1000"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?> />
  </p>

<?php if (isset($Prosjekt['Ordre'])) { ?>
  <p>
    <label>Innkjøpsordre:</label>
    <span>kr <?php echo $Prosjekt['Ordre']['Sum']; ?></span>&nbsp;<a href="<?php echo site_url(); ?>/okonomi/innkjopsordre/<?php echo $Prosjekt['Ordre']['ID']; ?>"><img src="/grafikk/icons/zoom.png" /></a>
  </p>
<?php } ?>

  <p>
    <label for="Status">Status:</label>
    <span><?php echo $Prosjekt['Status']; ?></span>
  </p>

<?php if ($Prosjekt['StatusID'] < 5) { ?>
  <p class="handlinger">
    <label>&nbsp;</label>
<?php if ($Prosjekt['StatusID'] == 0) { ?>
    <input type="submit" id="LagreProsjekt" value="Lagre"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
<?php } elseif ($Prosjekt['StatusID'] == 1) { ?>
    <input type="submit" id="LagreProsjekt" value="Lagre"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
    <input type="button" id="SlettProsjekt" value="Slett"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
    <input type="button" value="Send til godkjenning" onclick="javascript:document.location.href='<?php echo site_url(); ?>/prosjekter/settprosjektstatus/?pid=<?php echo $Prosjekt['ID']; ?>&status=2';"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
<?php } elseif ($Prosjekt['StatusID'] == 2) { ?>
    <input type="button" value="Godkjenn" onclick="javascript:document.location.href='<?php echo site_url(); ?>/prosjekter/settprosjektstatus/?pid=<?php echo $Prosjekt['ID']; ?>&status=3';"<?php if (!in_array('504',$UABruker['UAP'])) { echo " disabled"; } ?> />
    <input type="button" value="Avvis" onclick="javascript:document.location.href='<?php echo site_url(); ?>/prosjekter/settprosjektstatus/?pid=<?php echo $Prosjekt['ID']; ?>&status=1';"<?php if (!in_array('504',$UABruker['UAP'])) { echo " disabled"; } ?> />
<?php } elseif ($Prosjekt['StatusID'] == 3) { ?>
    <input type="button" value="Tilbake til planlegging" onclick="javascript:document.location.href='<?php echo site_url(); ?>/prosjekter/settprosjektstatus/?pid=<?php echo $Prosjekt['ID']; ?>&status=1';"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
    <input type="button" value="Påbegynt" onclick="javascript:document.location.href='<?php echo site_url(); ?>/prosjekter/settprosjektstatus/?pid=<?php echo $Prosjekt['ID']; ?>&status=4';"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
<?php } elseif ($Prosjekt['StatusID'] == 4) { ?>
    <input type="button" value="Tilbake til planlegging" onclick="javascript:document.location.href='<?php echo site_url(); ?>/prosjekter/settprosjektstatus/?pid=<?php echo $Prosjekt['ID']; ?>&status=1';"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
    <input type="button" value="Fullført" onclick="javascript:document.location.href='<?php echo site_url(); ?>/prosjekter/settprosjektstatus/?pid=<?php echo $Prosjekt['ID']; ?>&status=5';"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
<?php } ?>
  </p>
<?php } ?>
<script>
  $('#SlettProsjekt').click(function(){
    var r = confirm("Er du sikker?");
    if (r) {
      document.location.href='<?php echo site_url(); ?>/prosjekter/slettprosjekt/<?php echo $Prosjekt['ID']; ?>';
    }
  });
</script>
</fieldset>
<?php echo form_close(); ?>

<?php if (isset($Utgifter)) { ?>
<fieldset>
  <legend>Utgifter</legend>

  <table>
    <tr>
      <th>Dato</th>
      <th>Initialer</th>
      <th>Beskrivelse</th>
      <th>Beløp</th>
    </tr>
<?php
    $TotaleUtgifter = 0;
    foreach ($Utgifter as $Utgift) {
?>
    <tr>
      <td><?php echo $Utgift['DatoBokfort']; ?></td>
      <td><?php echo $Utgift['PersonInitialer']; ?></td>
      <td><?php echo $Utgift['Beskrivelse']; ?></td>
      <td style="text-align: right;">kr <?php echo number_format($Utgift['Belop'],2,',','.'); ?></td>
    </tr>
<?php
      $TotaleUtgifter = $TotaleUtgifter + $Utgift['Belop'];
    }
?>
    <tr>
      <td colspan="3"><b>Totalt:</b></td>
      <td style="text-align: right;"><b>kr <?php echo number_format($TotaleUtgifter,2,',','.'); ?></b></td>
    </tr>
  </table>
</fieldset>
<?php } ?>

<?php if ($Prosjekt['ID'] > 0) { ?>
<?php echo form_open('prosjekter/nykommentar'); ?>
<input type="hidden" name="ProsjektID" value="<?php echo $Prosjekt['ID']; ?>" />
<fieldset>
  <legend>Kommentarer</legend>
<table>
<?php
  if (isset($Prosjekt['Kommentarer'])) {
    foreach ($Prosjekt['Kommentarer'] as $Kommentar) {
?>
  <tr>
    <td><?php echo $Kommentar['DatoRegistrert']; ?></td>
    <td><?php if (isset($Kommentar['Person']['Navn'])) { echo $Kommentar['Person']['Navn']; } else { echo "&nbsp;"; } ?></td>
    <td><?php echo $Kommentar['Kommentar']; ?></td>
  </tr>
<?php
    }
  }
?>
<?php if (($Prosjekt['StatusID'] < 5) and (in_array('501',$UABruker['UAP']))) { ?>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td><textarea name="NyKommentar"></textarea><input type="submit" value="Legg til" /></td>
  </tr>
<?php } ?>
</table>
</fieldset>
<?php echo form_close(); ?>
<?php } ?>
