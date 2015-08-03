<h3>Kontaktpersoner [<?php echo sizeof($Personer); ?>]</h3>
<table class="liste">
  <tr>
    <th>Navn</th>
    <th>Mobilnr</th>
    <th>Epost</th>
    <th>Poststed</th>
    <th>Alder</th>
  </tr>
<?php
  if (isset($Personer)) {
    foreach ($Personer as $Person) {
?>
  <tr>
    <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],$Person['Fornavn']." ".$Person['Etternavn']); ?></a></td>
    <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],($Person['Mobilnr'] != '' ? $Person['Mobilnr'] : '&nbsp;')); ?></td>
    <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],($Person['Epost'] != '' ? $Person['Epost'] : '&nbsp;')); ?></td>
    <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],($Person['Poststed'] != '' ? $Person['Poststed'] : '&nbsp;')); ?></td>
    <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],($Person['Alder'] != '' ? $Person['Alder'] : '&nbsp;')); ?></td>
  </tr>
<?php
    }
  }
?>
</table>
