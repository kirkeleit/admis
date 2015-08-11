<?php $Redigerbar = 1; ?>
<?php echo form_open('materiell/tsrapport'); ?>
<input type="hidden" name="ID" value="<?php echo set_value('ID',$Rapport['ID']); ?>" />
<fieldset>
  <legend>Tap/skade</legend>

  <p>
    <label for="Skadetype">Tap/skade:</label>
    <select name="Skadetype" id="Skadetype"<?php if ($Redigerbar == 0) { echo " disabled"; } ?>>
      <option value="0" <?php echo set_select('Skadetype',0,($Rapport['Skadetype'] == 0) ? TRUE : FALSE); ?>>Trenger vedlikehold</option>
      <option value="1" <?php echo set_select('Skadetype',1,($Rapport['Skadetype'] == 1) ? TRUE : FALSE); ?>>Skadet utstyr (beredskapsklart)</option>
      <option value="2" <?php echo set_select('Skadetype',2,($Rapport['Skadetype'] == 2) ? TRUE : FALSE); ?>>Skadet utstyr (ikke beredskapsklart)</option>
      <option value="3" <?php echo set_select('Skadetype',3,($Rapport['Skadetype'] == 3) ? TRUE : FALSE); ?>>Tapt utstyr</option>
    </select>
  </p>

  <p>
    <label for="PersonID">Innmeldt av:</label>
    <select name="PersonID" id="PersonID"<?php if ($Redigerbar == 0) { echo " disabled"; } ?>>
      <option value="0" <?php echo set_select('PersonID',0,($Rapport['PersonID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Personer)) {
    foreach ($Personer as $Person) {
?>
      <option value="<?php echo $Person['ID']; ?>" <?php echo set_select('PersonID',$Person['ID'],($Rapport['PersonID'] == $Person['ID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
    }
  }
?>
    </select>
  </p>

  <p>
    <label for="UtstyrID">Utstyr:</label>
    <select name="UtstyrID" id="UtstyrID"<?php if ($Redigerbar == 0) { echo " disabled"; } ?>>
      <option value="-1">(eget utstyr)</option>
      <option value="0" <?php echo set_select('PersonID',0,($Rapport['PersonID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
?>
      <option value="<?php echo $Utstyr['ID']; ?>" <?php echo set_select('UtstyrID',$Utstyr['ID'],($Rapport['UtstyrID'] == $Utstyr['ID']) ? TRUE : FALSE); ?>><?php echo $Utstyr['Navn']; ?></option>
<?php
    }
  }
?>
    </select>
  </p>

  <p>
    <label for="Hva">Hva er ødelagt:</label>
    <textarea name="Hva" id="Hva"<?php if ($Redigerbar == 0) { echo " disabled"; } ?>><?php echo set_value('Hva',$Rapport['Hva']); ?></textarea>
  </p>

  <p>
    <label for="Hvordan">Hvordan det skjedde:</label>
    <textarea name="Hvordan" id="Hva"<?php if ($Redigerbar == 0) { echo " disabled"; } ?>><?php echo set_value('Hvordan',$Rapport['Hvordan']); ?></textarea>
  </p>

  <p>
    <label for="Losning">Løsning:</label>
    <textarea name="Losning" id="Losningt"<?php if (($Redigerbar == 0) or ($Rapport['ID'] == 0)) { echo " disabled"; } ?>><?php echo set_value('Losning',$Rapport['Losning']); ?></textarea>
  </p>

  <p>
    <label for="Notater">Notater:</label>
    <textarea name="Notater" id="Notater"<?php if ($Redigerbar == 0) { echo " disabled"; } ?>><?php echo set_value('Notater',$Rapport['Notater']); ?></textarea>
  </p>

  <p>
    <label for="Status">Status:</label>
    <span><?php echo $Rapport['Status']; ?></span>
  </p>

  <p class="handlinger">
    <label>&nbsp;</label>
    <input type="submit" value="Registrer" />
  </p>
</fieldset>
<?php echo form_close(); ?>
