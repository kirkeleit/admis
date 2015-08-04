<h3 class="sub-header">Utgifter</h3>
<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Dato</th>
        <th>Aktivitet</th>
        <th>Konto</th>
        <th>Medlem</th>
        <th>Beskrivelse</th>
        <th>Beløp</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
<?php
  $Totalt = 0;

  if (isset($Utgifter)) {
    foreach ($Utgifter as $Utgift) {
?>
      <tr>
        <td><?php echo anchor('/okonomi/utgift/'.$Utgift['UtgiftID'],$Utgift['DatoBokfort']); ?></td>
        <td><?php echo anchor('/okonomi/utgift/'.$Utgift['UtgiftID'],$Utgift['AktivitetID'],'title="'.$Utgift['Aktivitet'].'"'); ?></td>
        <td><?php echo anchor('/okonomi/utgift/'.$Utgift['UtgiftID'],$Utgift['KontoID'],'title="'.$Utgift['Konto'].'"'); ?></td>
        <td><?php echo anchor('/okonomi/utgift/'.$Utgift['UtgiftID'],($Utgift['PersonID'] > 0 ? $Utgift['PersonInitialer'] : '&nbsp;'),'title="'.$Utgift['Person'].'"'); ?></td>
        <td><a href="<?php echo site_url(); ?>/okonomi/utgift/<?php echo $Utgift['UtgiftID']; ?>"><?php echo $Utgift['Beskrivelse']; ?></a></td>
        <td><?php echo anchor('/okonomi/utgift/'.$Utgift['UtgiftID'],'kr '.number_format($Utgift['Belop'],2,',','.')); ?></td>
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
    </tbody>
  </table>
</div>

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
      <option value="<?php echo $Aktivitet['AktivitetID']; ?>"><?php echo $Aktivitet['AktivitetID']." ".$Aktivitet['Navn']; ?></option>
<?php } ?>
    </select>
  </p>
  <p>
    <label for="fkontoid">Konto:</label>
    <select name="fkontoid">
      <option value="0">(alle)</option>
<?php foreach ($Kontoer as $Konto) { ?>
      <option value="<?php echo $Konto['KontoID']; ?>"><?php echo $Konto['KontoID']." ".$Konto['Navn']; ?></option>
<?php } ?>
    </select>
  </p>
  <p>
    <label for="fpersonid">Person:</label>
    <select name="fpersonid">
      <option value="0">(alle)</option>
<?php foreach ($Personer as $Person) { ?>
      <option value="<?php echo $Person['PersonID']; ?>"><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php } ?>
    </select>
  </p>
  <p>
    <label for="fprosjektid">Prosjekt:</label>
    <select name="fprosjektid">
      <option value="0">(alle)</option>
<?php foreach ($Prosjekter as $Prosjekt) { ?>
      <option value="<?php echo $Prosjekt['ProsjektID']; ?>"><?php echo $Prosjekt['Prosjektnavn']; ?></option>
<?php } ?>
    </select>
  </p>
  <p>
    <input type="submit" value="Filtrer" />
  </p>
</div>
</form>
