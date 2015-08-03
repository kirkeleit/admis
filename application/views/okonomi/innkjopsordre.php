<?php
  $Redigerbar1 = 0;
  $Redigerbar2 = 0;
  if (($Ordre['OrdreID'] == 0) and (in_array('305',$UABruker['UAP']))) {
    $Redigerbar1 = 1;
  } elseif (($Ordre['StatusID'] == 1) and (($UABruker['ID'] == $Ordre['PersonAnsvarligID']) or (in_array('306',$UABruker['UAP']))))  {
    $Redigerbar1 = 1;
  }
  if (($Ordre['StatusID'] == 3) and (($UABruker['ID'] == $Ordre['PersonAnsvarligID']) or (in_array('306',$UABruker['UAP']))))  {
    $Redigerbar2 = 1;
  } elseif (($Ordre['StatusID'] == 4) and (($UABruker['ID'] == $Ordre['PersonID']) or (in_array('306',$UABruker['UAP']))))  {
    $Redigerbar2 = 1;
  } elseif (($Ordre['StatusID'] == 5) and (($UABruker['ID'] == $Ordre['PersonID']) or (in_array('306',$UABruker['UAP']))))  {
    $Redigerbar2 = 1;
  }
?>
<!--
<style type="text/css">
  TD.IkkeUtfort {
    background-color: silver;
  }
  TD.Utfort {
    background-color: green;
  }
  TD.Neste {
    background-color: red;
  }
</style>
<table>
  <tr>
    <td class="<?php if ($Ordre['StatusID'] == 0) { echo "Neste"; } elseif ($Ordre['StatusID'] > 0) { echo "Utfort"; } ?>">1. Registrere</td>
    <td class="<?php if ($Ordre['StatusID'] == 1) { echo "Neste"; } elseif ($Ordre['StatusID'] > 1) { echo "Utfort"; } else { echo "IkkeUtfort"; } ?>">2. Planlegge</td>
    <td class="<?php if ($Ordre['StatusID'] == 2) { echo "Neste"; } elseif ($Ordre['StatusID'] > 2) { echo "Utfort"; } else { echo "IkkeUtfort"; } ?>">3. Godkjenne</td>
    <td class="<?php if ($Ordre['StatusID'] == 3) { echo "Neste"; } elseif ($Ordre['StatusID'] > 3) { echo "Utfort"; } else { echo "IkkeUtfort"; } ?>">4. Bestille</td>
    <td class="<?php if ($Ordre['StatusID'] == 4) { echo "Neste"; } elseif ($Ordre['StatusID'] > 4) { echo "Utfort"; } else { echo "IkkeUtfort"; } ?>">5. Motta</td>
    <td class="<?php if ($Ordre['StatusID'] == 5) { echo "Neste"; } elseif ($Ordre['StatusID'] > 5) { echo "Utfort"; } else { echo "IkkeUtfort"; } ?>">6. Fullføre</td>
  </tr>
