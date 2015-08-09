<h3 class="sub-header">Utleggskvittering</h3>

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
  if ((isset($SkjemaFeil)) and ($Utlegg['UtleggID'] > 0)) {
?>
<div class="alert alert-warning" role="alert">
<b>Følgende feil må rettes før utleggskvitteringen kan signeres:</b>
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

<?php echo form_open_multipart('okonomi/utleggskvittering/'.$Utlegg['UtleggID']); ?>
<h2>IKKE BRUK!</h2>
<input type="hidden" name="UtleggID" value="<?php echo set_value('UtleggID',$Utlegg['UtleggID']); ?>" />
<div class="panel panel-default">
  <div class="panel-heading">&nbsp;</div>

  <div class="panel-body">
    <div class="form-group">
      <label for="DatoUtlegg">Dato:</label>
      <input type="date" class="form-control" name="DatoUtlegg" value="<?php echo set_value('DatoUtlegg',($Utlegg['DatoUtlegg'] != '0000-00-00' ? ($Utlegg['DatoUtlegg'] == '' ? '' : date("d.m.Y",strtotime($Utlegg['DatoUtlegg']))) : '')); ?>" />
    </div>

    <div class="form-group">
      <label for="PersonID">Person:</label>
      <select name="PersonID" class="form-control">
        <option value="0" <?php echo set_select('PersonID',0,($Utlegg['PersonID'] == 0) ? TRUE : FALSE); ?>>(ingen medlem)</option>
<?php
  foreach ($Personer as $Person) {
?>
        <option value="<?php echo $Person['PersonID']; ?>" <?php echo set_select('PersonID',$Person['PersonID'],($Utlegg['PersonID'] == $Person['PersonID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="Kontonummer">Kontonummer:</label>
      <input type="text" class="form-control" name="Kontonummer" value="<?php echo set_value('Kontonummer',$Utlegg['Kontonummer']); ?>" />
    </div>

    <div class="form-group">
      <label for="Beskrivelse">Beskrivelse:</label>
      <textarea name="Beskrivelse" class="form-control"><?php echo set_value('Beskrivelse',$Utlegg['Beskrivelse']); ?></textarea>
    </div>

    <div class="form-group">
      <label for="Belop">Beløp:</label>
      <input type="number" class="form-control" name="Belop" value="<?php echo set_value('Belop',$Utlegg['Belop']); ?>" step="any" />
    </div>

    <div class="form-group">
      <label for="AktivitetID">Aktivitet:</label>
      <select name="AktivitetID" class="form-control">
<?php
  foreach ($Aktiviteter as $Aktivitet) {
?>
        <option value="<?php echo $Aktivitet['AktivitetID']; ?>" <?php echo set_select('AktivitetID',$Aktivitet['AktivitetID'],($Utlegg['AktivitetID'] == $Aktivitet['AktivitetID']) ? TRUE : FALSE); ?>><?php echo $Aktivitet['AktivitetID']." ".$Aktivitet['Navn']; ?></option>
<?php
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="ProsjektID">Prosjekt:</label>
      <select name="ProsjektID" class="form-control">
        <option value="0" <?php echo set_select('ProsjektID',0,($Utlegg['ProsjektID'] == 0) ? TRUE : FALSE); ?>>(ingen prosjekt)</option>
<?php
  foreach ($Prosjekter as $Prosjekt) {
?>
        <option value="<?php echo $Prosjekt['ProsjektID']; ?>" <?php echo set_select('ProsjektID',$Prosjekt['ProsjektID'],($Utlegg['ProsjektID'] == $Prosjekt['ProsjektID']) ? TRUE : FALSE); ?>><?php echo $Prosjekt['Prosjektnavn']; ?></option>
<?php
  }
?>
        <optgroup label="Arkiverte prosjekt">
<?php
  foreach ($ProsjekterArkiv as $Prosjekt) {
?>
          <option value="<?php echo $Prosjekt['ProsjektID']; ?>" <?php echo set_select('ProsjektID',$Prosjekt['ProsjektID'],($Utlegg['ProsjektID'] == $Prosjekt['ProsjektID']) ? TRUE : FALSE); ?>><?php echo $Prosjekt['Prosjektnavn']; ?></option>
<?php
  }
?>
        </optgroup>
      </select>
    </div>

<?php if (isset($Utlegg['Filer'])) { ?>
    <div class="form-group">
      <label>Kvitteringer:</label>
<?php
  foreach ($Utlegg['Filer'] as $ID => $Filnavn) {
?>
    <a href="<?php echo base_url(); ?>uploads/<?php echo $Filnavn; ?>" target="_new">Kvittering</a>
<?php
  }
?>
    </div>
<?php } ?>

    <div class="form-group">
      <label for="Kvittering">Ny kvittering:</label>
      <input type="file" name="userfile" class="form-control" />
<?php
  if (isset($Utgift['Filer'])) {
    foreach ($Utgift['Filer'] as $FilID => $Filnavn) {
?>
  <a href="<?php echo base_url(); ?>uploads/<?php echo $Filnavn; ?>" target="_new">Kvittering</a>
<?php
    }
  }
?>
    </div>

    <div class="form-group">
      <div class="btn-group">
<?php if ($Utlegg['StatusID'] < 1) { ?>
        <input type="submit" class="btn btn-primary" value="Lagre" name="UtleggLagre" />
        <input type="submit" class="btn btn-danger" value="Slett" name="UtleggSlett" <?php if ($Utlegg['UtleggID'] == 0) { echo "disabled"; } ?> />
<?php } else { ?>
        <input type="submit" class="btn btn-primary" value="Lagre" name="UtleggLagre" disabled />
        <input type="submit" class="btn btn-danger" value="Slett" name="UtleggSlett" disabled />
<?php } ?>
<?php if (($Utlegg['UtleggID'] > 0) and ($Utlegg['StatusID'] == 0) and ($Utlegg['PersonID'] == $UABruker['ID']) and ($SkjemaOk == 1)) { ?>
        <input type="submit" class="btn btn-success"  value="Signer" name="UtleggSigner" />
<?php } else { ?>
        <input type="submit" class="btn btn-default"  value="Signer" name="UtleggSigner" disabled />
<?php } ?>
<?php if (($Utlegg['UtleggID'] > 0) and ($Utlegg['StatusID'] == 1) and (in_array('309',$UABruker['UAP']))) { ?>
        <input type="submit" class="btn btn-success"  value="Godkjenn" name="UtleggGodkjenn" />
<?php } else { ?>
        <input type="submit" class="btn btn-default"  value="Godkjenn" name="UtleggGodkjenn" disabled />
<?php } ?>
      </div>
    </div>

  </div>
</div>
<?php echo form_close(); ?>
