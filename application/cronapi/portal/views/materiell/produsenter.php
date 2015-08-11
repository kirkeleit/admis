<a href="<?php echo site_url(); ?>/materiell/nyprodusent">Ny produsent</a><br />
<br />
<table>
  <tr>
    <th>Navn</th>
    <th>Antall</th>
  </tr>
<?php
  if (isset($Produsenter)) {
    foreach ($Produsenter as $Produsent) {
?>
  <tr>
    <td><a href="<?php echo site_url(); ?>/materiell/produsent/<?php echo $Produsent['ID']; ?>"><?php echo $Produsent['Navn']; ?></a></td>
    <td><?php echo $Produsent['Antall']; ?> stk</td>
  </tr>
<?php
    }
  }
?>
</table>
