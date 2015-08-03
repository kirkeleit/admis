<?php
  if (in_array('304',$UABruker['UAP'])) {
?>
<?php echo form_open(); ?>
Budsjettår: <input type="year" name="BudsjettAr" value="<?php echo date("Y"); ?>" />
<br />
<br />
<table>
  <tr>
    <th>Konto</th>
<?php
  $i = 0;
  foreach ($Aktiviteter as $Aktivitet) {
?>
    <th><?php echo $Aktivitet['ID']." ".$Aktivitet['Navn']; ?></th>
<?php
  }
?>
  </tr>
  <tr>
    <td colspan="<?php echo (1+sizeof($Aktiviteter)); ?>"><b>Inntekter</b></td>
  </tr>
<?php
  foreach ($KontoerINN as $Konto) {
?>
  <tr>
    <td><span title="<?php echo $Konto['Beskrivelse']; ?>"><?php echo $Konto['ID']." ".$Konto['Navn']; ?></span></td>
<?php
  foreach ($Aktiviteter as $Aktivitet) {
?>
    <td><input type="hidden" name="Konto[<?php echo $i; ?>]" value="<?php echo $Konto['ID']; ?>" /><input type="hidden" name="Aktivitet[<?php echo $i; ?>]" value="<?php echo $Aktivitet['ID']; ?>" /><input type="number" name="Budsjett[<?php echo $i; ?>]" value="<?php echo $Budsjett[$Konto['ID']][$Aktivitet['ID']]; ?>" step="100" style="width:80px;" /></td>
<?php
    $i++;
  }
?>
  </tr>
<?php
  }
?>
  <tr>
    <td colspan="<?php echo (1+sizeof($Aktiviteter)); ?>"><b>Utgifter</b></td>
  </tr>
<?php
  foreach ($KontoerUT as $Konto) {
?>
  <tr>
    <td><?php echo $Konto['ID']." ".$Konto['Navn']; ?></td>
<?php
  foreach ($Aktiviteter as $Aktivitet) {
?>
    <td><input type="hidden" name="Konto[<?php echo $i; ?>]" value="<?php echo $Konto['ID']; ?>" /><input type="hidden" name="Aktivitet[<?php echo $i; ?>]" value="<?php echo $Aktivitet['ID']; ?>" /><input type="number" name="Budsjett[<?php echo $i; ?>]" value="<?php echo $Budsjett[$Konto['ID']][$Aktivitet['ID']]; ?>" step="100" style="width:80px;" /></td>
<?php
    $i++;
  }
?>
  </tr>
<?php
  }
?>
</table>
<input type="submit" value="Lagre">
<?php echo form_close(); ?>
<?php
  } else {
    echo "Ingen tilgang.";
  }
?>
