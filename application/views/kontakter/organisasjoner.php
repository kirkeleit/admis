<h3 class="sub-header">Organisasjoner <?php echo anchor('/kontakter/nyorganisasjon','<span class="glyphicon glyphicon-plus"></span>'); ?></h3>
<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Navn</th>
        <th>Organisasjonsnr</th>
        <th>Telefonnr</th>
        <th>Epost</th>
        <th>Poststed</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Organisasjoner)) {
    foreach ($Organisasjoner as $Organisasjon) {
?>
      <tr>
        <td><?php echo anchor('/kontakter/organisasjon/'.$Organisasjon['OrganisasjonID'],$Organisasjon['Navn']); ?></td>
        <td><?php echo anchor('/kontakter/organisasjon/'.$Organisasjon['OrganisasjonID'],($Organisasjon['Orgnummer'] != '' ? $Organisasjon['Orgnummer'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/kontakter/organisasjon/'.$Organisasjon['OrganisasjonID'],($Organisasjon['Telefonnr'] != '' ? $Organisasjon['Telefonnr'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/kontakter/organisasjon/'.$Organisasjon['OrganisasjonID'],($Organisasjon['Epost'] != '' ? $Organisasjon['Epost'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/kontakter/organisasjon/'.$Organisasjon['OrganisasjonID'],($Organisasjon['Poststed'] != '' ? $Organisasjon['Poststed'] : '&nbsp;')); ?></td>
      </tr>
<?php
    }
  }
?>
    </tbody>
  </table>
</div>
