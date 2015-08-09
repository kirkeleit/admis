<h3 class="sub-header">Utgifter <a href="<?php echo site_url('/okonomi/nyutgift'); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span></a></h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Dato</th>
        <th>Aktivitet</th>
        <th>Konto</th>
        <th>Person</th>
        <th>Beskrivelse</th>
        <th>Beløp</th>
      </tr>
    </thead>
    <tbody>
<?php
  $Totalt = 0;
  if (isset($Utgifter)) {
    foreach ($Utgifter as $Utgift) {
?>
      <tr>
        <td><?php echo anchor('/okonomi/utgift/'.$Utgift['UtgiftID'],date('d.m.Y',strtotime($Utgift['DatoBokfort']))); ?></td>
        <td><?php echo anchor('/okonomi/utgift/'.$Utgift['UtgiftID'],$Utgift['AktivitetID'],'title="'.$Utgift['Aktivitet'].'"'); ?></td>
        <td><?php echo anchor('/okonomi/utgift/'.$Utgift['UtgiftID'],$Utgift['KontoID'],'title="'.$Utgift['Konto'].'"'); ?></td>
        <td><?php echo anchor('/okonomi/utgift/'.$Utgift['UtgiftID'],($Utgift['PersonID'] > 0 ? $Utgift['PersonInitialer'] : '&nbsp;'),'title="'.$Utgift['Person'].'"'); ?></td>
        <td><?php echo anchor('/okonomi/utgift/'.$Utgift['UtgiftID'],$Utgift['Beskrivelse']); ?></a></td>
        <td class="text-right"><?php echo anchor('/okonomi/utgift/'.$Utgift['UtgiftID'],'kr '.number_format($Utgift['Belop'],2,',','.')); ?></td>
      </tr>
<?php
      $Totalt = $Totalt + $Utgift['Belop'];
    }
?>
      <tr>
        <td colspan="5">&nbsp;</td>
        <td class="text-right"><?php echo 'kr '.number_format($Totalt,2,',','.'); ?></td>
      </tr>
<?php
  } else {
?>
      <tr>
        <td colspan="6">Ingen utgifter i utvalg.</td>
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
