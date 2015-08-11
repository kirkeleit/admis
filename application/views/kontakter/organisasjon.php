<h3 class="sub-header">Organisasjonsdetaljer</h3>

<?php echo form_open('kontakter/organisasjon/'.$Organisasjon['OrganisasjonID']); ?>
<input type="hidden" name="OrganisasjonID" id="OrganisasjonID" value="<?php echo set_value('OrganisasjonID',$Organisasjon['OrganisasjonID']); ?>" />
<div class="panel panel-default">
  <div class="panel-heading">&nbsp;</div>

  <div class="panel-body">
    <div class="form-group">
      <label for="Navn">Navn:</label>
      <input type="text" class="form-control" name="Navn" id="Navn" value="<?php echo set_value('Navn',$Organisasjon['Navn']); ?>" />
    </div>

    <div class="form-group">
      <label for="Orgnummer">Organisasjonsnummer:</label>
      <input type="number" class="form-control" name="Orgnummer" id="Orgnummer" value="<?php echo set_value('Orgnummer',$Organisasjon['Orgnummer']); ?>" />
    </div>

    <div class="form-group">
      <label for="Telefonnr">Telefonnummer:</label>
      <input type="number" class="form-control" name="Telefonnr" id="Telefonnr" value="<?php echo set_value('Telefonnr',$Organisasjon['Telefonnr']); ?>" />
    </div>

    <div class="form-group">
      <label for="Epost">E-postadresse:</label>
      <input type="email" class="form-control" name="Epost" id="Epost" value="<?php echo set_value('Epost',$Organisasjon['Epost']); ?>" />
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">Adresse</div>

      <div class="panel-body">
        <input type="hidden" name="AdresseID" id="AdresseID" value="<?php echo set_value('AdresseID',$Organisasjon['Adresser'][0]['AdresseID']); ?>" />
        <div class="form-group">
          <label for="Adresse1">Adresse:</label>
          <input type="text" class="form-control" name="Adresse1" id="Adresse1" value="<?php echo set_value('Adresse1',$Organisasjon['Adresser'][0]['Adresse1']); ?>" />
          <input type="text" class="form-control" name="Adresse2" id="Adresse2" value="<?php echo set_value('Adresse2',$Organisasjon['Adresser'][0]['Adresse2']); ?>" />
        </div>

        <div class="form-group">
          <label for="Postnummer">Postnummer:</label>
          <div class="input-group">
            <input type="number" class="form-control" name="Postnummer" id="basic-addon2" maxlength="4" value="<?php echo set_value('Postnummer',$Organisasjon['Adresser'][0]['Postnummer']); ?>" aria-describedby="basic-addon2"  />
            <span class="input-group-addon" id="basic-addon2"><?php echo $Organisasjon['Adresser'][0]['Poststed']; ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="panel-footer">
    <div class="input-group">
      <div class="btn-group" role="group">
        <input type="submit" class="btn btn-primary" value="Lagre" id="LagreOrganisasjon" name="OrganisasjonLagre" />
      </div>
    </div>

  </div>
</div>
<?php echo form_close(); ?>
