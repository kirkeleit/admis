<?php echo form_open_multipart('okonomi/utleggskvittering'); ?>
<h2>IKKE BRUK!</h2>
<input type="hidden" name="ID" value="<?php echo set_value('ID',$Utlegg['ID']); ?>" />
<?php
  $SkjemaOk = 1;
  if ($Utlegg['Kontonummer'] == "") {
    $SkjemaFeil[] = "Mangler kontonummer";
    $SkjemaOk = 0;
  }
  if ($Utlegg['Beskrivelse'] == "") {
    $SkjemaFeil[] = "Mangler beskrivelse";
    $SkjemaOk = 0;
  }
  if ($Utlegg['Belop'] == 0) {
    $SkjemaFeil[] = "Mangler beløp";
    $SkjemaOk = 0;
  }
  if (!isset($Utlegg['Filer'])) {
    $SkjemaFeil[] = "Mangler kvittering";
    $SkjemaOk = 0;
  }
  if ((isset($SkjemaFeil)) and ($Utlegg['ID'] > 0)) {
?>
<div>
<ul>
<?php
    foreach ($SkjemaFeil as $Feil) {
?>
  <li><?php echo $Feil; ?></li>
<?php
    }
?>
</ul>
</div>
<?php
  }
?>
<fieldset>
  <legend>Utleggskvittering</legend>

  <p>
    <label for="DatoUtlegg">Dato:</label>
    <input type="date" name="DatoUtlegg" value="<?php echo set_value('DatoUtlegg',date("d.m.Y",strtotime($Utlegg['DatoUtlegg']))); ?>" />
  </p>

  <p>
    <label for="PersonID">Medlem:</label>
    <select name="PersonID">
      <option value="0" <?php echo set_select('PersonID',0,($Utlegg['PersonID'] == 0) ? TRUE : FALSE); ?>>(ingen medlem)</option>
<?php
  foreach ($Personer as $Person) {
?>
      <option value="<?php echo $Person['ID']; ?>" <?php echo set_select('PersonID',$Person['ID'],($Utlegg['PersonID'] == $Person['ID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
  }
?>
    </select>
  </p>

  <p>
    <label for="Kontonummer">Kontonummer:</label>
    <input type="text" name="Kontonummer" value="<?php echo set_value('Kontonummer',$Utlegg['Kontonummer']); ?>" />
  </p>

  <p>
    <label for="Beskrivelse">Beskrivelse:</label>
    <textarea name="Beskrivelse"><?php echo set_value('Beskrivelse',$Utlegg['Beskrivelse']); ?></textarea>
  </p>

  <p>
    <label for="Belop">Beløp:</label>
    <input type="number" name="Belop" value="<?php echo set_value('Belop',$Utlegg['Belop']); ?>" step="any" />
  </p>

  <p>
    <label for="AktivitetID">Aktivitet:</label>
    <select name="AktivitetID">
<?php
  foreach ($Aktiviteter as $Aktivitet) {
?>
      <option value="<?php echo $Aktivitet['ID']; ?>" <?php echo set_select('AktivitetID',$Aktivitet['ID'],($Utlegg['AktivitetID'] == $Aktivitet['ID']) ? TRUE : FALSE); ?>><?php echo $Aktivitet['ID']." ".$Aktivitet['Navn']; ?></option>
<?php
  }
?>
    </select>
  </p>

  <p>
    <label for="ProsjektID">Prosjekt:</label>
    <select name="ProsjektID">
      <option value="0" <?php echo set_select('ProsjektID',0,($Utlegg['ProsjektID'] == 0) ? TRUE : FALSE); ?>>(ingen prosjekt)</option>
<?php
  foreach ($Prosjekter as $Prosjekt) {
?>
      <option value="<?php echo $Prosjekt['ID']; ?>" <?php echo set_select('ProsjektID',$Prosjekt['ID'],($Utlegg['ProsjektID'] == $Prosjekt['ID']) ? TRUE : FALSE); ?>><?php echo $Prosjekt['Prosjektnavn']; ?></option>
<?php
  }
?>
      <optgroup label="Arkiverte prosjekt">
<?php
  foreach ($ProsjekterArkiv as $Prosjekt) {
?>
      <option value="<?php echo $Prosjekt['ID']; ?>" <?php echo set_select('ProsjektID',$Prosjekt['ID'],($Utlegg['ProsjektID'] == $Prosjekt['ID']) ? TRUE : FALSE); ?>><?php echo $Prosjekt['Prosjektnavn']; ?></option>
<?php
  }
?>
      </optgroup>
    </select>
  </p>

<?php if (isset($Utlegg['Filer'])) { ?>
  <p>
    <label>Kvitteringer:</label>
<?php
  foreach ($Utlegg['Filer'] as $ID => $Filnavn) {
?>
    <a href="<?php echo base_url(); ?>uploads/<?php echo $Filnavn; ?>" target="_new">Kvittering</a>
<?php
  }
?>
  </p>
<?php } ?>

  <p>
    <label for="Kvittering">Ny kvittering:</label>
    <input type="file" name="userfile" />
<?php
  if (isset($Utgift['Filer'])) {
    foreach ($Utgift['Filer'] as $FilID => $Filnavn) {
?>
  <a href="<?php echo base_url(); ?>uploads/<?php echo $Filnavn; ?>" target="_new">Kvittering</a>
<?php
    }
  }
?>
  </p>

  <p class="handlinger">
    <label>&nbsp;</label>
<?php if ($Utlegg['StatusID'] < 1) { ?>
    <input type="submit" value="Lagre" name="UtleggLagre" />
    <input type="submit" value="Slett" name="UtleggSlett" <?php if ($Utlegg['ID'] == 0) { echo "disabled"; } ?> />
<?php } else { ?>
    <input type="submit" value="Lagre" name="UtleggLagre" disabled />
    <input type="submit" value="Slett" name="UtleggSlett" disabled />
<?php } ?>
<?php if (($Utlegg['ID'] > 0) and ($Utlegg['StatusID'] == 0) and ($Utlegg['PersonID'] == $UABruker['ID']) and ($SkjemaOk == 1)) { ?>
    <input type="submit" value="Signer" name="UtleggSigner" />
<?php } else { ?>
    <input type="submit" value="Signer" name="UtleggSigner" disabled />
<?php } ?>
<?php if (($Utlegg['ID'] > 0) and ($Utlegg['StatusID'] == 1) and (in_array('309',$UABruker['UAP']))) { ?>
    <input type="submit" value="Godkjenn" name="UtleggGodkjenn" />
<?php } else { ?>
    <input type="submit" value="Godkjenn" name="UtleggGodkjenn" disabled />
<?php } ?>
  </p>
</fieldset>
<?php echo form_close(); ?>
