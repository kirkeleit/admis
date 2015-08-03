<?php echo form_open('kontakter/medlemsgruppe'); ?>
<input type="hidden" name="GruppeID" id="GruppeID" value="<?php echo set_value('GruppeID',$Gruppe['GruppeID']); ?>" />
<fieldset>
  <p>
    <label for="Navn">Navn:</label>
    <input type="text" name="Navn" id="Navn" value="<?php echo set_value('Navn',$Gruppe['Navn']); ?>" />
  </p>

  <p>
    <label for="Beskrivelse" style="vertical-align: top">Beskrivelse:</label>
    <textarea name="Beskrivelse" id="Beskrivelse"><?php echo set_value('Beskrivelse',$Gruppe['Beskrivelse']); ?></textarea>
  </p>

  <p>
    <label for="Kompetansekrav">Kompetansekrav:</label>
    <table>
<?php
  if (isset($Gruppe['Kompetansekrav'])) {
  foreach ($Gruppe['Kompetansekrav'] as $Kompetanse) {
?>
      <tr>
        <td><?php echo $Kompetanse['Navn']; ?></td>
      </tr>
<?php
  }
  }
?>
    </table>
  </p>

  <p>
    <label for="Alarmgruppe">Alarmgruppe:</label>
    <input type="checkbox" name="Alarmgruppe" id="Alarmgruppe" <?php echo set_checkbox('Alarmgruppe',0,($Gruppe['Alarmgruppe'] == 1) ? TRUE : FALSE); ?>/>
  </p>

  <p class="handlinger">
    <label>&nbsp;</label>
    <input type="submit" value="Lagre" name="GruppeLagre" />
  </p>
</fieldset>
<?php echo form_close(); ?>

<table class="liste">
  <tr>
    <th>Navn</th>
    <th>Mobilnr</th>
    <th>Epost</th>
    <th>Alder</th>
    <th>Godkjent</th>
  </tr>
<?php
  foreach ($Gruppe['Personer'] as $Person) {
?>
  <tr>
    <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],$Person['Fornavn']." ".$Person['Etternavn']); ?></td>
    <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],$Person['Mobilnr']); ?></td>
    <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],$Person['Epost']); ?></td>
    <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],$Person['Alder']); ?></td>
    <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],(isset($Gruppe['Kompetansekrav']) ? ($Person['Godkjent'] == 1 ? 'Ja' : 'Nei') : '-')); ?></td>
  </tr>
<?php
  }
?>
</table>
