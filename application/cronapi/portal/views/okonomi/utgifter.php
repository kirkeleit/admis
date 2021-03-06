<h3>Utgifter [<?php echo sizeof($Utgifter); ?>]</h3>
<br />
<table>
  <tr>
    <th>Dato</th>
    <th>Aktivitet</th>
    <th>Konto</th>
    <th>Medlem</th>
    <th>Beskrivelse</th>
    <th>Beløp</th>
    <th>&nbsp;</th>
  </tr>
<?php
  $Totalt = 0;

  if (isset($Utgifter)) {
    foreach ($Utgifter as $Utgift) {
?>
  <tr>
    <td><?php echo $Utgift['DatoBokfort']; ?></td>
    <td><span title="<?php echo $Utgift['Aktivitet']; ?>"><?php echo $Utgift['AktivitetID']; ?></span></td>
    <td><span title="<?php echo $Utgift['Konto']; ?>"><?php echo $Utgift['KontoID']; ?></span></td>
<?php if ($Utgift['PersonID'] > 0) { ?>
    <td><a href="<?php echo site_url(); ?>/kontakter/person/<?php echo $Utgift['PersonID']; ?>" title="<?php echo $Utgift['Person']; ?>"><?php echo $Utgift['PersonInitialer']; ?></a></td>
<?php } else { ?>
    <td>&nbsp;</td>
<?php } ?>
    <td><a href="<?php echo site_url(); ?>/okonomi/utgift/<?php echo $Utgift['ID']; ?>"><?php echo $Utgift['Beskrivelse']; ?></a></td>
    <td style="text-align: right;"><?php echo "kr ".number_format($Utgift['Belop'],2,',','.'); ?></td>
<?php if (!isset($Utgift['Filer'])) { ?>
    <td>&nbsp;</td>
<?php } else { ?>
    <td><img src="/grafikk/icons/picture.png" /></td>
<?php } ?>
  </tr>
<?php
      $Totalt = $Totalt + $Utgift['Belop'];
    }
?>
  <tr>
    <td colspan="7" style="text-align: right;"><b><?php echo "kr ".number_format($Totalt,2,',','.'); ?></b></td>
  </tr>
<?php
  } else {
?>
  <tr>
    <td colspan="7">Ingen utgifter i år!</td>
  </tr>
<?php
  }
?>
</table>

<form method="GET">
<div class="filter">
  <p>
    <label for="far">År:</label>
    <select name="far">
      <option value="2014">2014</option>
      <option value="2015" selected>2015</option>
    </select>
  </p>
  <p>
    <label for="aktivitetid">Aktivitet:</label>
    <select name="faktivitetid">
      <option value="0">(alle)</option>
<?php foreach ($Aktiviteter as $Aktivitet) { ?>
      <option value="<?php echo $Aktivitet['ID']; ?>"><?php echo $Aktivitet['ID']." ".$Aktivitet['Navn']; ?></option>
<?php } ?>
    </select>
  </p>
  <p>
    <label for="fkontoid">Konto:</label>
    <select name="fkontoid">
      <option value="0">(alle)</option>
<?php foreach ($Kontoer as $Konto) { ?>
      <option value="<?php echo $Konto['ID']; ?>"><?php echo $Konto['ID']." ".$Konto['Navn']; ?></option>
<?php } ?>
    </select>
  </p>
  <p>
    <label for="fpersonid">Person:</label>
    <select name="fpersonid">
      <option value="0">(alle)</option>
<?php foreach ($Personer as $Person) { ?>
      <option value="<?php echo $Person['ID']; ?>"><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php } ?>
    </select>
  </p>
  <p>
    <label for="fprosjektid">Prosjekt:</label>
    <select name="fprosjektid">
      <option value="0">(alle)</option>
<?php foreach ($Prosjekter as $Prosjekt) { ?>
      <option value="<?php echo $Prosjekt['ID']; ?>"><?php echo $Prosjekt['Navn']; ?></option>
<?php } ?>
    </select>
  </p>
  <p>
    <input type="submit" value="Filtrer" />
  </p>
</div>
</form>
