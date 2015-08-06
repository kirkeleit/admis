<?php echo form_open('okonomi/innkjopsordre'); ?>
<input type="hidden" name="OrdreID" value="<?php echo set_value('OrdreID',$Ordre['OrdreID']); ?>" />

<div class="panel panel-default">
  <div class="panel-heading"><h4>Innkjøpsordre</h4></div>

  <div class="panel-body">
  <div class="form-group">
    <label for="ProsjektID">Prosjekt:</label>
    <select name="ProsjektID" class="form-control"<?php if ($Ordre['StatusID'] != 1) { echo 'disabled '; } ?>>
      <option value="0" <?php echo set_select('ProsjektID',0,($Ordre['ProsjektID'] == 0) ? TRUE : FALSE); ?>>(ingen prosjekt)</option>
<?php
  foreach ($Prosjekter as $Prosjekt) {
?>
      <option value="<?php echo $Prosjekt['ProsjektID']; ?>" <?php echo set_select('ProsjektID',$Prosjekt['ProsjektID'],($Ordre['ProsjektID'] == $Prosjekt['ProsjektID']) ? TRUE : FALSE); ?>><?php echo $Prosjekt['Prosjektnavn']; ?></option>
<?php
  }
?>
      <optgroup label="Arkiverte prosjekt">
<?php
  foreach ($ProsjekterArkiv as $Prosjekt) {
?>
      <option value="<?php echo $Prosjekt['ProsjektID']; ?>" <?php echo set_select('ProsjektID',$Prosjekt['ProsjektID'],($Ordre['ProsjektID'] == $Prosjekt['ProsjektID']) ? TRUE : FALSE); ?>><?php echo $Prosjekt['Prosjektnavn']; ?></option>
<?php
  }
