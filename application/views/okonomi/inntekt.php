<h3 class="sub-header">Inntektsdetaljer</h3>

<?php echo form_open('okonomi/inntekt/'.$Inntekt['InntektID']); ?>
<input type="hidden" name="InntektID" value="<?php echo set_value('InntektID',$Inntekt['InntektID']); ?>" />
<div class="panel panel-default">
  <div class="panel-heading">&nbsp;</div>

  <div class="panel-body">
    <div class="form-group">
      <label for="PersonID">Person:</label>
      <select name="PersonID" class="form-control">
        <option value="0" <?php echo set_select('PersonID',0,($Inntekt['PersonID'] == 0) ? TRUE : FALSE); ?>>(ingen medlem)</option>
<?php
  foreach ($Medlemmer as $Person) {
?>
        <option value="<?php echo $Person['PersonID']; ?>" <?php echo set_select('PersonID',$Person['PersonID'],($Inntekt['PersonID'] == $Person['PersonID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="AktivitetID">Aktivitet:</label>
      <select name="AktivitetID" class="form-control">
<?php
  foreach ($Aktiviteter as $Aktivitet) {
?>
        <option value="<?php echo $Aktivitet['AktivitetID']; ?>" <?php echo set_select('AktivitetID',$Aktivitet['AktivitetID'],($Inntekt['AktivitetID'] == $Aktivitet['AktivitetID']) ? TRUE : FALSE); ?>><?php echo $Aktivitet['AktivitetID']." ".$Aktivitet['Navn']; ?></option>
<?php
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="KontoID">Konto:</label>
      <select name="KontoID" class="form-control">
<?php
  foreach ($Kontoer as $Konto) {
?>
        <option value="<?php echo $Konto['KontoID']; ?>" <?php echo set_select('KontoID',$Konto['KontoID'],($Inntekt['KontoID'] == $Konto['KontoID']) ? TRUE : FALSE); ?>><?php echo $Konto['KontoID']." ".$Konto['Navn']; ?></option>
<?php
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="ProsjektID">Prosjekt:</label>
      <select name="ProsjektID" class="form-control">
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
    </div>

    <div class="form-group">
      <label for="DatoBokfort">Dato:</label>
      <input type="date" class="form-control" name="DatoBokfort" value="<?php echo set_value('DatoBokfort',($Inntekt['DatoBokfort'] != '' ? date("d.m.Y",strtotime($Inntekt['DatoBokfort'])) : '')); ?>" />
    </div>

    <div class="form-group">
      <label for="Beskrivelse">Beskrivelse:</label>
      <input type="text" class="form-control" name="Beskrivelse" value="<?php echo set_value('Beskrivelse',$Inntekt['Beskrivelse']); ?>" />
    </div>

    <div class="form-group">
      <label for="Belop">Beløp:</label>
      <input type="number" class="form-control" name="Belop" value="<?php echo set_value('Belop',$Inntekt['Belop']); ?>" step="any" />
    </div>

    <div class="form-group">
      <div class="btn-group">
        <input type="submit" class="btn btn-primary" name="InntektLagre" value="Lagre" />
        <input type="submit" class="btn btn-danger" name="InntektSlett" value="Slett" />
      </div>
    </div>
  </div>
</div>

<?php echo form_close(); ?>
