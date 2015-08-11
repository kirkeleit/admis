<h3>Organisasjoner [<?php echo sizeof($Organisasjoner); ?>]</h3>
<table>
  <tr>
    <th>Navn</th>
    <th>Organisasjonsnr</th>
    <th>Telefonnr</th>
    <th>Epost</th>
  </tr>
<?php
  if (isset($Organisasjoner)) {
    foreach ($Organisasjoner as $Organisasjon) {
?>
  <tr>
    <td><a href="<?php echo site_url(); ?>/kontakter/organisasjon/<?php echo $Organisasjon['ID']; ?>"><?php echo $Organisasjon['Navn']; ?></a></td>
    <td><?php echo $Organisasjon['Orgnummer']; ?></td>
    <td><?php echo $Organisasjon['Telefonnr']; ?></td>
    <td><?php echo $Organisasjon['Epost']; ?></td>
  </tr>
<?php
    }
  }
?>
</table>
