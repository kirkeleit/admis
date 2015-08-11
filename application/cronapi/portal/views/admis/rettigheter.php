<?php echo form_open(); ?>
<table>
<?php
  if (isset($Roller)) {
    foreach ($Roller as $Rolle) {
?>
  <tr>
    <td colspan="3"><b><?php echo $Rolle['Navn']; ?></b></td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="100" <?php if (in_array('100',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>100</td>
    <td>Generell tilgang</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="200" <?php if (in_array('200',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>200</td>
    <td>Kontakter</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="300" <?php if (in_array('300',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>300</td>
    <td>Økonomi</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="301" <?php if (in_array('301',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>301</td>
    <td>Registrere reiseregninger/utleggsbilag</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="302" <?php if (in_array('302',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>302</td>
    <td>Registrere utgifter/inntekter</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="303" <?php if (in_array('303',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>303</td>
    <td>Vise resultat/budsjett</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="304" <?php if (in_array('304',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>304</td>
    <td>Redigere budsjett</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="305" <?php if (in_array('305',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>305</td>
    <td>Opprette innkjøpsordrer</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="306" <?php if (in_array('306',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>306</td>
    <td>Redigere innkjøpsordrer</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="307" <?php if (in_array('307',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>307</td>
    <td>Godkjenne/avvise innkjøpsordrer</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="400" <?php if (in_array('400',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>400</td>
    <td>Materiell</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="401" <?php if (in_array('401',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>401</td>
    <td>Opprette data</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="402" <?php if (in_array('402',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>402</td>
    <td>Redigere data</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="500" <?php if (in_array('500',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>500</td>
    <td>Prosjekter</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="501" <?php if (in_array('501',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>501</td>
    <td>Kommentere prosjekter</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="502" <?php if (in_array('502',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>502</td>
    <td>Opprette prosjekter</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="503" <?php if (in_array('503',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>503</td>
    <td>Redigere prosjekter</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Tilgang[<?php echo $Rolle['ID']; ?>][]" value="504" <?php if (in_array('504',unserialize($Rolle['UAP']))) { echo "checked "; } ?>/></td>
    <td>504</td>
    <td>Godkjenne/avvise prosjekt</td>
  </tr>
<?php
    }
  }
?>
</table>
<input type="submit" />
<?php echo form_close(); ?>
