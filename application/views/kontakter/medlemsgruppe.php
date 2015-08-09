<h3 class="sub-header">Medlemsgruppe</h3>

<?php echo form_open('kontakter/medlemsgruppe/'.$Gruppe['GruppeID']); ?>
<input type="hidden" name="GruppeID" id="GruppeID" value="<?php echo set_value('GruppeID',$Gruppe['GruppeID']); ?>" />
<div class="panel panel-default">
  <div class="panel-heading">Medlemsgruppe</div>

  <div class="panel-body">
    <div class="form-group">
      <label for="Navn">Navn:</label>
      <input type="text" class="form-control" name="Navn" id="Navn" value="<?php echo set_value('Navn',$Gruppe['Navn']); ?>" />
    </div>

    <div class="form-group">
      <label for="Beskrivelse" style="vertical-align: top">Beskrivelse:</label>
      <textarea name="Beskrivelse" class="form-control" id="Beskrivelse"><?php echo set_value('Beskrivelse',$Gruppe['Beskrivelse']); ?></textarea>
    </div>

    <div class="checkbox">
      <label for="Alarmgruppe">
        <input type="checkbox" name="Alarmgruppe" id="Alarmgruppe" <?php echo set_checkbox('Alarmgruppe',0,($Gruppe['Alarmgruppe'] == 1) ? TRUE : FALSE); ?>/>
        Alarmgruppe
      </label>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Lagre" name="GruppeLagre" />
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Kompetansekrav</div>

  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover table-condensed">
        <thead>
          <tr>
            <th>Kompetanse</th>
            <th>Fjern</th>
          </tr>
        </thead>
        <tbody>
<?php
  if (isset($Gruppe['Kompetansekrav'])) {
    foreach ($Gruppe['Kompetansekrav'] as $Kompetanse) {
?>
          <tr>
            <td><?php echo $Kompetanse['Navn']; ?></td>
            <td class="text-center"><input type="checkbox" name="FjernKompetansekrav[]" value="<?php echo $Kompetanse['KompetanseID']; ?>" /></td>
          </tr>
<?php
    }
  } else {
?>
        <tr>
          <td colspan="2">Ingen kompetansekrav lagt inn.</td>
        </tr>
<?php
  }
?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="panel-footer">
    <div class="form-group">
      <div class="input-group">
        <select name="NyttKompetanseKrav" class="form-control">
          <option value="0">(ikke valgt)</option>
<?php
  if (isset($Kompetanseliste)) {
    foreach ($Kompetanseliste as $Kompetanse) {
?>
        <option value="<?php echo $Kompetanse['KompetanseID']; ?>"><?php echo $Kompetanse['Navn']; ?></option>
<?php
    }
  }
?>
        </select>
        <span class="input-group-btn">
          <input type="submit" class="btn btn-default" name="GruppeOppdaterKompetansekrav" value="Legg til" />
        </span>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>

<div class="panel panel-default">
  <div class="panel-heading">Personer</div>

  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover table-condensed">
        <thead>
          <tr>
            <th>Navn</th>
            <th>Mobilnr</th>
            <th>Epost</th>
            <th>Alder</th>
            <th>Godkjent</th>
            <th>Fjern</th>
          </tr>
        </thead>
        <tbody>
<?php
  if (isset($Gruppe['Personer'])) {
    foreach ($Gruppe['Personer'] as $Person) {
?>
          <tr>
            <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],$Person['Fornavn']." ".$Person['Etternavn']); ?></td>
            <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],$Person['Mobilnr']); ?></td>
            <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],$Person['Epost']); ?></td>
            <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],$Person['Alder']); ?></td>
            <td class="<?php echo ($Person['Godkjent'] == 0 ? 'danger' : 'success'); ?>"><?php echo anchor('/kontakter/person/'.$Person['PersonID'],(isset($Gruppe['Kompetansekrav']) ? ($Person['Godkjent'] == 1 ? 'Ja' : 'Nei') : '-')); ?></td>
            <td class="text-center"><input type="checkbox"></td>
          </tr>
<?php
    }
  } else {
?>
          <tr>
            <td colspan="6">Ingen medlemmer i gruppen.</td>
          </tr>
<?php
  }
?>
        </tbody>
      </table>
    </div>
  </div>
</div>
