<h2><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></h2>
<br />

<?php echo form_open('kontakter/person'); ?>
<input type="hidden" name="PersonID" id="PersonID" value="<?php echo set_value('PersonID',$Person['PersonID']); ?>" />
<input type="hidden" name="AdresseID" id="AdresseID" value="<?php echo set_value('AdresseID',$Person['Adresser'][0]['AdresseID']); ?>" />

<div class="panel panel-default">
  <div class="panel-heading"><h4>Kontaktinfo</h4></div>

  <div class="panel-body">
    <div class="form-group">
      <label for="Fornavn">Navn:</label>
      <input type="text" class="form-control" name="Fornavn" id="Fornavn" value="<?php echo set_value('Fornavn',$Person['Fornavn']); ?>" required />
      <input type="text" class="form-control" name="Etternavn" id="Etternavn" value="<?php echo set_value('Etternavn',$Person['Etternavn']); ?>" required />
    </div>

    <div class="form-group">
      <label for="Initialer">Initialer:</label>
      <input type="text" class="form-control" name="Initialer" id="Initialer" value="<?php echo set_value('Initialer',$Person['Initialer']); ?>" />
    </div>

    <div class="form-group">
      <label for="DatoFodselsdato">Fødselsdato:</label>
      <input type="date" class="form-control" name="DatoFodselsdato" id="DatoFodselsdato" value="<?php echo set_value('DatoFodselsdato',($Person['DatoFodselsdato'] != '0000-00-00' ? date("d.m.Y",strtotime($Person['DatoFodselsdato'])) : '')); ?>" />
    </div>

    <div class="form-group">
      <label for="Mobilnr">Mobilnummer:</label>
      <input type="number" class="form-control" name="Mobilnr" id="Mobilnr" value="<?php echo set_value('Mobilnr',$Person['Mobilnr']); ?>" />
    </div>

    <div class="form-group">
      <label for="Epost">E-postadresse:</label>
      <input type="email" class="form-control" name="Epost" id="Epost" value="<?php echo set_value('Epost',$Person['Epost']); ?>" />
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading"><h4>Adresse</h4></div>

  <div class="panel-body">
    <div class="form-group">
      <label for="Adresse1">Adresse:</label>
      <input type="text" class="form-control" name="Adresse1" id="Adresse1" value="<?php echo set_value('Adresse1',$Person['Adresser'][0]['Adresse1']); ?>" />
      <input type="text" class="form-control" name="Adresse2" id="Adresse2" value="<?php echo set_value('Adresse2',$Person['Adresser'][0]['Adresse2']); ?>" />
    </div>

    <div class="form-group">
      <label for="Postnummer">Postnummer:</label>
      <div class="input-group">
        <input type="number" class="form-control" name="Postnummer" id="Postnummer" maxlength="4" value="<?php echo set_value('Postnummer',$Person['Adresser'][0]['Postnummer']); ?>" aria-describedby="basic-addon2"/>
        <span class="input-group-addon" id="basic-addon2"><?php echo $Person['Adresser'][0]['Poststed']; ?></span>
      </div>
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading"><h4>Medlemsinfo</h4></div>

  <div class="panel-body">
    <div class="checkbox">
      <label for="Alarmgruppe">
        <input type="checkbox" name="Medlem" id="Medlem" <?php echo set_checkbox('Medlem',0,($Person['Medlem'] == 1) ? TRUE : FALSE); ?>/>
        Er medlem
      </label>
    </div>

    <div class="form-group">
      <label for="Relasjonsnummer">Relasjonsnr:</label>
      <input type="number" class="form-control" name="Relasjonsnummer" id="Relasjonsnummer" value="<?php echo set_value('Relasjonsnummer',$Person['Relasjonsnummer']); ?>" />
    </div>

    <div class="form-group">
      <label for="DatoMedlemsdato">Medlem fra:</label>
      <input type="date" class="form-control" name="DatoMedlemsdato" id="DatoMedlemsdato" value="<?php echo set_value('DatoMedlemsdato',($Person['DatoMedlemsdato'] != '0000-00-00' ? date("d.m.Y",strtotime($Person['DatoMedlemsdato'])) : '')); ?>" />
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading"><h4>Medlemsgrupper</h4></div>

  <div class="table-responsive">
    <table class="table table-striped table-hover table-condensed">
      <thead>
        <tr>
          <th>Medlemsgruppe</th>
          <th>Fjern</th>
        </tr>
      </thead>
      <tbody>
<?php
  if (isset($Person['Medlemsgrupper'])) {
    foreach ($Person['Medlemsgrupper'] as $Gruppe) {
?>
        <tr>
          <td><?php echo $Gruppe['Navn']; ?></td>
          <td><input type="checkbox" name="FjernMedlemsgruppeID[]" value="<?php echo $Gruppe['GruppeID']; ?>" /></td>
        </tr>
<?php
    }
  }
?>
      </tbody>
    </table>
  </div>

  <div class="panel-footer">
    <select name="NyMedlemsgruppeID">
      <option value="0">Legg til i medlemsgruppe</option>
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
  </div>
</div>

<div class="form-group">
    <input type="submit" class="btn btn-default" value="Lagre" id="LagrePerson" name="PersonLagre" />
<?php if ($Person['PersonID'] > 0) { ?>
    <!--<input type="button" value="Slett" onclick="javascript:document.location.href='<?php echo site_url(); ?>/kontakter/slettperson/<?php echo $Person['PersonID']; ?>';" />-->
<?php } ?>
  </div>
<?php echo form_close(); ?>