</table>
-->
<?php echo form_open('okonomi/innkjopsordre'); ?>
<input type="hidden" name="OrdreID" value="<?php echo set_value('OrdreID',$Ordre['OrdreID']); ?>" />
<fieldset>
  <legend>Innkjøpsordre</legend>

  <p>
    <label for="ProsjektID">Prosjekt:</label>
    <select name="ProsjektID">
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
  </p>

  <p>
    <label for="PersonID">Ansvarlig:</label>
    <select name="PersonAnsvarligID"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?>>
      <option value="0" <?php echo set_select('PersonAnsvarligID',0,($Ordre['PersonAnsvarligID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  foreach ($Medlemmer as $Person) {
?>
      <option value="<?php echo $Person['PersonID']; ?>" <?php echo set_select('PersonAnsvarligID',$Person['PersonID'],($Ordre['PersonAnsvarligID'] == $Person['PersonID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
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
      <option value="<?php echo $Organisasjon['OrganisasjonID']; ?>" <?php echo set_select('LeverandorID',$Organisasjon['OrganisasjonID'],($Ordre['LeverandorID'] == $Organisasjon['OrganisasjonID']) ? TRUE : FALSE); ?>><?php echo $Organisasjon['Navn']; ?></option>
<?php
  }
?>
    </select>
  </p>

  <p>
    <label for="Referanse">Referanse:</label>
    <input type="text" name="Referanse" value="<?php echo set_value('Referanse',$Ordre['Referanse']); ?>"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?> />
  </p>

  <p>
    <label for="Navn" style="vertical-align: top">Beskrivelse:</label>
    <textarea name="Beskrivelse" id="Beskrivelse"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?>><?php echo set_value('Beskrivelse',$Ordre['Beskrivelse']); ?></textarea>
  </p>

  <p>
    <label for="Status">Status</label>
    <span><?php echo $Ordre['Status']; ?></span>
  </p>

<?php if ($Ordre['StatusID'] < 6) { ?>
  <p class="handlinger">
    <label>&nbsp;</label>
<?php if ($Ordre['StatusID'] == 0) { ?>
    <input type="submit" name="OrdreLagre" id="LagreProsjekt" value="Lagre"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?> />
<?php } elseif ($Ordre['StatusID'] == 1) { ?>
    <input type="submit" name="OrdreLagre" id="LagreProsjekt" value="Lagre"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?> />
    <input type="submit" name="OrdreSlett" value="Slett" <?php if ($Redigerbar1 == 0) { ?>disabled <?php } ?>/>
    <input type="button" value="Send til godkjenning" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['OrdreID']; ?>&status=2';"<?php if ($Redigerbar1 == 0) { echo " disabled"; } ?> />
<?php } elseif ($Ordre['StatusID'] == 2) { ?>
    <input type="button" value="Godkjenn" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['OrdreID']; ?>&status=3';"<?php if (!in_array('307',$UABruker['UAP'])) { echo " disabled"; } ?> />
    <input type="button" value="Avvis" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['OrdreID']; ?>&status=1';"<?php if (!in_array('307',$UABruker['UAP'])) { echo " disabled"; } ?> />
<?php } elseif ($Ordre['StatusID'] == 3) { ?>
    <input type="button" value="Bestilt" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['OrdreID']; ?>&status=4';"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
    <input type="button" value="Tilbake til planlegging" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['OrdreID']; ?>&status=1';"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
<?php } elseif ($Ordre['StatusID'] == 4) { ?>
    <!--<input type="button" value="Levert" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['OrdreID']; ?>&status=5';"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />-->
<?php } elseif ($Ordre['StatusID'] == 5) { ?>
    <input type="button" value="Fullført" onclick="javascript:document.location.href='<?php echo site_url(); ?>/okonomi/settinnkjopsordrestatus/?iid=<?php echo $Ordre['OrdreID']; ?>&status=6';"<?php if ($Redigerbar2 == 0) { echo " disabled"; } ?> />
<?php } ?>
  </p>
<?php } ?>
</fieldset>
<?php echo form_close(); ?>

<fieldset style="background-color: #E0E0E0;">
  <legend onclick="javascript:$('#ListeVarelinjer').toggle();">Varelinjer</legend>

  <div id="ListeVarelinjer">
  <br />
<table style="font-size: 0.6em;">
  <tr>
    <th>Varenummer</th>
    <th>Varenavn</th>
    <th style="width:100px;text-align:center;">Pris</th>
    <th style="text-align:center;">Antall</th>
    <th style="width:100px;text-align:center;">Sum</th>
    <th style="text-align:center;">Levert</th>
    <th>&nbsp;</th>
  </tr>
<?php
  if (isset($Varelinjer)) {
    $i = 0;
    $TotalSum = 0;
    foreach ($Varelinjer as $Linje) {
      $i++;
      $TotalSum = $TotalSum + $Linje['Sum'];
?>
  <tr<?php if ($Linje['Antall'] == $Linje['Levert']) { ?> style="text-decoration:line-through;"<?php } ?>>
    <td><?php echo $Linje['Varenummer']; ?></td>
    <td><?php echo $Linje['Varenavn']; ?></td>
    <td style="text-align:right;">kr <?php echo number_format($Linje['Pris'],2,',','.'); ?></td>
    <td style="text-align:right;"><?php echo $Linje['Antall']; ?> stk</td>
    <td style="text-align:right;">kr <?php echo number_format($Linje['Sum'],2,',','.'); ?></td>
    <td style="text-align:right;"><?php if ($Linje['Levert'] == "") { echo "0"; } else { echo $Linje['Levert']; } ?> stk</td>
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
    $('#ListeVarelinjer').toggle();
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
  </div>
</fieldset>

<?php if ($Ordre['StatusID'] == 1) { ?>
<?php echo form_open('okonomi/nyinnkjopsordrelinje'); ?>
<input type="hidden" name="OrdreID" value="<?php echo set_value('InnkjopsordreID',$Ordre['OrdreID']); ?>" />
<input type="hidden" name="LinjeID" id="LinjeID" value="0" />
<fieldset>
  <legend onclick="javascript:$('#SkjemaNyVarelinje').toggle();">Ny varelinje</legend>

  <div style="display:none;" id="SkjemaNyVarelinje">
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
  </div>
</fieldset>
<?php echo form_close(); ?>
<?php } ?>
