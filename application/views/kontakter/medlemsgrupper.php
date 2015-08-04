<h3 class="sub-header">Medlemsgrupper</h3>
<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Navn</th>
        <th>Antall</th>
        <th>Alarmgruppe</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Grupper)) {
    foreach ($Grupper as $Gruppe) {
?>
      <tr>
        <td><?php echo anchor('/kontakter/medlemsgruppe/'.$Gruppe['GruppeID'],$Gruppe['Navn']); ?></td>
        <td><?php echo anchor('/kontakter/medlemsgruppe/'.$Gruppe['GruppeID'],$Gruppe['Antall']); ?></td>
        <td><?php echo anchor('/kontakter/medlemsgruppe/'.$Gruppe['GruppeID'],($Gruppe['Alarmgruppe'] == 1 ? 'Ja' : 'Nei')); ?></td>
      </tr>
<?php
    }
  }
?>
    </tbody>
  </table>
</div>
