<?php echo form_open('materiell/utstyrstype'); ?>
<input type="hidden" name="ID" value="<?php echo set_value('ID',$Type['ID']); ?>" />
<fieldset>
  <legend>Utstyrstype</legend>

  <p>
    <label for="Navn">Navn:</label>
    <input type="text" name="Navn" id="Navn" value="<?php echo set_value('Navn',$Type['Navn']); ?>" />
  </p>

  <p class="handlinger">
    <label>&nbsp;</label>
    <input type="submit" value="Lagre" />
  </p>
</fieldset>
<?php echo form_close(); ?>

<?php if (isset($Utstyrsliste)) { ?>
<fieldset>
  <legend>Utstyr</legend>

  <table>
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
<?php
  foreach ($Utstyrsliste as $Utstyr) {
?>
    <tr>
      <td><a href="<?php echo site_url(); ?>/materiell/utstyr/<?php echo $Utstyr['ID']; ?>"><?php echo $Utstyr['UID']; ?></a></td>
      <td><?php if (isset($Utstyr['Type'])) { echo $Utstyr['Type']['Navn']; } else { echo "&nbsp;"; } ?></td>
      <td><?php if (isset($Utstyr['Produsent'])) { echo $Utstyr['Produsent']['Navn']; } else { echo "&nbsp;"; } ?></td>
      <td><?php echo $Utstyr['Modell']; ?></td>
      <td><?php echo $Utstyr['DatoAnskaffet']; ?></td>
      <td><?php if (isset($Utstyr['Lagerplass'])) { echo $Utstyr['Lagerplass']['Navn']; } else { echo "&nbsp;"; } ?></td>
      <td><?php if (isset($Utstyr['Kasse'])) { echo $Utstyr['Kasse']['Navn']; } else { echo "&nbsp;"; } ?></td>
      <td><?php echo $Utstyr['Status']; ?></td>
    </tr>
<?php
  }
?>
  </table>
</fieldset>
<?php } ?>
