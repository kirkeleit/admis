<?php echo form_open('/okonomi/faktura/'.$Faktura['FakturaID']); ?>
<input type="hidden" name="FakturaID" value="<?php echo $Faktura['FakturaID']; ?>" />
<div class="panel panel-default">
  <div class="panel-heading">Faktura</div>

  <div class="panel-body">
    <div class="form-group">
      <label for="Referanse">Referanse:</label>
      <input type="text" class="form-control" name="Referanse" value="<?php echo set_value('Referanse',$Faktura['Referanse']); ?>" />
    </div>

    <div class="form-group">
      <label for="PersonRegistrertID">Ansvarlig person:</label>
      <select name="PersonAnsvarligID" class="form-control">
        <option value="0" <?php echo set_select('PersonAnsvarligID',0,($Faktura['PersonAnsvarligID'] == 0) ? TRUE : FALSE); ?>>(ingen valgt)</option>
<?php
  foreach ($Personer as $Person) {
?>
        <option value="<?php echo $Person['PersonID']; ?>" <?php echo set_select('PersonAnsvarligID',$Person['PersonID'],($Faktura['PersonAnsvarligID'] == $Person['PersonID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
  }
?>
      </select>
      <span class="help-block">Hvem er ansvarlig for å få klargjort faktura og sendt til fakturering?</span>
    </div>

    <div class="form-group">
      <label for="Notater">Notater:</label>
      <textarea name="Notater" class="form-control"><?php echo set_value('Notater',$Faktura['Notater']); ?></textarea>
    </div>

    <div class="input-group">
      <div class="btn-group">
        <input type="submit" class="btn btn-default" name="FakturaLagre" value="Lagre" />
      </div>
    </div>

  </div>
</div>
<?php echo form_close(); ?>
