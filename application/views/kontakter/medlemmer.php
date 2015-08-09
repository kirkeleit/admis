<h3 class="sub-header">Medlemmer</h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Navn</th>
        <th>Mobilnr</th>
        <th>Epost</th>
        <th>Poststed</th>
        <th>Alder</th>
        <th>Medlemsår</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Personer)) {
    foreach ($Personer as $Person) {
?>
      <tr>
        <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],$Person['Fornavn']." ".$Person['Etternavn']); ?></td>
        <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],($Person['Mobilnr'] != '' ? $Person['Mobilnr'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],($Person['Epost'] != '' ? $Person['Epost'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],($Person['Poststed'] != '' ? $Person['Poststed'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],($Person['Alder'] != '' ? $Person['Alder'] : '&nbsp;')); ?></td>
        <td><?php echo anchor('/kontakter/person/'.$Person['PersonID'],($Person['Medlemsar'] != '' ? $Person['Medlemsar'] : '&nbsp;')); ?></td>
      </tr>
<?php
    }
  }
?>
    </tbody>
  </table>
</div>