?>
      </optgroup>
    </select>
  </div>

  <div class="form-group">
    <label for="PersonID">Ansvarlig:</label>
    <select name="PersonAnsvarligID" class="form-control"<?php if ($Ordre['StatusID'] != 1) { echo 'disabled '; } ?>>
      <option value="0" <?php echo set_select('PersonAnsvarligID',0,($Ordre['PersonAnsvarligID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  foreach ($Medlemmer as $Person) {
?>
      <option value="<?php echo $Person['PersonID']; ?>" <?php echo set_select('PersonAnsvarligID',$Person['PersonID'],($Ordre['PersonAnsvarligID'] == $Person['PersonID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
  }
?>
    </select>
  </div>

  <div class="form-group">
    <label for="LeverandorID">Leverandør:</label>
    <select name="LeverandorID" class="form-control"<?php if ($Ordre['StatusID'] != 1) { echo 'disabled '; } ?>>
      <option value="0" <?php echo set_select('LeverandorID',0,($Ordre['LeverandorID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  foreach ($Organisasjoner as $Organisasjon) {
?>
      <option value="<?php echo $Organisasjon['OrganisasjonID']; ?>" <?php echo set_select('LeverandorID',$Organisasjon['OrganisasjonID'],($Ordre['LeverandorID'] == $Organisasjon['OrganisasjonID']) ? TRUE : FALSE); ?>><?php echo $Organisasjon['Navn']; ?></option>
<?php
  }
?>
    </select>
  </div>

  <div class="form-group">
    <label for="Referanse">Referanse:</label>
    <input type="text" class="form-control" name="Referanse" value="<?php echo set_value('Referanse',$Ordre['Referanse']); ?>" <?php if ($Ordre['StatusID'] != 1) { echo 'disabled '; } ?>/>
  </div>

  <div class="form-group">
    <label for="Navn" style="vertical-align: top">Beskrivelse:</label>
    <textarea name="Beskrivelse" class="form-control" id="Beskrivelse" <?php if ($Ordre['StatusID'] != 1) { echo 'disabled '; } ?>><?php echo set_value('Beskrivelse',$Ordre['Beskrivelse']); ?></textarea>
  </div>

  <div class="form-group">
    <label for="Status">Status</label>
    <span><?php echo $Ordre['Status']; ?></span>
  </div>

  <div class="form-group">
    <div class="btn-group" role="group" aria-label="...">
      <input type="submit" name="OrdreLagre" id="OrdreLagre" class="btn btn-default" value="Lagre" <?php if ($Ordre['StatusID'] != 1) { echo 'disabled '; } ?>/>
      <input type="submit" name="OrdreSlett" id="OrdreSlett" class="btn btn-default" value="Slett" <?php if ($Ordre['StatusID'] != 1) { echo 'disabled '; } ?>/>
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Handling <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
<?php if (($UABruker['ID'] == $Ordre['PersonAnsvarligID']) and ($Ordre['StatusID'] == 1)) { ?>
        <li><a href="<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['OrdreID']; ?>&status=2">Send til godkjenning</a></li>
<?php } else { ?>
        <li class="disabled"><a href="#">Send til godkjenning</a></li>
<?php } ?>
        <li role="separator" class="divider"></li>
<?php if ((!in_array('307',$UABruker['UAP'])) and ($Ordre['StatusID'] == 2)) { ?>
        <li><a href="<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['OrdreID']; ?>&status=3">Godkjenn</a></li>
        <li><a href="<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['OrdreID']; ?>&status=1">Avvis</a></li>
<?php } else { ?>
        <li class="disabled"><a href="#">Godkjenn</a></li>
        <li class="disabled"><a href="#">Avvis</a></li>
<?php } ?>
        <li role="separator" class="divider"></li>
<?php if ($Ordre['StatusID'] == 3) { ?>
        <li><a href="<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['OrdreID']; ?>&status=4">Bestilt</a></li>
<?php } else { ?>
        <li class="disabled"><a href="#">Bestilt</a></li>
<?php } ?>
<?php if ($Ordre['StatusID'] == 5) { ?>
        <li><a href="<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['OrdreID']; ?>&status=6">Fullført</a></li>
<?php } else { ?>
        <li class="disabled"><a href="#">Fullført</a></li>
<?php } ?>
      </ul>
    </div>
  </div>

<?php echo form_close(); ?>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Varelinjer</h3>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-condensed">
      <thead>
        <th>Varenummer</th>
        <th>Varenavn</th>
        <th>Pris</th>
        <th>Antall</th>
        <th>Sum</th>
        <th>Levert</th>
        <th>&nbsp;</th>
      </thead>
      <tbody>
<?php
  if (isset($Varelinjer)) {
    $i = 0;
    $TotalSum = 0;
    foreach ($Varelinjer as $Linje) {
      $i++;
      $TotalSum = $TotalSum + $Linje['Sum'];
?>
  <tr<?php if ($Linje['StatusID'] == 2) { ?> class="success"<?php } else { ?> class="danger"<?php } ?>>
    <td><?php echo $Linje['Varenummer']; ?></td>
    <td><?php echo $Linje['Varenavn']; ?></td>
    <td>kr <?php echo number_format($Linje['Pris'],2,',','.'); ?></td>
    <td><?php echo $Linje['Antall']; ?> stk</td>
    <td>kr <?php echo number_format($Linje['Sum'],2,',','.'); ?></td>
    <td><?php if ($Linje['Levert'] == "") { echo "0"; } else { echo $Linje['Levert']; } ?> stk</td>
    <td><?php if ($Ordre['StatusID'] == 1) { ?><img src="/grafikk/icons/cart_edit.png" width="12px" id="EndreVarelinje<?php echo $Linje['LinjeID']; ?>" title="Endre linje" style="cursor:pointer;" />
    <img src="/grafikk/icons/cart_delete.png" width="12px" id="SlettVarelinje<?php echo $Linje['LinjeID']; ?>" title="Slett linje" style="cursor:pointer;" /><?php } else { echo "&nbsp;"; } ?></td>
  </tr>
<script>
  $('#EndreVarelinje<?php echo $Linje['LinjeID']; ?>').click(function() {
    $('#LinjeID').val('<?php echo $Linje['LinjeID']; ?>');
    $('#Varenummer').val('<?php echo $Linje['Varenummer']; ?>');
    $('#Varenavn').val('<?php echo $Linje['Varenavn']; ?>');
    $('#Pris').val('<?php echo $Linje['Pris']; ?>');
    $('#Antall').val('<?php echo $Linje['Antall']; ?>');
  });
  $('#SlettVarelinje<?php echo $Linje['LinjeID']; ?>').click(function() {
    document.location.href='<?php echo site_url(); ?>/okonomi/slettinnkjopsordrelinje/?ordreid=<?php echo $Ordre['OrdreID']; ?>&linjeid=<?php echo $Linje['LinjeID']; ?>';
  });
</script>
<?php
    }
?>
        <tr>
          <td colspan="4">&nbsp;</td>
          <td>kr <?php echo number_format($TotalSum,2,',','.'); ?></td>
          <td colspan="2">&nbsp;</td>
        </tr>
<?php
  } else {
?>
        <tr>
          <td colspan="7">Ingen varelinjer.</td>
        </tr>
<?php
  }
?>
      </tbody>
    </table>
  </div>
</div>

<?php if ($Ordre['StatusID'] == 1) { ?>
<?php echo form_open('okonomi/nyinnkjopsordrelinje'); ?>
<input type="hidden" name="OrdreID" value="<?php echo set_value('InnkjopsordreID',$Ordre['OrdreID']); ?>" />
<input type="hidden" name="LinjeID" id="LinjeID" value="0" />
<div class="panel panel-default">
  <div class="panel-heading"><h4>Ny/endre varelinje</h4></div>

  <div class="panel-body">

    <div class="form-group">
      <label>Varenr:</label>
      <input type="text" class="form-control" name="Varenummer" id="Varenummer" value="<?php echo set_value('Varenummer'); ?>" /></td>
    </div>

    <div class="form-group">
      <label>Varenavn:</label>
      <input type="text" class="form-control" name="Varenavn" id="Varenavn" value="<?php echo set_value('Varenavn'); ?>" /></td>
    </div>

    <div class="form-group">
      <label>Pris:</label>
      <input type="number" class="form-control" name="Pris" id="Pris" value="<?php echo set_value('Pris'); ?>" step="any" /></td>
    </div>

    <div class="form-group">
      <label>Antall:</label>
      <input type="number" class="form-control" name="Antall" id="Antall" value="<?php echo set_value('Antall'); ?>" /></td>
    </div>

    <input type="submit" class="btn btn-default" value="Lagre linje" /></td>
  </div>
</div>
<?php echo form_close(); ?>
<?php } ?>
