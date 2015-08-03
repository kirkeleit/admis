<?php echo form_open(); ?>
<input type="hidden" name="PersonID" value="<?php echo $UABruker['ID']; ?>" />
<table>
  <tr>
    <th>Leverandør</th>
    <th>Varenr</th>
    <th>Varenavn</th>
    <th>Antall</th>
    <th>Rest</th>
    <th>Levert</th>
  </tr>
<?php
  if (isset($Varelinjer)) {
    foreach ($Varelinjer as $Linje) {
?>
  <tr>
    <td><?php echo $Linje['Ordre']['LeverandorNavn']; ?></td>
    <td><?php echo $Linje['Varenummer']; ?></td>
    <td><?php echo $Linje['Varenavn']; ?></td>
    <td><?php echo $Linje['Antall']." stk"; ?></td>
    <td><?php echo $Linje['Antall']-$Linje['Levert']; ?> stk</td>
    <td><input type="number" name="Levert[<?php echo $Linje['LinjeID']; ?>]" value="0" step="1" min="0" max="<?php echo $Linje['Antall']-$Linje['Levert']; ?>" /></td>
  </tr>
<?php
    }
  }
?>
</table>
<input type="submit" value="Registrere" />&nbsp;<input type="reset" value="Angre" />
<?php echo form_close(); ?>
