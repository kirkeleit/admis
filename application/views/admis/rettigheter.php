<?php
  $Rettigheter[100] = "Generell tilgang";
  $Rettigheter[200] = "Kontakter";
  $Rettigheter[300] = "Økonomi";
  $Rettigheter[301] = "Registrere reiseregninger/utleggsbilag";
  $Rettigheter[302] = "Registrere utgifter/inntekter";
  $Rettigheter[303] = "Vise resultat/budsjett";
  $Rettigheter[304] = "Redigere budsjett";
  $Rettigheter[305] = "Opprette innkjøpsordrer";
  $Rettigheter[306] = "Redigere innkjøpsordrer";
  $Rettigheter[307] = "Godkjenne/avvise innkjøpsordrer";
  $Rettigheter[308] = "Vise til utbetaling";
  $Rettigheter[309] = "Godkjenne utlegg/reiseregning til utbetaling";
  $Rettigheter[310] = "Registrere reiseregning/utlegg som utbetalt";
  $Rettigheter[400] = "Materiell";
  $Rettigheter[401] = "Opprette data";
  $Rettigheter[402] = "Redigere data";
  $Rettigheter[500] = "Prosjekter";
  $Rettigheter[501] = "Kommentere prosjekter";
  $Rettigheter[502] = "Opprette prosjekter";
  $Rettigheter[503] = "Redigere prosjekter";
  $Rettigheter[504] = "Godkjenne/avvise prosjekt";
  $Rettigheter[600] = "Oppgaver";
  $Rettigheter[800] = "Rådet";
  $Rettigheter[801] = "Opprette og redigere rådssaker";
  $Rettigheter[802] = "Kommentere rådssaker";
  $Rettigheter[803] = "Godkjenne rådssaker";
?>
<?php echo form_open(); ?>
<table>
  <tr>
    <td>ID</td>
    <td>Beskrivelse</td>
<?php
  foreach ($Roller as $Rolle) {
?>
    <td><?php echo $Rolle['Navn']; ?></td>
<?php
  }
?>
  </tr>
<?php
  foreach ($Rettigheter as $ID => $Beskrivelse) {
?>
  <tr>
    <td><?php echo $ID; ?></td>
    <td><?php echo $Beskrivelse; ?></td>
<?php
  foreach ($Roller as $Rolle) {
?>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="<?php echo $ID; ?>" <?php if (in_array($ID,unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
<?php
  }
?>
  </tr>
<?php
  }
?>
</table>
<input type="submit" />
<?php echo form_close(); ?>
