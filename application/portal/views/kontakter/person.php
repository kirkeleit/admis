<?php echo form_open('kontakter/person'); ?>
<input type="hidden" name="ID" id="ID" value="<?php echo set_value('ID',$Person['ID']); ?>" />
<?php if (isset($Person['OrgID'])) { ?>
<input type="hidden" name="OrgID" value="<?php echo set_value('OrgID',$Person['OrgID']); ?>" />
<?php } ?>
<fieldset>
  <p>
    <label for="Fornavn">Navn:</label>
    <input type="text" name="Fornavn" id="Fornavn" value="<?php echo set_value('Fornavn',$Person['Fornavn']); ?>" style="width:120px" required />&nbsp;<input type="text" name="Etternavn" id="Etternavn" value="<?php echo set_value('Etternavn',$Person['Etternavn']); ?>" style="width:160px;" required />
  </p>

  <p>
    <label for="Fodselsdato">Fødselsdato:</label>
    <input type="date" name="Fodselsdato" id="Fodselsdato" value="<?php echo set_value('Fodselsdato',$Person['Fodselsdato']); ?>" required />
  </p>

  <p>
    <label for="Mobilnr">Mobilnr:</label>
    <input type="number" name="Mobilnr" id="Mobilnr" value="<?php echo set_value('Mobilnr',$Person['Mobilnr']); ?>"  required />
  </p>

  <p>
    <label for="Epost">Epost:</label>
    <input type="text" name="Epost" id="Epost" value="<?php echo set_value('Epost',$Person['Epost']); ?>" required />
  </p>

  <p class="handlinger">
    <label>&nbsp;</label>
    <input type="submit" value="Lagre" id="LagrePerson" />
<?php if ($Person['ID'] > 0) { ?>
    <input type="button" value="Slett" onclick="javascript:document.location.href='<?php echo site_url(); ?>/kontakter/slettperson/<?php echo $Person['ID']; ?>';" />
<?php } ?>
  </p>
</fieldset>

<fieldset class="skjema">
  <legend>Adresse</legend>

  <p>
    <label for="Adresse">Adresse:</label>
    <input type="text" name="Adresse" id="Adresse" value="<?php echo set_value('Adresse',$Person['Adresse']); ?>" />
  </p>

  <p>
    <label for="Postnr">Postnr/sted:</label>
    <input type="number" name="Postnr" id="Postnr" maxlength="4" value="<?php echo set_value('Postnr',$Person['Postnr']); ?>" />&nbsp;<input type="text" name="Poststed" id="Poststed" readonly />
  </p>
</fieldset>

<fieldset class="skjema">
  <legend>Medlem</legend>

  <p>
    <label>Er medlem</label>
    <input type="checkbox" name="ErMedlem" id="ErMedlem" <?php echo set_checkbox('ErMedlem',1,($Person['Medlem'] == 1) ? TRUE : FALSE); ?>/>
  </p>

  <p>
    <label for="Initialer">Initialer:</label>
    <input type="text" name="Initialer" id="Initialer" value="<?php echo set_value('Initialer',$Person['Initialer']); ?>" />
  </p>

  <p>
    <label for="Relasjonsnr">Relasjonsnr:</label>
    <input type="number" name="Relasjonsnr" id="Relasjonsnr" value="<?php echo set_value('Relasjonsnr',$Person['Relasjonsnr']); ?>" />
  </p>

  <p>
    <label for="Medlemsdato">Medlem fra:</label>
    <input type="date" name="Medlemsdato" id="Medlemsdato" value="<?php echo set_value('Medlemsdato',$Person['Medlemsdato']); ?>" />
  </p>
</fieldset>

<fieldset>
  <legend>Bruker</legend>

  <p>
    <label>Er bruker</label>
    <input type="checkbox" name="ErBruker" id="ErBruker" <?php echo set_checkbox('ErBruker',1,($Person['Bruker'] == 1) ? TRUE: FALSE); ?>/>
  </p>
<script>
  $('#ErBruker').click(function(){
    if($(this).is(':checked')){
      $('#Brukernavn').val($('#Epost').val());
      $('#NyttPassord').val($('#Mobilnr').val());
    } else {
      $('#Brukernavn').val('');
      $('#NyttPassord').val('');
    }
  });
</script>
  <p>
    <label>Brukernavn:</label>
    <input type="text" name="Brukernavn" id="Brukernavn" value="<?php echo set_value('Brukernavn',$Person['Brukernavn']); ?>" />
  </p>
  <p>
    <label>Nytt passord:</label>
    <input type="password" name="NyttPassord" id="NyttPassord" value="" />
  </p>
</fieldset>
<?php echo form_close(); ?>

<?php echo form_open('kontakter/koblepersongruppe/'); ?>
<input type="hidden" name="PersonID" value="<?php echo $Person['ID']; ?>" />
<fieldset>
  <legend>Grupper</legend>

  <p>
    <label>Grupper:</label>
    <table>
<?php
  if (isset($Person['Grupper'])) {
    foreach ($Person['Grupper'] as $Gruppe) {
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
    <select name="GruppeID">
      <option value="0">(ingen endring)</option>
<?php
  if (isset($Grupper)) {
    foreach ($Grupper as $Gruppe) {
?>
      <option value="<?php echo $Gruppe['ID']; ?>"><?php echo $Gruppe['Navn']; ?></option>
<?php
    }
  }
?>
    </select>
    <input type="submit" value="Legg til" />
  </p>
</fieldset>
<?php echo form_close(); ?>
