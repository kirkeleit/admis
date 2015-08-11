<h3 class="sub-header">Lagerplassdetaljer</h3>

<?php echo form_open('materiell/lagerplass/'.$Lagerplass['LagerplassID']); ?>
<input type="hidden" name="LagerplassID" value="<?php echo set_value('LagerplassID',$Lagerplass['LagerplassID']); ?>" />
<div class="panel panel-default">
  <div class="panel-heading">&nbsp;</div>

  <div class="panel-body">
    <div class="form-group">
      <label for="Navn">Navn:</label>
      <input type="text" name="Navn" class="form-control" id="Navn" value="<?php echo set_value('Navn',$Lagerplass['Navn']); ?>" />
    </div>

    <div class="form-group">
      <label for="Kode">Kode:</label>
      <input type="text" name="Kode" class="form-control" id="Kode" value="<?php echo set_value('Kode',$Lagerplass['Kode']); ?>" />
    </div>

    <div class="form-group">
      <label for="Beskrivelse">Beskrivelse:</label>
      <textarea name="Beskrivelse" class="form-control" id="Beskrivelse"><?php echo set_value('Beskrivelse',$Lagerplass['Beskrivelse']); ?></textarea>
    </div>
  </div>

  <div class="panel-footer">
    <div class="input-group">
      <input type="submit" class="btn btn-primary" value="Lagre lagerplass" />
    </div>
  </div>
</div>
<?php echo form_close(); ?>

<fieldset>
  <legend>Utstyr</legend>

<form method="GET">
  <p>
    <label>Kasse:</label>
    <select name="fkasseid">
      <option value="-1" selected>(alle)</option>
      <option value="0">(uten kasse)</option>
<?php
  foreach ($Kasser as $Kasse) {
?>
      <option value="<?php echo $Kasse['KasseID']; ?>"><?php echo $Kasse['Navn']." (".$Kasse['Antall'].")"; ?></option>
<?php
  }
?>
    </select><input type="submit" value="Vis" />
  </p>
</form>

<?php if (isset($Utstyrsliste)) { ?>
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
            <th>Plass</th>
            <th>Kasse</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
<?php
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
?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php } ?>
