<?php echo form_open('kontakter/organisasjon'); ?>
<input type="hidden" name="ID" id="ID" value="<?php echo set_value('ID',$Organisasjon['ID']); ?>" />
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

  <p class="handlinger">
    <input type="submit" value="Lagre" id="LagreOrganisasjon" />
<?php if ($Organisasjon['ID'] > 0) { ?>
    <input type="button" value="Slett" onclick="javascript:document.location.href='http://admis.bomlork.no/index.php/kontakter/slettorganisasjon/<?php echo $Organisasjon['ID']; ?>';" />
<?php } ?>
  </p>
</fieldset>
<?php echo form_close(); ?>
