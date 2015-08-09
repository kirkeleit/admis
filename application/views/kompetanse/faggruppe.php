<h3 class="sub-header">Faggruppedetaljer</h3>

<?php echo form_open('kompetanse/faggruppe/'.$Faggruppe['FaggruppeID']); ?>
<input type="hidden" name="FaggruppeID" id="FaggruppeID" value="<?php echo set_value('FaggruppeID',$Faggruppe['FaggruppeID']); ?>" />
<div class="panel panel-default">
  <div class="panel-heading">&nbsp;</div>

  <div class="panel-body">

    <div class="form-group">
      <label for="Navn">Navn:</label>
      <input type="text" name="Navn" id="Navn" value="<?php echo set_value('Navn',$Faggruppe['Navn']); ?>" class="form-control" />
    </div>

    <div class="form-group">
      <label for="PersonLederID">Leder:</label>
      <select class="form-control" name="PersonLederID">
        <option value="0" <?php echo set_select('PersonLederID',0,($Faggruppe['PersonLederID'] == 0) ? TRUE : FALSE); ?>>(ingen valgt)</option>
<?php
  foreach ($Personer as $Person) {
?>
        <option value="<?php echo $Person['PersonID']; ?>" <?php echo set_select('PersonID',$Person['PersonID'],($Faggruppe['PersonLederID'] == $Person['PersonID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="PersonNestlederID">Nestleder:</label>
      <select class="form-control" name="PersonNestlederID">
        <option value="0" <?php echo set_select('PersonNestlederID',0,($Faggruppe['PersonNestlederID'] == 0) ? TRUE : FALSE); ?>>(ingen valgt)</option>
<?php
  foreach ($Personer as $Person) {
?>
        <option value="<?php echo $Person['PersonID']; ?>" <?php echo set_select('PersonID',$Person['PersonID'],($Faggruppe['PersonNestlederID'] == $Person['PersonID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="Beskrivelse">Beskrivelse:</label>
      <textarea name="Beskrivelse" class="form-control"><?php echo $Faggruppe['Beskrivelse']; ?></textarea>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Lagre" name="FaggruppeLagre" />
    </div>

  </div>
</div>
<?php echo form_close(); ?>

<div class="panel panel-default">
  <div class="panel-heading">Prosjekter</div>

  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover table-condensed">
        <thead>
          <tr>
            <th>År</th>
            <th>Prosjektnavn</th>
            <th>Prosjektleder</th>
            <th>Budsjettramme</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
<?php
  if (isset($Prosjekter)) {
    foreach ($Prosjekter as $Prosjekt) {
?>
          <tr>
            <td><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],$Prosjekt['ProsjektAr']); ?></td>
            <td><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],$Prosjekt['Prosjektnavn']); ?></td>
            <td><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],($Prosjekt['PersonProsjektlederNavn'] != '' ? $Prosjekt['PersonProsjektlederNavn'] : '&nbsp;')); ?></td>
            <td class="text-right"><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],'kr '.number_format($Prosjekt['Budsjettramme'], 0, ',', '.')); ?></td>
            <td><?php echo anchor('/prosjekter/prosjekt/'.$Prosjekt['ProsjektID'],$Prosjekt['Status']); ?></td>
          </tr>
<?php
    }
  } else {
?>
          <tr>
            <td colspan="5">Ingen prosjekter er registrert på faggruppen.</td>
          </tr>
<?php
  }
?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Utstyrsliste</div>

  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover table-condensed">
        <thead>
          <tr>
            <th>UID</th>
            <th>Type</th>
            <th>Produsent</th>
            <th>Modell</th>
            <th>Dato</th>
            <th>Lagerplass</th>
            <th>Kasse</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
?>
          <tr>
            <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],$Utstyr['UID']); ?></td>
            <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],(isset($Utstyr['TypeNavn']) ? $Utstyr['TypeNavn'] : '&nbsp;')); ?></td>
            <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],(isset($Utstyr['ProdusentNavn']) ? $Utstyr['ProdusentNavn'] : '&nbsp;')); ?></td>
            <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],$Utstyr['Modell']); ?></td>
            <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],date('d.m.Y',strtotime($Utstyr['DatoAnskaffet']))); ?></td>
            <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],(isset($Utstyr['LagerplassNavn']) ? $Utstyr['LagerplassNavn'] : '&nbsp;')); ?></td>
            <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],(isset($Utstyr['KasseNavn']) ? $Utstyr['KasseNavn'] : '&nbsp;')); ?></td>
            <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],$Utstyr['Status']); ?></td>
          </tr>
<?php
    }
  }
?>
        </tbody>
      </table>
    </div>
  </div>
</div>
