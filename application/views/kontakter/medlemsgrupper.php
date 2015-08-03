<h3>Grupper</h3>
<table class="liste">
  <tr>
    <th>Navn</th>
    <th>Antall</th>
    <th>Alarmgruppe</th>
  </tr>
<?php
  if (isset($Grupper)) {
    foreach ($Grupper as $Gruppe) {
?>
  <tr>
    <td><?php echo anchor('/kontakter/medlemsgruppe/'.$Gruppe['GruppeID'],$Gruppe['Navn']); ?></a></td>
    <td><?php echo anchor('/kontakter/medlemsgruppe/'.$Gruppe['GruppeID'],$Gruppe['Antall']); ?></td>
    <td><?php echo anchor('/kontakter/medlemsgruppe/'.$Gruppe['GruppeID'],($Gruppe['Alarmgruppe'] == 1 ? 'Ja' : 'Nei')); ?></td>
  </tr>
<?php
    }
  }
?>
</table>
