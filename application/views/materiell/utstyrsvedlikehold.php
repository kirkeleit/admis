<h3 class="sub-header">Utstyrsvedlikehold</h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>UID</th>
        <th>Gruppe</th>
        <th>Type</th>
        <th>Produsent</th>
        <th>Modell</th>
        <th>Anskaffet</th>
        <th>Rapport</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
      if ($Utstyr['StatusID'] > 1) {
?>
      <tr>
        <td><a href="<?php echo site_url(); ?>/materiell/utstyr/<?php echo $Utstyr['UtstyrID']; ?>"><?php echo $Utstyr['UID']; ?></a></td>
        <td><?php if (isset($Utstyr['GruppeNavn'])) { echo $Utstyr['GruppeNavn']; } else { echo "&nbsp;"; } ?></td>
        <td><?php if (isset($Utstyr['TypeNavn'])) { echo $Utstyr['TypeNavn']; } else { echo "&nbsp;"; } ?></td>
        <td><?php if (isset($Utstyr['ProdusentNavn'])) { echo $Utstyr['ProdusentNavn']; } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Utstyr['Modell']; ?></td>
        <td><?php if ($Utstyr['DatoAnskaffet'] != '0000-00-00') { echo date('d.m.Y',strtotime($Utstyr['DatoAnskaffet'])); } ?></td>
        <td><?php if (isset($Utstyr['TSRapportID'])) { ?><a href="<?php echo site_url(); ?>/materiell/tsrapport/<?php echo $Utstyr['TSRapportID']; ?>"><?php echo $Utstyr['TSRapportID']; ?></a><?php } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Utstyr['Status']; ?></td>
  </tr>
<?php
      }
    }
  }
?>
    </tbody>
  </table>
</div>
