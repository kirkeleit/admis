<?php
  $Redigerbar1 = 0;
  $Redigerbar2 = 0;
  if (($Ordre['ID'] == 0) and (in_array('305',$UABruker['UAP']))) {
    $Redigerbar1 = 1;
  } elseif (($Ordre['StatusID'] == 1) and (($UABruker['ID'] == $Ordre['PersonID']) or (in_array('306',$UABruker['UAP']))))  {
    $Redigerbar1 = 1;
  }
  if (($Ordre['StatusID'] == 3) and (($UABruker['ID'] == $Ordre['PersonID']) or (in_array('306',$UABruker['UAP']))))  {
    $Redigerbar2 = 1;
  } elseif (($Ordre['StatusID'] == 4) and (($UABruker['ID'] == $Ordre['PersonID']) or (in_array('306',$UABruker['UAP']))))  {
    $Redigerbar2 = 1;
  } elseif (($Ordre['StatusID'] == 5) and (($UABruker['ID'] == $Ordre['PersonID']) or (in_array('306',$UABruker['UAP']))))  {
    $Redigerbar2 = 1;
  }
?>
<?php echo form_open('okonomi/innkjopsordre'); ?>
<input type="hidden" name="ID" value="<?php echo set_value('ID',$Ordre['ID']); ?>" />
<fieldset>
  <legend>Innkjøpsordre</legend>

  <p>
    <label for="PersonID">Ansvarlig:</label>
    <select name="PersonID"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?>>
      <option value="0" <?php echo set_select('PersonID',0,($Ordre['PersonID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  foreach ($Medlemmer as $Person) {
?>
      <option value="<?php echo $Person['ID']; ?>" <?php echo set_select('PersonID',$Person['ID'],($Ordre['PersonID'] == $Person['ID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
  }
?>
    </select>
  </p>

  <p>
    <label for="LeverandorID">Leverandør:</label>
    <select name="LeverandorID"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?>>
      <option value="0" <?php echo set_select('LeverandorID',0,($Ordre['LeverandorID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  foreach ($Organisasjoner as $Organisasjon) {
?>
      <option value="<?php echo $Organisasjon['ID']; ?>" <?php echo set_select('LeverandorID',$Organisasjon['ID'],($Ordre['LeverandorID'] == $Organisasjon['ID']) ? TRUE : FALSE); ?>><?php echo $Organisasjon['Navn']; ?></option>
<?php
  }
?>
    </select>
  </p>

  <p>
    <label for="Navn">Navn:</label>
    <input type="text" name="Navn" value="<?php echo set_value('Navn',$Ordre['Navn']); ?>"<?php if ($Ordre['ProsjektID'] > 0) { ?> readonly<?php } ?><?php if ($Redigerbar1 == 0) { echo " disabled"; } ?> />
  </p>

  <p>
    <label for="Navn">Beskrivelse:</label>
    <textarea name="Beskrivelse" id="Beskrivelse"<?php if ($Ordre['ProsjektID'] > 0) { ?> readonly<?php } ?><?php if ($Redigerbar1 == 0) { echo " disabled"; } ?>><?php echo set_value('Beskrivelse',$Ordre['Beskrivelse']); ?></textarea>
  </p>

  <p>
    <label for="Status">Status</label>
    <span><?php echo $Ordre['Status']; ?></span>
  </p>

<?php if ($Ordre['StatusID'] < 6) { ?>
  <p class="handlinger">
    <label>&nbsp;</label>
<?php if ($Ordre['StatusID'] == 0) { ?>
    <input type="submit" id="LagreProsjekt" value="Lagre"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?> />
<?php } elseif ($Ordre['StatusID'] == 1) { ?>
    <input type="submit" id="LagreProsjekt" value="Lagre"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?> />
    <input type="button" value="Slett" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/slettinnkjopsordre/<?php echo $Ordre['ID']; ?>';" <?php if (($Redigerbar1 == 0) or ($Ordre['ProsjektID'] > 0)) { ?>disabled <?php } ?>/>
    <input type="button" value="Send til godkjenning" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['ID']; ?>&status=2';"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?> />
<?php } elseif ($Ordre['StatusID'] == 2) { ?>
    <input type="button" value="Godkjenn" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['ID']; ?>&status=3';"<?php if (!in_array('307',$UABruker['UAP'])) { echo " disabled"; } ?> />
    <input type="button" value="Avvis" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['ID']; ?>&status=1';"<?php if (!in_array('307',$UABruker['UAP'])) { echo " disabled"; } ?> />
<?php } elseif ($Ordre['StatusID'] == 3) { ?>
    <input type="button" value="Bestilt" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['ID']; ?>&status=4';"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
    <input type="button" value="Tilbake til planlegging" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['ID']; ?>&status=1';"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
<?php } elseif ($Ordre['StatusID'] == 4) { ?>
    <input type="button" value="Levert" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['ID']; ?>&status=5';"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
<?php } elseif ($Ordre['StatusID'] == 5) { ?>
    <input type="button" value="Fullført" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['ID']; ?>&status=6';"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
<?php } ?>
  </p>
<?php } ?>
</fieldset>
<?php echo form_close(); ?>

<fieldset style="background-color: #E0E0E0;">
  <legend>Varelinjer</legend>

<table style="font-size: 0.6em;">
  <tr>
    <th>Varenummer</th>
    <th>Varenavn</th>
    <th>Pris</th>
    <th>Antall</th>
    <th>Sum</th>
    <th>&nbsp;</th>
  </tr>
<?php
  if (isset($Ordre['Linjer'])) {
    $i = 0;
    $TotalSum = 0;
    foreach ($Ordre['Linjer'] as $Linje) {
      $i++;
      $TotalSum = $TotalSum + $Linje['Sum'];
?>
  <tr>
    <td><?php echo $Linje['Varenummer']; ?></td>
    <td><?php echo $Linje['Varenavn']; ?>
<?php if ($Linje['LeverandorID'] > 0) { ?>
    <br /><a href="<?php echo site_url(); ?>/kontakter/organisasjon/<?php echo $Linje['LeverandorID']; ?>"><?php echo $Linje['Leverandor']; ?></a>
<?php }?>
    </td>
    <td style="text-align: right;">kr <?php echo number_format($Linje['Pris'],2,',','.'); ?></td>
    <td style="text-align:right;"><?php echo $Linje['Antall']; ?></td>
    <td style="text-align: right;">kr <?php echo number_format($Linje['Sum'],2,',','.'); ?></td>
    <td><img src="/grafikk/icons/cart_edit.png" width="12px" id="EndreVarelinje<?php echo $Linje['ID']; ?>" title="Endre linje" style="cursor:pointer;" />
    <img src="/grafikk/icons/cart_delete.png" width="12px" id="SlettVarelinje<?php echo $Linje['ID']; ?>" title="Slett linje" style="cursor:pointer;" /></td>
  </tr>
<script>
  $('#EndreVarelinje<?php echo $Linje['ID']; ?>').click(function() {
    $('#LinjeID').val('<?php echo $Linje['ID']; ?>');
    $('#LeverandorID').val('<?php echo $Linje['LeverandorID']; ?>');
    $('#Varenummer').val('<?php echo $Linje['Varenummer']; ?>');
    $('#Varenavn').val('<?php echo $Linje['Varenavn']; ?>');
    $('#Pris').val('<?php echo $Linje['Pris']; ?>');
    $('#Antall').val('<?php echo $Linje['Antall']; ?>');
  });
  $('#SlettVarelinje<?php echo $Linje['ID']; ?>').click(function() {
    document.location.href='<?php echo site_url(); ?>/okonomi/slettinnkjopsordrelinje/?ordreid=<?php echo $Ordre['ID']; ?>&linjeid=<?php echo $Linje['ID']; ?>';
  });
</script>
<?php
    }
?>
  <tr>
    <td colspan="4">&nbsp;</td>
    <td style="text-align:right;">kr <?php echo number_format($TotalSum,2,',','.'); ?></td>
    <td>&nbsp;</td>
  </tr>
<?php
  } else {
?>
  <tr>
    <td colspan="6">Ingen varelinjer.</td>
  </tr>
<?php
  }
?>
</table>
</fieldset>

<?php if ($Ordre['StatusID'] == 1) { ?>
<?php echo form_open('okonomi/nyinnkjopsordrelinje'); ?>
<input type="hidden" name="OrdreID" value="<?php echo set_value('InnkjopsordreID',$Ordre['ID']); ?>" />
<input type="hidden" name="LinjeID" id="LinjeID" value="0" />
<fieldset>
  <legend>Ny varelinje</legend>
  <p>
    <label>Leverandør:</label>
    <select name="LeverandorID" id="LeverandorID">
      <option value="0">(felles)</option>
<?php
  foreach ($Organisasjoner as $Organisasjon) {
?>
      <option value="<?php echo $Organisasjon['ID']; ?>" <?php echo set_select('LeverandorID',$Organisasjon['ID'],($Ordre['LeverandorID'] == $Organisasjon['ID']) ? TRUE : FALSE); ?>><?php echo $Organisasjon['Navn']; ?></option>
<?php
  }
?>
    </select>
  </p>

  <p>
    <label>Varenr:</label>
    <input type="text" name="Varenummer" id="Varenummer" value="<?php echo set_value('Varenummer'); ?>" /></td>
  </p>

  <p>
    <label>Varenavn:</label>
    <input type="text" name="Varenavn" id="Varenavn" value="<?php echo set_value('Varenavn'); ?>" /></td>
  </p>

  <p>
    <label>Pris:</label>
    <input type="number" name="Pris" id="Pris" value="<?php echo set_value('Pris'); ?>" step="any" /></td>
  </p>

  <p>
    <label>Antall:</label>
    <input type="number" name="Antall" id="Antall" value="<?php echo set_value('Antall'); ?>" /></td>
  </p>

  <p class="handlinger">
    <label>&nbsp;</label>
    <input type="submit" value="Lagre linje" /></td>
  </p>
</fieldset>
<?php echo form_close(); ?>
<?php } ?>
