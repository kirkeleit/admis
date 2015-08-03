<?php
  if (in_array('303',$UABruker['UAP'])) {
    $Inntekter = 0;
    $Utgifter = 0;
?>
<table>
  <tr>
    <th>&nbsp;</th>
<?php foreach ($Aktiviteter as $Aktivitet) { ?>
    <th colspan="2"><?php echo $Aktivitet['AktivitetID']." ".$Aktivitet['Navn']; ?></th>
<?php } ?>
    <th colspan="2">Totalt</th>
  </tr>
  <tr>
    <th>Konto</th>
<?php foreach ($Aktiviteter as $Aktivitet) { ?>
    <th style="border-left: 1px solid black;">Bokført</th>
    <th>Budsjett</th>
<?php } ?>
    <th style="border-left: 2px solid black;">Bokfort</th>
    <th>Budsjett</th>
  </tr>
<?php
  foreach ($Resultat as $ID => $Data) {
    if (isset($Data[0])) {
?>
  <tr>
    <td><?php echo $ID." ".$Data['Navn']; ?></td>
<?php
  $i = 0;
  foreach ($Aktiviteter as $Aktivitet) {
?>
    <td style="border-left: 1px solid black;"><?php echo number_format($Data[$i]['Bokfort'],2,',','.'); ?></td>
    <td><?php echo number_format($Data[$i]['Budsjett'],2,',','.'); ?></td>
<?php
    $i++;
  }
?>
    <td style="border-left: 2px solid black;"><?php echo number_format($Data['Bokfort'],2,',','.'); ?></td>
    <td><?php echo number_format($Data['Budsjett'],2,',','.'); ?></td>
  </tr>
<?php
      if ($Data['Type'] == 0) {
        $Inntekter = $Inntekter + $Data['Bokfort'];
      } elseif ($Data['Type'] == 1) {
        $Utgifter = $Utgifter + $Data['Bokfort'];
      }
    }
  }
?>
  <tr>
    <td colspan="<?php echo ((sizeof($Aktiviteter) * 2) + 1); ?>"><b>Inntekter:</b></td>
    <td><?php echo number_format($Inntekter,2,',','.'); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="<?php echo ((sizeof($Aktiviteter) * 2) + 1); ?>"><b>Utgifter:</b></td>
    <td><?php echo number_format($Utgifter,2,',','.'); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="<?php echo ((sizeof($Aktiviteter) * 2) + 1); ?>"><b>Resultat:</b></td>
    <td><?php echo number_format($Inntekter - $Utgifter,2,',','.'); ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
  } else {
    echo "Ingen tilgang.";
  }
?>
