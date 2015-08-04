<h3 class="sub-header">Utleggskvitteringer</h3>
<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>ID</th>
        <th>Dato</th>
        <th>Aktivitet</th>
        <th>Medlem</th>
        <th>Beløp</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utleggskvitteringer)) {
    foreach ($Utleggskvitteringer as $Utlegg) {
?>
      <tr>
        <td><a href="<?php echo site_url(); ?>/okonomi/utleggskvittering/<?php echo $Utlegg['UtleggID']; ?>"><?php echo $Utlegg['UtleggID']; ?></a></td>
        <td><?php echo date("d.m.Y",strtotime($Utlegg['DatoUtlegg'])); ?></td>
        <td><?php echo $Utlegg['AktivitetID']." ".$Utlegg['AktivitetNavn']; ?></td>
        <td><?php echo $Utlegg['PersonNavn']; ?></td>
        <td><?php echo "kr ".number_format($Utlegg['Belop'],2,',','.'); ?></td>
        <td><?php echo $Utlegg['Status']; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="5">Ingen utleggskvitteringer i utvalg.</td>
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
    <label for="fpersonid">Person:</label>
    <select name="fpersonid">
      <option value="0">(alle)</option>
<?php foreach ($Personer as $Person) { ?>
      <option value="<?php echo $Person['PersonID']; ?>"><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php } ?>
    </select>
  </p>
  <p>
    <input type="submit" value="Filtrer" />
  </p>
</div>
</form>
