<h3 class="sub-header">Tap og Skaderapport</h3>

<?php echo form_open('materiell/tsrapport/'.$Rapport['TapSkadeRapportID']); ?>
<input type="hidden" name="TapSkadeRapportID" value="<?php echo set_value('TapSkadeRapportID',$Rapport['TapSkadeRapportID']); ?>" />
<div class="panel panel-default">
  <div class="panel-heading">&nbsp;</div>

  <div class="panel-body">
    <div class="form-group">
      <label for="Skadetype">Tap/skade:</label>
      <select name="Skadetype" class="form-control" id="Skadetype">
        <option value="0" <?php echo set_select('Skadetype',0,($Rapport['Skadetype'] == 0) ? TRUE : FALSE); ?>>Trenger vedlikehold</option>
        <option value="1" <?php echo set_select('Skadetype',1,($Rapport['Skadetype'] == 1) ? TRUE : FALSE); ?>>Skadet utstyr (beredskapsklart)</option>
        <option value="2" <?php echo set_select('Skadetype',2,($Rapport['Skadetype'] == 2) ? TRUE : FALSE); ?>>Skadet utstyr (ikke beredskapsklart)</option>
        <option value="3" <?php echo set_select('Skadetype',3,($Rapport['Skadetype'] == 3) ? TRUE : FALSE); ?>>Tapt utstyr</option>
      </select>
    </div>

    <div class="form-group">
      <label for="PersonRapportertID">Innmeldt av:</label>
      <select name="PersonRapportertID" id="PersonRapportertID" class="form-control">
        <option value="0" <?php echo set_select('PersonRapportertID',0,($Rapport['PersonRapportertID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Personer)) {
    foreach ($Personer as $Person) {
?>
        <option value="<?php echo $Person['PersonID']; ?>" <?php echo set_select('PersonRapportertID',$Person['PersonID'],($Rapport['PersonRapportertID'] == $Person['PersonID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
    }
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="UtstyrID">Utstyr:</label>
      <select name="UtstyrID" id="UtstyrID" class="form-control">
        <option value="-1">(eget utstyr)</option>
        <option value="0" <?php echo set_select('UtstyrID',0,($Rapport['UtstyrID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
?>
        <option value="<?php echo $Utstyr['UtstyrID']; ?>" <?php echo set_select('UtstyrID',$Utstyr['UtstyrID'],($Rapport['UtstyrID'] == $Utstyr['UtstyrID']) ? TRUE : FALSE); ?>><?php echo $Utstyr['Navn']; ?></option>
<?php
    }
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="Hva" style="vertical-align: top">Hva er ødelagt:</label>
      <textarea name="Hva" class="form-control" id="Hva"><?php echo set_value('Hva',$Rapport['Hva']); ?></textarea>
    </div>

    <div class="form-group">
      <label for="Hvordan" style="vertical-align: top">Hvordan det skjedde:</label>
      <textarea name="Hvordan" class="form-control" id="Hva"><?php echo set_value('Hvordan',$Rapport['Hvordan']); ?></textarea>
    </div>

    <div class="form-group">
      <label for="Losning" style="vertical-align: top">Løsningsforslag:</label>
      <textarea name="Losning" id="Losning" class="form-control"><?php echo set_value('Losning',$Rapport['Losning']); ?></textarea>
    </div>

    <div class="form-group">
      <label for="Notater" style="vertical-align: top">Notater:</label>
      <textarea name="Notater" id="Notater" class="form-control"><?php echo set_value('Notater',$Rapport['Notater']); ?></textarea>
    </div>

    <div class="form-group">
      <label for="Status">Status:</label>
      <span><?php echo $Rapport['Status']; ?></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Lagre rapport" />
    </div>
  </div>
</div>
<?php echo form_close(); ?>
