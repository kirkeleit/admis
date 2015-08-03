<?php echo form_open('kontakter/organisasjon'); ?>
<input type="hidden" name="OrganisasjonID" id="OrganisasjonID" value="<?php echo set_value('OrganisasjonID',$Organisasjon['OrganisasjonID']); ?>" />
<fieldset>
  <p>
    <label for="Navn">Navn:</label>
    <input type="text" name="Navn" id="Navn" value="<?php echo set_value('Navn',$Organisasjon['Navn']); ?>" />
  </p>

  <p>
    <label for="Orgnummer">Orgnummer:</label>
    <input type="text" name="Orgnummer" id="Orgnummer" value="<?php echo set_value('Orgnummer',$Organisasjon['Orgnummer']); ?>" />
  </p>

  <p>
    <label for="Telefonnr">Telefonnr:</label>
    <input type="text" name="Telefonnr" id="Telefonnr" value="<?php echo set_value('Telefonnr',$Organisasjon['Telefonnr']); ?>" />
  </p>

  <p>
    <label for="Epost">Epost:</label>
    <input type="text" name="Epost" id="Epost" value="<?php echo set_value('Epost',$Organisasjon['Epost']); ?>" />
  </p>

<input type="hidden" name="AdresseID" id="AdresseID" value="<?php echo set_value('AdresseID',$Organisasjon['Adresser'][0]['AdresseID']); ?>" />
  <p>
    <label for="Adresse1">Adresse:</label>
    <input type="text" name="Adresse1" id="Adresse1" value="<?php echo set_value('Adresse1',$Organisasjon['Adresser'][0]['Adresse1']); ?>" />
  </p>

  <p>
    <label for="Adresse2">&nbsp;</label>
    <input type="text" name="Adresse2" id="Adresse2" value="<?php echo set_value('Adresse2',$Organisasjon['Adresser'][0]['Adresse2']); ?>" />
  </p>

  <p>
    <label for="Postnummer">Postnummer:</label>
    <input type="number" name="Postnummer" id="Postnummer" maxlength="4" value="<?php echo set_value('Postnummer',$Organisasjon['Adresser'][0]['Postnummer']); ?>" />&nbsp;<?php echo $Organisasjon['Adresser'][0]['Poststed']; ?>
  </p>

  <p class="handlinger">
    <input type="submit" value="Lagre" id="LagreOrganisasjon" name="OrganisasjonLagre" />
<?php if ($Organisasjon['OrganisasjonID'] > 0) { ?>
    <input type="button" value="Slett" onclick="javascript:document.location.href='http://admis.bomlork.no/index.php/kontakter/slettorganisasjon/<?php echo $Organisasjon['OrganisasjonID']; ?>';" />
<?php } ?>
  </p>
</fieldset>
<?php echo form_close(); ?>
