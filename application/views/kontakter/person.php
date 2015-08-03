<?php echo form_open('kontakter/person'); ?>
<input type="hidden" name="PersonID" id="PersonID" value="<?php echo set_value('PersonID',$Person['PersonID']); ?>" />
<fieldset>
  <p>
    <label for="Fornavn">Navn:</label>
    <input type="text" name="Fornavn" id="Fornavn" value="<?php echo set_value('Fornavn',$Person['Fornavn']); ?>" style="width:120px" required />&nbsp;<input type="text" name="Etternavn" id="Etternavn" value="<?php echo set_value('Etternavn',$Person['Etternavn']); ?>" style="width:160px;" required />
  </p>

  <p>
    <label for="Fodselsdato">Fødselsdato:</label>
    <input type="date" name="DatoFodselsdato" id="DatoFodselsdato" value="<?php echo set_value('DatoFodselsdato',($Person['DatoFodselsdato'] != '0000-00-00' ? $Person['DatoFodselsdato'] : '')); ?>" />
  </p>

  <p>
    <label for="Mobilnr">Mobilnr:</label>
    <input type="number" name="Mobilnr" id="Mobilnr" value="<?php echo set_value('Mobilnr',$Person['Mobilnr']); ?>" />
  </p>

  <p>
    <label for="Epost">Epost:</label>
    <input type="text" name="Epost" id="Epost" value="<?php echo set_value('Epost',$Person['Epost']); ?>" />
  </p>

  <p class="handlinger">
    <label>&nbsp;</label>
    <input type="submit" value="Lagre" id="LagrePerson" name="PersonLagre" />
<?php if ($Person['PersonID'] > 0) { ?>
    <input type="button" value="Slett" onclick="javascript:document.location.href='<?php echo site_url(); ?>/kontakter/slettperson/<?php echo $Person['PersonID']; ?>';" />
<?php } ?>
  </p>
</fieldset>

<input type="hidden" name="AdresseID" id="AdresseID" value="<?php echo set_value('AdresseID',$Person['Adresser'][0]['AdresseID']); ?>" />
<fieldset class="skjema">
  <legend>Adresse</legend>

  <p>
    <label for="Adresse1">Adresse:</label>
    <input type="text" name="Adresse1" id="Adresse1" value="<?php echo set_value('Adresse1',$Person['Adresser'][0]['Adresse1']); ?>" />
  </p>

  <p>
    <label for="Adresse2">&nbsp;</label>
    <input type="text" name="Adresse2" id="Adresse2" value="<?php echo set_value('Adresse2',$Person['Adresser'][0]['Adresse2']); ?>" />
  </p>

  <p>
    <label for="Postnummer">Postnummer:</label>
    <input type="number" name="Postnummer" id="Postnummer" maxlength="4" value="<?php echo set_value('Postnummer',$Person['Adresser'][0]['Postnummer']); ?>" />&nbsp;<?php echo $Person['Adresser'][0]['Poststed']; ?>
  </p>
</fieldset>

<fieldset class="skjema">
  <legend>Medlem</legend>

  <p>
    <label>Er medlem</label>
    <input type="checkbox" name="Medlem" id="Medlem" <?php echo set_checkbox('Medlem',1,($Person['Medlem'] == 1) ? TRUE : FALSE); ?>/>
  </p>

  <p>
    <label for="Initialer">Initialer:</label>
    <input type="text" name="Initialer" id="Initialer" value="<?php echo set_value('Initialer',$Person['Initialer']); ?>" />
  </p>

  <p>
    <label for="Relasjonsnummer">Relasjonsnr:</label>
    <input type="number" name="Relasjonsnummer" id="Relasjonsnummer" value="<?php echo set_value('Relasjonsnummer',$Person['Relasjonsnummer']); ?>" />
  </p>

  <p>
    <label for="DatoMedlemsdato">Medlem fra:</label>
    <input type="date" name="DatoMedlemsdato" id="DatoMedlemsdato" value="<?php echo set_value('DatoMedlemsdato',($Person['DatoMedlemsdato'] != '0000-00-00' ? $Person['DatoMedlemsdato'] : '')); ?>" />
  </p>

  <p>
    <label>Medlemsgrupper:</label>
    <table>
<?php
  if (isset($Person['Medlemsgrupper'])) {
    foreach ($Person['Medlemsgrupper'] as $Gruppe) {
?>
      <tr>
        <td><?php echo $Gruppe['Navn']; ?></td>
      </tr>
<?php
    }
  }
?>
    </table>
  </p>

  <p>
    <label>Legg til i gruppe:</label>
    <select name="NyMedlemsgruppeID">
      <option value="0">(ingen endring)</option>
<?php
  if (isset($Medlemsgrupper)) {
    foreach ($Medlemsgrupper as $Gruppe) {
?>
      <option value="<?php echo $Gruppe['GruppeID']; ?>"><?php echo $Gruppe['Navn']; ?></option>
<?php
    }
  }
?>
    </select>
  </p>
</fieldset>
<?php echo form_close(); ?>
