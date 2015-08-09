<h3 class="sub-header">Utstyrsliste <a href="<?php echo site_url('/materiell/nyttustyr'); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span></a></h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>UID</th>
        <th>Gruppe</th>
        <th>Type</th>
        <th>Produsent</th>
        <th>Modell</th>
        <th>DatoAnskaffet</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
?>
      <tr>
        <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],$Utstyr['UID']); ?></td>
        <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],(isset($Utstyr['GruppeNavn']) ? $Utstyr['GruppeNavn'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],(isset($Utstyr['TypeNavn']) ? $Utstyr['TypeNavn'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],(isset($Utstyr['ProdusentNavn']) ? $Utstyr['ProdusentNavn'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],$Utstyr['Modell']); ?></td>
        <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],date('d.m.Y',strtotime($Utstyr['DatoAnskaffet']))); ?></td>
        <td><?php echo anchor('/materiell/utstyr/'.$Utstyr['UtstyrID'],$Utstyr['Status']); ?></td>
      </tr>
<?php
    }
  }
?>
    <tbody>
  </table>
</div>
