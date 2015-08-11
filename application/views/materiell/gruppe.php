<h3 class="sub-header">Gruppedetaljer</h3>

<?php echo form_open('materiell/gruppe/'.$Gruppe['GruppeID']); ?>
<input type="hidden" name="GruppeID" value="<?php echo set_value('GruppeID',$Gruppe['GruppeID']); ?>" />
<div class="panel panel-default">
  <div class="panel-heading">&nbsp;</div>

  <div class="panel-body">
    <div class="form-group">
      <label for="Navn">Navn:</label>
      <input type="text" name="Navn" id="Navn" class="form-control" value="<?php echo set_value('Navn',$Gruppe['Navn']); ?>" />
    </div>

    <div class="form-group">
      <label for="Beskrivelse">Beskrivelse:</label>
      <textarea name="Beskrivelse" id="Beskrivelse" class="form-control"><?php echo set_value('Beskrivelse',$Gruppe['Beskrivelse']); ?></textarea>
    </div>
  </div>

  <div class="panel-footer">
    <div class="input-group">
      <input type="submit" class="btn btn-primary" value="Lagre gruppe" />
    </div>
  </div>
</div>
<?php echo form_close(); ?>

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
