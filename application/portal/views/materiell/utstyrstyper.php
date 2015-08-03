<a href="<?php echo site_url(); ?>/materiell/nyutstyrstype">Ny utstyrstype</a><br />
<br />
<table>
  <tr>
    <th>Navn</th>
    <th>Antall</th>
  </tr>
<?php
  if (isset($Typer)) {
    foreach ($Typer as $Type) {
?>
  <tr>
    <td><a href="<?php echo site_url(); ?>/materiell/utstyrstype/<?php echo $Type['ID']; ?>"><?php echo $Type['Navn']; ?></a></td>
    <td><?php echo $Type['Antall']; ?> stk</td>
  </tr>
<?php
    }
  }
?>
</table>
