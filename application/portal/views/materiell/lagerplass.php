<?php echo form_open('materiell/lagerplass'); ?>
<input type="hidden" name="ID" value="<?php echo set_value('ID',$Lagerplass['ID']); ?>" />
<fieldset>
  <legend>Lagerplass</legend>

  <p>
    <label for="Navn">Navn:</label>
    <input type="text" name="Navn" id="Navn" value="<?php echo set_value('Navn',$Lagerplass['Navn']); ?>" />
  </p>

  <p>
    <label for="Kode">Kode:</label>
    <input type="text" name="Kode" id="Kode" value="<?php echo set_value('Kode',$Lagerplass['Kode']); ?>" />
  </p>

  <p>
    <label for="Beskrivelse">Beskrivelse:</label>
    <textarea name="Beskrivelse" id="Beskrivelse"><?php echo set_value('Beskrivelse',$Lagerplass['Beskrivelse']); ?></textarea>
  </p>

  <p class="handlinger">
    <label>&nbsp;</label>
    <input type="submit" value="Lagre lagerplass" />
  </p>
</fieldset>
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
      <option value="<?php echo $Kasse['ID']; ?>"><?php echo $Kasse['Navn']." (".$Kasse['Antall'].")"; ?></option>
<?php
  }
?>
    </select><input type="submit" value="Vis" />
  </p>
</form>

<?php if (isset($Utstyrsliste)) { ?>
  <table>
    <tr>
      <th>UID</th>
      <th>Type</th>
      <th>Produsent</th>
      <th>Modell</th>
      <th>Dato</th>
      <th>Status</th>
    </tr>
<?php
  foreach ($Utstyrsliste as $Utstyr) {
?>
    <tr>
      <td><a href="<?php echo site_url(); ?>/materiell/utstyr/<?php echo $Utstyr['ID']; ?>"><?php echo $Utstyr['UID']; ?></a></td>
      <td><?php if (isset($Utstyr['Type']['Navn'])) { echo $Utstyr['Type']['Navn']; } else { echo "&nbsp"; } ?></td>
      <td><?php if (isset($Utstyr['Produsent']['Navn'])) { echo $Utstyr['Produsent']['Navn']; } else { echo "&nbsp;"; } ?></td>
      <td><?php echo $Utstyr['Modell']; ?></td>
      <td><?php echo $Utstyr['DatoAnskaffet']; ?></td>
      <td><?php echo $Utstyr['Status']; ?></td>
    </tr>
<?php
  }
?>
  </table>
<?php } ?>
</fieldset>
