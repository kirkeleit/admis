<?php echo form_open_multipart('okonomi/utgift'); ?>
<input type="hidden" name="ID" value="<?php echo set_value('ID',$Utgift['ID']); ?>" />
<fieldset>
  <legend>Utgift</legend>

  <p>
    <label for="PersonID">Medlem:</label>
    <select name="PersonID">
      <option value="0" <?php echo set_select('PersonID',0,($Utgift['PersonID'] == 0) ? TRUE : FALSE); ?>>(ingen medlem)</option>
<?php
  foreach ($Medlemmer as $Person) {
?>
      <option value="<?php echo $Person['ID']; ?>" <?php echo set_select('PersonID',$Person['ID'],($Utgift['PersonID'] == $Person['ID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
  }
?>
    </select>
  </p>

  <p>
    <label for="AktivitetID">Aktivitet:</label>
    <select name="AktivitetID">
<?php
  foreach ($Aktiviteter as $Aktivitet) {
?>
      <option value="<?php echo $Aktivitet['ID']; ?>" <?php echo set_select('AktivitetID',$Aktivitet['ID'],($Utgift['AktivitetID'] == $Aktivitet['ID']) ? TRUE : FALSE); ?>><?php echo $Aktivitet['ID']." ".$Aktivitet['Navn']; ?></option>
<?php
  }
?>
    </select>
  </p>

  <p>
    <label for="KontoID">Konto:</label>
    <select name="KontoID" id="KontoID">
<?php
  foreach ($Kontoer as $Konto) {
?>
      <option value="<?php echo $Konto['ID']; ?>" <?php echo set_select('KontoID',$Konto['ID'],($Utgift['KontoID'] == $Konto['ID']) ? TRUE : FALSE); ?>><?php echo $Konto['ID']." ".$Konto['Navn']; ?></option>
<?php
  }
?>
    </select>
  </p>

  <p>
    <label for="ProsjektID">Prosjekt:</label>
    <select name="ProsjektID">
      <option value="0" <?php echo set_select('ProsjektID',0,($Utgift['ProsjektID'] == 0) ? TRUE : FALSE); ?>>(ingen prosjekt)</option>
<?php
  foreach ($Prosjekter as $Prosjekt) {
?>
      <option value="<?php echo $Prosjekt['ID']; ?>" <?php echo set_select('ProsjektID',$Prosjekt['ID'],($Utgift['ProsjektID'] == $Prosjekt['ID']) ? TRUE : FALSE); ?>><?php echo $Prosjekt['Navn']; ?></option>
<?php
  }
?>
    </select>
  </p>

  <p>
    <label for="DatoBokfort">Dato:</label>
    <input type="date" name="DatoBokfort" value="<?php echo set_value('DatoBokfort',$Utgift['DatoBokfort']); ?>" />
  </p>

  <p>
    <label for="Beskrivelse">Beskrivelse:</label>
    <input type="text" name="Beskrivelse" value="<?php echo set_value('Beskrivelse',$Utgift['Beskrivelse']); ?>" />
  </p>

  <p>
    <label for="Belop">Beløp:</label>
    <input type="number" name="Belop" value="<?php echo set_value('Belop',$Utgift['Belop']); ?>" step="any" />
  </p>

  <p>
    <label for="Kvittering">Kvittering:</label>
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
    <input type="submit" value="Lagre" />
    <input type="button" value="Slett" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/slettutgift/<?php echo $Utgift['ID']; ?>';"<?php if ($Utgift['ID'] == 0) { echo " disabled"; } ?> />
  </p>
</fieldset>
<?php echo form_close(); ?>
