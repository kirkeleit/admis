<h3 class="sub-header">Produsenter <a href="<?php echo site_url('/materiell/nyprodusent'); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span></a></h3>

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
  if (isset($Produsenter)) {
    foreach ($Produsenter as $Produsent) {
?>
  <tr>
    <td><?php echo anchor('/materiell/produsent/'.$Produsent['ProdusentID'],$Produsent['Navn']); ?></td>
    <td><?php echo anchor('/materiell/produsent/'.$Produsent['ProdusentID'],$Produsent['Antall'].' stk'); ?></td>
  </tr>
<?php
    }
  }
?>
    </tbody>
  </table>
</div>
