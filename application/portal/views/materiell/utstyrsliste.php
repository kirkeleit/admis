<table>
  <tr>
    <th>UID</th>
    <th>Gruppe</th>
    <th>Type</th>
    <th>Produsent</th>
    <th>Modell</th>
    <th>DatoAnskaffet</th>
    <th>Status</th>
  </tr>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
?>
  <tr>
    <td><a href="<?php echo site_url(); ?>/materiell/utstyr/<?php echo $Utstyr['ID']; ?>"><?php echo $Utstyr['UID']; ?></a></td>
    <td><?php if (isset($Utstyr['Gruppe']['Navn'])) { echo $Utstyr['Gruppe']['Navn']; } else { echo "&nbsp;"; } ?></td>
    <td><?php if (isset($Utstyr['Type']['Navn'])) { echo $Utstyr['Type']['Navn']; } else { echo "&nbsp;"; } ?></td>
    <td><?php if (isset($Utstyr['Produsent']['Navn'])) { echo $Utstyr['Produsent']['Navn']; } else { echo "&nbsp;"; } ?></td>
    <td><?php echo $Utstyr['Modell']; ?></td>
    <td><?php echo $Utstyr['DatoAnskaffet']; ?></td>
    <td><?php echo $Utstyr['Status']; ?></td>
  </tr>
<?php
    }
  }
?>
</table>
