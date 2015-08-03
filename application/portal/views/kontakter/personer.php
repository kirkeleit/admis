<h3>Kontaktpersoner [<?php echo sizeof($Personer); ?>]</h3>
<table>
  <tr>
    <th>Navn</th>
    <th>Mobilnr</th>
    <th>Epost</th>
    <th>Medlem</th>
    <th>Bruker</th>
    <th>Alder</th>
  </tr>
<?php
  if (isset($Personer)) {
    foreach ($Personer as $Person) {
?>
  <tr>
    <td><a href="<?php echo site_url(); ?>/kontakter/person/<?php echo $Person['ID']; ?>"><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></a></td>
    <td><?php echo $Person['Mobilnr']; ?></td>
    <td><?php echo $Person['Epost']; ?></td>
    <td><?php if ($Person['Medlem'] == 1) { echo "Ja"; } else { echo "Nei"; } ?></td>
    <td><?php if ($Person['Bruker'] == 1) { echo "Ja"; } else { echo "Nei"; } ?></td>
    <td><?php echo $Person['Alder']; ?></td>
  </tr>
<?php
    }
  }
?>
</table>
