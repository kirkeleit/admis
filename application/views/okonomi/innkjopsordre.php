<h3 class="sub-header">Innkjøpsordre</h3>

<?php echo form_open('okonomi/innkjopsordre/'.$Ordre['OrdreID']); ?>
<input type="hidden" name="OrdreID" value="<?php echo set_value('OrdreID',$Ordre['OrdreID']); ?>" />
<div class="panel panel-default">
  <div class="panel-heading">&nbsp;</div>

  <div class="panel-body">
    <div class="form-group">
      <label for="ProsjektID">Prosjekt:</label>
      <select name="ProsjektID" class="form-control">
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
      <select name="PersonAnsvarligID" class="form-control">
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
      <select name="LeverandorID" class="form-control">
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
      <input type="text" class="form-control" name="Referanse" value="<?php echo set_value('Referanse',$Ordre['Referanse']); ?>" />
    </div>

    <div class="form-group">
      <label for="Navn" style="vertical-align: top">Beskrivelse:</label>
      <textarea name="Beskrivelse" class="form-control" id="Beskrivelse"><?php echo set_value('Beskrivelse',$Ordre['Beskrivelse']); ?></textarea>
    </div>
  </div>

  <div class="panel-footer">
    <div class="form-group">
      <div class="btn-group">
        <input type="submit" name="OrdreLagre" class="btn btn-primary" value="Lagre" <?php if (isset($Ordre['StatusID']) and ($Ordre['StatusID'] != 1)) { echo 'disabled '; } ?>/>
        <input type="submit" name="OrdreSlett" class="btn btn-danger" value="Slett" <?php if ($Ordre['StatusID'] != 1) { echo 'disabled '; } ?>/>
      </div>
      <div class="btn-group">
<?php if ($Ordre['StatusID'] == 1) { ?>
        <input type="submit" name="OrdreSendtilgodkjenning" class="btn btn-success" value="Send til godkjenning" />
        <input type="submit" name="OrdreGodkjenn" class="btn btn-default" value="Godkjenn" disabled />
        <input type="submit" name="OrdreAvvis" class="btn btn-default" value="Avvis" disabled />
        <input type="submit" name="OrdreBestilt" class="btn btn-default" value="Bestilt" disabled />
        <input type="submit" name="OrdreFullfort" class="btn btn-default" value="Fullført" disabled />
<?php } elseif (($Ordre['StatusID'] == 2) and (in_array('307',$UABruker['UAP']))) { ?>
        <input type="submit" name="OrdreSendtilgodkjenning" class="btn btn-default" value="Send til godkjenning" disabled />
        <input type="submit" name="OrdreGodkjenn" class="btn btn-success" value="Godkjenn" />
        <input type="submit" name="OrdreAvvis" class="btn btn-success" value="Avvis" />
        <input type="submit" name="OrdreBestilt" class="btn btn-default" value="Bestilt" disabled />
        <input type="submit" name="OrdreFullfort" class="btn btn-default" value="Fullført" disabled />
<?php } elseif ($Ordre['StatusID'] == 3) { ?>
        <input type="submit" name="OrdreSendtilgodkjenning" class="btn btn-default" value="Send til godkjenning" disabled />
        <input type="submit" name="OrdreGodkjenn" class="btn btn-default" value="Godkjenn" disabled />
        <input type="submit" name="OrdreAvvis" class="btn btn-default" value="Avvis" disabled />
        <input type="submit" name="OrdreBestilt" class="btn btn-success" value="Bestilt" />
        <input type="submit" name="OrdreFullfort" class="btn btn-default" value="Fullført" disabled />
<?php } elseif ($Ordre['StatusID'] == 5) { ?>
        <input type="submit" name="OrdreSendtilgodkjenning" class="btn btn-default" value="Send til godkjenning" disabled />
        <input type="submit" name="OrdreGodkjenn" class="btn btn-default" value="Godkjenn" disabled />
        <input type="submit" name="OrdreAvvis" class="btn btn-default" value="Avvis" disabled />
        <input type="submit" name="OrdreBestilt" class="btn btn-default" value="Bestilt" disabled />
        <input type="submit" name="OrdreFullfort" class="btn btn-success" value="Fullført" />
<?php } else { ?>
        <input type="submit" name="OrdreSendtilgodkjenning" class="btn btn-default" value="Send til godkjenning" disabled />
        <input type="submit" name="OrdreGodkjenn" class="btn btn-default" value="Godkjenn" disabled />
        <input type="submit" name="OrdreAvvis" class="btn btn-default" value="Avvis" disabled />
        <input type="submit" name="OrdreBestilt" class="btn btn-default" value="Bestilt" disabled />
        <input type="submit" name="OrdreFullfort" class="btn btn-default" value="Fullført" disabled />
<?php } ?>
      </div>
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Varelinjer</h3>
  </div>
  <div class="panel-body">
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
            <td class="text-right">kr <?php echo number_format($Linje['Pris'],2,',','.'); ?></td>
            <td><?php echo $Linje['Antall']; ?> stk</td>
            <td class="text-right">kr <?php echo number_format($Linje['Sum'],2,',','.'); ?></td>
            <td><?php if ($Linje['Levert'] == "") { echo "0"; } else { echo $Linje['Levert']; } ?> stk</td>
            <td><?php if ($Ordre['StatusID'] == 1) { ?><span class="glyphicon glyphicon-edit" id="EndreVarelinje<?php echo $Linje['LinjeID']; ?>" aria-hidden="true"></span><?php } else { echo "&nbsp;"; } ?></td>
          </tr>
<script>
  $('#EndreVarelinje<?php echo $Linje['LinjeID']; ?>').click(function() {
    $('#VarelinjeLinjeID').val('<?php echo $Linje['LinjeID']; ?>');
    $('#VarelinjeVarenummer').val('<?php echo $Linje['Varenummer']; ?>');
    $('#VarelinjeVarenavn').val('<?php echo $Linje['Varenavn']; ?>');
    $('#VarelinjePris').val('<?php echo $Linje['Pris']; ?>');
    $('#VarelinjeAntall').val('<?php echo $Linje['Antall']; ?>');
  });
</script>
<?php
    }
?>
          <tr>
            <td colspan="4">&nbsp;</td>
            <td class="text-right">kr <?php echo number_format($TotalSum,2,',','.'); ?></td>
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
<?php if ($Ordre['StatusID'] == 1) { ?>
          <tr>
            <td><input type="text" class="form-control" name="VarelinjeVarenummer" id="VarelinjeVarenummer" value="<?php echo set_value('VarelinjeVarenummer'); ?>" /></td>
            <td><input type="text" class="form-control" name="VarelinjeVarenavn" id="VarelinjeVarenavn" value="<?php echo set_value('VarelinjeVarenavn'); ?>" /></td>
            <td><input type="number" class="form-control" name="VarelinjePris" id="VarelinjePris" value="<?php echo set_value('VarelinjePris'); ?>" step="any" /></td>
            <td><input type="number" class="form-control" name="VarelinjeAntall" id="VarelinjeAntall" value="<?php echo set_value('VarelinjeAntall'); ?>" /></td>
            <td colspan="3"><input type="submit" class="btn btn-default" name="OrdreLagrelinje" value="Lagre linje" /></td>
          </tr>
<?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php echo form_close(); ?>
