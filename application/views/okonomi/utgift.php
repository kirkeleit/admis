<?php echo form_open_multipart('okonomi/utgift'); ?>
<input type="hidden" name="UtgiftID" value="<?php echo set_value('UtgiftID',$Utgift['UtgiftID']); ?>" />

  <div class="form-group">
    <label for="PersonID">Medlem:</label>
    <select class="form-control" name="PersonID">
      <option value="0" <?php echo set_select('PersonID',0,($Utgift['PersonID'] == 0) ? TRUE : FALSE); ?>>(ingen medlem)</option>
<?php
  foreach ($Medlemmer as $Person) {
?>
      <option value="<?php echo $Person['PersonID']; ?>" <?php echo set_select('PersonID',$Person['PersonID'],($Utgift['PersonID'] == $Person['PersonID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
  }
?>
    </select>
  </div>

  <div class="form-group">
    <label for="AktivitetID">Aktivitet:</label>
    <select class="form-control" name="AktivitetID">
<?php
  foreach ($Aktiviteter as $Aktivitet) {
?>
      <option value="<?php echo $Aktivitet['AktivitetID']; ?>" <?php echo set_select('AktivitetID',$Aktivitet['AktivitetID'],($Utgift['AktivitetID'] == $Aktivitet['AktivitetID']) ? TRUE : FALSE); ?>><?php echo $Aktivitet['AktivitetID']." ".$Aktivitet['Navn']; ?></option>
<?php
  }
?>
    </select>
  </div>

  <div class="form-group">
    <label for="KontoID">Konto:</label>
    <select class="form-control" name="KontoID" id="KontoID">
<?php
  foreach ($Kontoer as $Konto) {
?>
      <option value="<?php echo $Konto['KontoID']; ?>" <?php echo set_select('KontoID',$Konto['KontoID'],($Utgift['KontoID'] == $Konto['KontoID']) ? TRUE : FALSE); ?>><?php echo $Konto['KontoID']." ".$Konto['Navn']; ?></option>
<?php
  }
?>
    </select>
  </div>

  <div class="form-group">
    <label for="ProsjektID">Prosjekt:</label>
    <select class="form-control" name="ProsjektID">
      <option value="0" <?php echo set_select('ProsjektID',0,($Utgift['ProsjektID'] == 0) ? TRUE : FALSE); ?>>(ingen prosjekt)</option>
<?php
  foreach ($Prosjekter as $Prosjekt) {
?>
      <option value="<?php echo $Prosjekt['ProsjektID']; ?>" <?php echo set_select('ProsjektID',$Prosjekt['ProsjektID'],($Utgift['ProsjektID'] == $Prosjekt['ProsjektID']) ? TRUE : FALSE); ?>><?php echo $Prosjekt['Prosjektnavn']; ?></option>
<?php
  }
?>
      <optgroup label="Arkiverte prosjekt">
<?php
  foreach ($ProsjekterArkiv as $Prosjekt) {
?>
      <option value="<?php echo $Prosjekt['ProsjektID']; ?>" <?php echo set_select('ProsjektID',$Prosjekt['ProsjektID'],($Utgift['ProsjektID'] == $Prosjekt['ProsjektID']) ? TRUE : FALSE); ?>><?php echo $Prosjekt['Prosjektnavn']; ?></option>
<?php
  }
?>
      </optgroup>
    </select>
  </div>

  <div class="form-group">
    <label for="DatoBokfort">Dato:</label>
    <input type="date" class="form-control" name="DatoBokfort" value="<?php echo set_value('DatoBokfort',$Utgift['DatoBokfort']); ?>" />
  </div>

  <div class="form-group">
    <label for="Beskrivelse">Beskrivelse:</label>
    <input type="text" class="form-control" name="Beskrivelse" value="<?php echo set_value('Beskrivelse',$Utgift['Beskrivelse']); ?>" />
  </div>

  <div class="form-group">
    <label for="Belop">Beløp:</label>
    <input type="number" class="form-control" name="Belop" value="<?php echo set_value('Belop',$Utgift['Belop']); ?>" step="any" />
  </div>

  <div class="form-group">
    <label for="Kvittering">Kvittering:</label>
    <input type="file" class="form-control" name="userfile" />
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
    <input type="submit" class="btn btn-default" value="Lagre" />
    <input type="button" value="Slett" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/slettutgift/<?php echo $Utgift['UtgiftID']; ?>';"<?php if ($Utgift['UtgiftID'] == 0) { echo " disabled"; } ?> />
  </div>
<?php echo form_close(); ?>
