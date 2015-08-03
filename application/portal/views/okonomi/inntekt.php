<?php echo form_open('okonomi/inntekt'); ?>
<input type="hidden" name="ID" value="<?php echo set_value('ID',$Inntekt['ID']); ?>" />
<fieldset>
  <legend>Inntekt</legend>

  <p>
    <label for="PersonID">Medlem:</label>
    <select name="PersonID">
      <option value="0" <?php echo set_select('PersonID',0,($Inntekt['PersonID'] == 0) ? TRUE : FALSE); ?>>(ingen medlem)</option>
<?php
  foreach ($Medlemmer as $Person) {
?>
      <option value="<?php echo $Person['ID']; ?>" <?php echo set_select('PersonID',$Person['ID'],($Inntekt['PersonID'] == $Person['ID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
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
      <option value="<?php echo $Aktivitet['ID']; ?>" <?php echo set_select('AktivitetID',$Aktivitet['ID'],($Inntekt['AktivitetID'] == $Aktivitet['ID']) ? TRUE : FALSE); ?>><?php echo $Aktivitet['ID']." ".$Aktivitet['Navn']; ?></option>
<?php
  }
?>
    </select>
  </p>

  <p>
    <label for="KontoID">Konto:</label>
    <select name="KontoID">
<?php
  foreach ($Kontoer as $Konto) {
?>
      <option value="<?php echo $Konto['ID']; ?>" <?php echo set_select('KontoID',$Konto['ID'],($Inntekt['KontoID'] == $Konto['ID']) ? TRUE : FALSE); ?>><?php echo $Konto['ID']." ".$Konto['Navn']; ?></option>
<?php
  }
?>
    </select>
  </p>

  <p>
    <label for="DatoBokfort">Dato:</label>
    <input type="date" name="DatoBokfort" value="<?php echo set_value('DatoBokfort',$Inntekt['DatoBokfort']); ?>" />
  </p>

  <p>
    <label for="Beskrivelse">Beskrivelse:</label>
    <input type="text" name="Beskrivelse" value="<?php echo set_value('Beskrivelse',$Inntekt['Beskrivelse']); ?>" />
  </p>

  <p>
    <label for="Belop">Beløp:</label>
    <input type="number" name="Belop" value="<?php echo set_value('Belop',$Inntekt['Belop']); ?>" step="any" />
  </p>

  <p class="handlinger">
    <label>&nbsp;</label>
    <input type="submit" value="Lagre" />
    <input type="button" value="Slett" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/slettinntekt/<?php echo $Inntekt['ID']; ?>';"<?php if ($Inntekt['ID'] == 0) { echo " disabled"; } ?> />
  </p>
</fieldset>
<?php echo form_close(); ?>
