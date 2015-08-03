<h3>Organisasjoner [<?php echo sizeof($Organisasjoner); ?>]</h3>
<table class="liste">
  <tr>
    <th>Navn</th>
    <th>Organisasjonsnr</th>
    <th>Telefonnr</th>
    <th>Epost</th>
    <th>Poststed</th>
  </tr>
<?php
  if (isset($Organisasjoner)) {
    foreach ($Organisasjoner as $Organisasjon) {
?>
  <tr>
    <td><?php echo anchor('/kontakter/organisasjon/'.$Organisasjon['OrganisasjonID'],$Organisasjon['Navn']); ?></a></td>
    <td><?php echo anchor('/kontakter/organisasjon/'.$Organisasjon['OrganisasjonID'],($Organisasjon['Orgnummer'] != '' ? $Organisasjon['Orgnummer'] : '&nbsp;')); ?></td>
    <td><?php echo anchor('/kontakter/organisasjon/'.$Organisasjon['OrganisasjonID'],($Organisasjon['Telefonnr'] != '' ? $Organisasjon['Telefonnr'] : '&nbsp;')); ?></td>
    <td><?php echo anchor('/kontakter/organisasjon/'.$Organisasjon['OrganisasjonID'],($Organisasjon['Epost'] != '' ? $Organisasjon['Epost'] : '&nbsp;')); ?></td>
    <td><?php echo anchor('/kontakter/organisasjon/'.$Organisasjon['OrganisasjonID'],($Organisasjon['Poststed'] != '' ? $Organisasjon['Poststed'] : '&nbsp;')); ?></td>
  </tr>
<?php
    }
  }
?>
</table>
