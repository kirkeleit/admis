<fieldset>
  <legend>Faggruppe</legend>

  <p>
    <label for="Navn">Navn:</label>
    <input type="text" name="Navn" id="Navn" value="<?php echo set_value('Navn',$Faggruppe['Navn']); ?>" />
  </p>

<?php if (isset($Faggruppe['PersonLederID'])) { ?>
  <p>
    <label for="Leder">Leder:</label>
    <a href="<?php echo site_url(); ?>/kontakter/person/<?php echo $Faggruppe['PersonLederID']; ?>"><?php echo $Faggruppe['PersonLederNavn']; ?></a>
  </p>
<?php } ?>

<?php if (isset($Faggruppe['PersonNestlederID'])) { ?>
  <p>
    <label for="NestlederID">Nestleder:</label>
    <a href="<?php echo site_url(); ?>/kontakter/person/<?php echo $Faggruppe['PersonNestlederID']; ?>"><?php echo $Faggruppe['PersonNestlederNavn']; ?></a>
  </p>
<?php } ?>

  <p>
    <label for="Beskrivelse">Beskrivelse:</label>
    <?php echo $Faggruppe['Beskrivelse']; ?>
  </p>
</fieldset>

<fieldset>
  <legend>Prosjekter</legend>

  <table>
    <tr>
      <th>År</th>
      <th>Navn</th>
      <th>Ansvarlig</th>
      <th>Kostnad</th>
      <th>Status</th>
    </tr>
<?php
  if (isset($Prosjekter)) {
    foreach ($Prosjekter as $Prosjekt) {
?>
    <tr>
      <td><?php echo $Prosjekt['ProsjektAr']; ?></td>
      <td><a href="<?php echo site_url(); ?>/prosjekter/prosjekt/<?php echo $Prosjekt['ProsjektID']; ?>"><?php echo $Prosjekt['Prosjektnavn']; ?></a></td>
      <td><?php echo $Prosjekt['PersonAnsvarligID']; ?></td>
      <td><?php echo $Prosjekt['KostnadTotal']; ?></td>
      <td><?php echo $Prosjekt['Status']; ?></td>
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
  </table>
</fieldset>

<fieldset>
  <legend>Utstyr</legend>

  <table>
    <tr>
      <th>ID</th>
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
      <td><a href="<?php echo site_url(); ?>/materiell/utstyr/<?php echo $Utstyr['ID']; ?>"><?php echo $Utstyr['ID']; ?></a></td>
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
</fieldset>
