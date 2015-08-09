<h3 class="sub-header">Lagerplasser <a href="<?php echo site_url('/materiell/nylagerplass'); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span></a></h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Kode</th>
        <th>Navn</th>
        <th>Antall</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Lagerplasser)) {
    foreach ($Lagerplasser as $Lagerplass) {
?>
  <tr>
    <td><?php echo anchor('/materiell/lagerplass/'.$Lagerplass['LagerplassID'],$Lagerplass['Kode']); ?></td>
    <td><?php echo anchor('/materiell/lagerplass/'.$Lagerplass['LagerplassID'],$Lagerplass['Navn']); ?></td>
    <td><?php echo anchor('/materiell/lagerplass/'.$Lagerplass['LagerplassID'],$Lagerplass['Antall'].' stk'); ?></td>
  </tr>
<?php
    }
  }
?>
    </tbody>
  </table>
</div>
