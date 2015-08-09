<h3 class="sub-header">Utstyrstyper <a href="<?php echo site_url('/materiell/nyutstyrstype'); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span></a></h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Navn</th>
        <th>Antall</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Typer)) {
    foreach ($Typer as $Type) {
?>
      <tr>
        <td><?php echo anchor('/materiell/utstyrstype/'.$Type['TypeID'],$Type['Navn']); ?></td>
        <td><?php echo anchor('/materiell/utstyrstype/'.$Type['TypeID'],$Type['Antall'].' stk'); ?></td>
      </tr>
<?php
    }
  }
?>
    </tbody>
  </table>
</div>
