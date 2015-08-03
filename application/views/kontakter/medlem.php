<table>
<?php
  if (isset($Medlem)) {
?>
  <tr>
    <td>Fornavn:</td>
    <td><?php echo $Medlem['Fornavn']; ?></td>
  </tr>
  <tr>
    <td>Etternavn:</td>
    <td><?php echo $Medlem['Etternavn']; ?></td>
  </tr>
<?php
  }
?>
</table>
