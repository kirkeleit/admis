<?php echo form_open('okonomi/inntekt'); ?>
<input type="hidden" name="InntektID" value="<?php echo set_value('InntektID',$Inntekt['InntektID']); ?>" />
<fieldset>
  <legend>Inntekt</legend>

  <p>
    <label for="PersonID">Medlem:</label>
    <select name="PersonID">
      <option value="0" <?php echo set_select('PersonID',0,($Inntekt['PersonID'] == 0) ? TRUE : FALSE); ?>>(ingen medlem)</option>
<?php
  foreach ($Medlemmer as $Person) {
?>
      <option value="<?php echo $Person['PersonID']; ?>" <?php echo set_select('PersonID',$Person['PersonID'],($Inntekt['PersonID'] == $Person['PersonID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
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
      <option value="<?php echo $Aktivitet['AktivitetID']; ?>" <?php echo set_select('AktivitetID',$Aktivitet['AktivitetID'],($Inntekt['AktivitetID'] == $Aktivitet['AktivitetID']) ? TRUE : FALSE); ?>><?php echo $Aktivitet['AktivitetID']." ".$Aktivitet['Navn']; ?></option>
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
      <option value="<?php echo $Konto['KontoID']; ?>" <?php echo set_select('KontoID',$Konto['KontoID'],($Inntekt['KontoID'] == $Konto['KontoID']) ? TRUE : FALSE); ?>><?php echo $Konto['KontoID']." ".$Konto['Navn']; ?></option>
<?php
  }
?>
    </select>
  </p>

  <p>
    <label for="ProsjektID">Prosjekt:</label>
    <select name="ProsjektID">
      <option value="0" <?php echo set_select('ProsjektID',0,($Inntekt['ProsjektID'] == 0) ? TRUE : FALSE); ?>>(ingen prosjekt)</option>
<?php
  foreach ($Prosjekter as $Prosjekt) {
?>
      <option value="<?php echo $Prosjekt['ProsjektID']; ?>" <?php echo set_select('ProsjektID',$Prosjekt['ProsjektID'],($Inntekt['ProsjektID'] == $Prosjekt['ProsjektID']) ? TRUE : FALSE); ?>><?php echo $Prosjekt['Prosjektnavn']; ?></option>
<?php
  }
?>
      <optgroup label="Arkiverte prosjekt">
<?php
  foreach ($ProsjekterArkiv as $Prosjekt) {
?>
      <option value="<?php echo $Prosjekt['ProsjektID']; ?>" <?php echo set_select('ProsjektID',$Prosjekt['ProsjektID'],($Inntekt['ProsjektID'] == $Prosjekt['ProsjektID']) ? TRUE : FALSE); ?>><?php echo $Prosjekt['Prosjektnavn']; ?></option>
<?php
  }
?>
      </optgroup>
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
    <input type="button" value="Slett" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/slettinntekt/<?php echo $Inntekt['InntektID']; ?>';"<?php if ($Inntekt['InntektID'] == 0) { echo " disabled"; } ?> />
  </p>
</fieldset>
<?php echo form_close(); ?>
