<h3 class="sub-header">Faggrupper</h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Navn</th>
        <th>Leder</th>
        <th>Nestleder</th>
        <th>Utstyr</th>
        <th>Prosjekter</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Faggrupper)) {
    foreach ($Faggrupper as $Faggruppe) {
?>
      <tr>
        <td><?php echo anchor('/kompetanse/faggruppe/'.$Faggruppe['FaggruppeID'],$Faggruppe['Navn']); ?></td>
        <td><?php echo anchor('/kompetanse/faggruppe/'.$Faggruppe['FaggruppeID'],($Faggruppe['PersonLederNavn'] != '' ? $Faggruppe['PersonLederNavn'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/kompetanse/faggruppe/'.$Faggruppe['FaggruppeID'],($Faggruppe['PersonNestlederNavn'] != '' ? $Faggruppe['PersonNestlederNavn'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/kompetanse/faggruppe/'.$Faggruppe['FaggruppeID'],$Faggruppe['UtstyrAntall']); ?></td>
        <td><?php echo anchor('/kompetanse/faggruppe/'.$Faggruppe['FaggruppeID'],$Faggruppe['ProsjekterAntall']); ?></td>
      </tr>
<?php
    }
  } else {
?>
  <tr>
    <td colspan="5">Ingen faggrupper er registrert.</td>
  </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
