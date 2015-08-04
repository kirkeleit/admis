<form class="form-horizontal" role="form" method="post" action="<?php echo site_url('kontakter/organisasjon'); ?>">
<input type="hidden" name="OrganisasjonID" id="OrganisasjonID" value="<?php echo set_value('OrganisasjonID',$Organisasjon['OrganisasjonID']); ?>" />

  <div class="form-group">
    <label for="Navn">Navn:</label>
    <input type="text" class="form-control" name="Navn" id="Navn" value="<?php echo set_value('Navn',$Organisasjon['Navn']); ?>" />
  </div>

  <div class="form-group">
    <label for="Orgnummer">Orgnummer:</label>
    <input type="number" class="form-control" name="Orgnummer" id="Orgnummer" value="<?php echo set_value('Orgnummer',$Organisasjon['Orgnummer']); ?>" />
  </div>

  <div class="form-group">
    <label for="Telefonnr">Telefonnr:</label>
    <input type="number" class="form-control" name="Telefonnr" id="Telefonnr" value="<?php echo set_value('Telefonnr',$Organisasjon['Telefonnr']); ?>" />
  </div>

  <div class="form-group">
    <label for="Epost">Epost:</label>
    <input type="email" class="form-control" name="Epost" id="Epost" value="<?php echo set_value('Epost',$Organisasjon['Epost']); ?>" />
  </div>

<input type="hidden" name="AdresseID" id="AdresseID" value="<?php echo set_value('AdresseID',$Organisasjon['Adresser'][0]['AdresseID']); ?>" />
  <div class="form-group">
    <label for="Adresse1">Adresse:</label>
    <input type="text" class="form-control" name="Adresse1" id="Adresse1" value="<?php echo set_value('Adresse1',$Organisasjon['Adresser'][0]['Adresse1']); ?>" />
    <input type="text" class="form-control" name="Adresse2" id="Adresse2" value="<?php echo set_value('Adresse2',$Organisasjon['Adresser'][0]['Adresse2']); ?>" />
  </div>

  <div class="form-group">
    <label for="Postnummer">Postnummer:</label>
    <input type="number" class="form-control" name="Postnummer" id="Postnummer" maxlength="4" value="<?php echo set_value('Postnummer',$Organisasjon['Adresser'][0]['Postnummer']); ?>" />&nbsp;<?php echo $Organisasjon['Adresser'][0]['Poststed']; ?>
  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-default" value="Lagre" id="LagreOrganisasjon" name="OrganisasjonLagre" />
<?php if ($Organisasjon['OrganisasjonID'] > 0) { ?>
    <input type="button" value="Slett" onclick="javascript:document.location.href='http://admis.bomlork.no/index.php/kontakter/slettorganisasjon/<?php echo $Organisasjon['OrganisasjonID']; ?>';" />
<?php } ?>
  </div>

</form>
