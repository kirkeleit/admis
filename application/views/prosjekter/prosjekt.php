<?php
  /*$Redigerbar1 = 0;
  $Redigerbar2 = 0;
  if (($Prosjekt['ProsjektID'] == 0) and (in_array('502',$UABruker['UAP']))) {
    $Redigerbar1 = 1;
    $Redigerbar2 = 1;
  } elseif (($Prosjekt['StatusID'] < 2) and (($UABruker['ID'] == $Prosjekt['PersonProsjektlederID']) or (in_array('503',$UABruker['UAP']))))  {
    $Redigerbar1 = 1;
  }
  if (($UABruker['ID'] == $Prosjekt['PersonProsjektlederID']) or (in_array('503',$UABruker['UAP'])))  {
    $Redigerbar2 = 1;
  }*/
?>
<?php echo form_open('prosjekter/prosjekt/'.$Prosjekt['ProsjektID']); ?>
<input type="hidden" name="ProsjektID" id="ProsjektID" value="<?php echo set_value('ProsjektID',$Prosjekt['ProsjektID']); ?>" />
<fieldset>
  <legend>Prosjekt</legend>

  <p>
    <label for="ProsjektAr">Prosjektår:</label>
    <input type="number" name="ProsjektAr" id="ProsjektAr" value="<?php echo set_value('ProsjektAr',($Prosjekt['ProsjektAr'] == '' ? date('Y') : $Prosjekt['ProsjektAr'])); ?>" required />
  </p>

  <p>
    <label for="FaggruppeID">Faggruppe:</label>
    <select name="FaggruppeID" id="FaggruppeID">
      <option value="0" <?php echo set_select('FaggruppeID',0,($Prosjekt['FaggruppeID'] == 0) ? TRUE : FALSE); ?>>(ikke valgt)</option>
<?php
  if (isset($Faggrupper)) {
    foreach ($Faggrupper as $Faggruppe) {
?>
      <option value="<?php echo $Faggruppe['FaggruppeID']; ?>" <?php echo set_select('FaggruppeID',$Faggruppe['FaggruppeID'],($Prosjekt['FaggruppeID'] == $Faggruppe['FaggruppeID']) ? TRUE : FALSE); ?>><?php echo $Faggruppe['Navn']; ?></option>
<?php
    }
  }
?>
    </select>
  </p>

  <p>
    <label for="PersonProsjektlederID">Prosjektleder:</label>
    <select name="PersonProsjektlederID" id="PersonProsjektlederID">
      <option value="0" <?php echo set_select('PersonProsjektlederID',0,($Prosjekt['PersonProsjektlederID'] == 0) ? TRUE : FALSE); ?>>(ikke valgt)</option>
<?php
  if (isset($Medlemmer)) {
    foreach ($Medlemmer as $Person) {
?>
      <option value="<?php echo $Person['PersonID']; ?>" <?php echo set_select('PersonProsjektlederID',$Person['PersonID'],($Prosjekt['PersonProsjektlederID'] == $Person['PersonID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
    }
  }
?>
    </select>
  </p>

  <p>
    <label for="DatoProsjektstart">Prosjektperiode:</label>
    <input type="date" name="DatoProsjektstart" id="DatoProsjektstart" value="<?php echo date("d.m.Y",strtotime(set_value('DatoProsjektstart',$Prosjekt['DatoProsjektstart']))); ?>" />&nbsp;<input type="date" name="DatoProsjektslutt" id="DatoProsjektslutt" value="<?php echo date("d.m.Y",strtotime(set_value('DatoProsjektslutt',$Prosjekt['DatoProsjektslutt']))); ?>" />
  </p>

  <p>
    <label for="Prosjektnavn">Prosjektnavn:</label>
    <input type="text" name="Prosjektnavn" id="Prosjektnavn" value="<?php echo set_value('Prosjektnavn',$Prosjekt['Prosjektnavn']); ?>" required />
  </p>

  <p>
    <label for="Formaal" style="vertical-align: top">Formål:</label>
    <textarea name="Formaal" id="Formaal" rows="6" cols="46" required><?php echo set_value('Formaal',$Prosjekt['Formaal']); ?></textarea>
  </p>

  <p>
    <label for="Prosjektmaal" style="vertical-align: top">Prosjektmål:</label>
    <textarea name="Prosjektmaal" id="Prosjektmaal" rows="6" cols="46" required><?php echo set_value('Prosjektmaal',$Prosjekt['Prosjektmaal']); ?></textarea>
  </p>

  <p>
    <label for="Maalgruppe" style="vertical-align: top">Målgruppe:</label>
    <textarea name="Maalgruppe" id="Maalgruppe" rows="6" cols="46" required><?php echo set_value('Maalgruppe',$Prosjekt['Maalgruppe']); ?></textarea>
  </p>

  <p>
    <label for="Prosjektbeskrivelse" style="vertical-align: top">Prosjektbeskrivelse:</label>
    <textarea name="Prosjektbeskrivelse" id="Prosjektbeskrivelse" rows="6" cols="46" required><?php echo set_value('Prosjektbeskrivelse',$Prosjekt['Prosjektbeskrivelse']); ?></textarea>
  </p>

  <p>
    <label for="Arbeidstimer">Arbeidstimer:</label>
    <input type="number" name="Arbeidstimer" value="<?php echo set_value('Arbeidstimer',$Prosjekt['Arbeidstimer']); ?>" />
  </p>

  <p>
    <label for="Budsjettramme">Budsjettramme:</label>
    <input type="number" name="Budsjettramme" id="Budsjettramme" value="<?php echo set_value('Budsjettramme',$Prosjekt['Budsjettramme']); ?>" step="1000" required />
  </p>

  <p>
    <label for="Status">Status:</label>
    <span><?php echo ($Prosjekt['Status'] == '' ? 'Under registrering' : $Prosjekt['Status']); ?></span>
  </p>

  <p class="handlinger">
    <label>&nbsp;</label>
    <input type="submit" value="Lagre" name="ProsjektLagre" />
    <input type="submit" value="Slett" name="ProsjektSlett" />
    <input type="submit" value="Send til godkjenning" />
    <input type="submit" value="Godkjenn prosjekt" />
    <input type="submit" value="Påbegynt" />
    <input type="button" value="Fullført" />
  </p>

<script>
  $('#SlettProsjekt').click(function(){
    var r = confirm("Er du sikker?");
    if (r) {
      document.location.href='<?php echo site_url(); ?>/prosjekter/slettprosjekt/<?php echo $Prosjekt['ProsjektID']; ?>';
    }
  });
</script>
</fieldset>
<?php echo form_close(); ?>

<?php if (isset($Utgifter)) { ?>
<fieldset>
  <legend>Utgifter</legend>

  <table>
    <tr>
      <th>Dato</th>
      <th>Initialer</th>
      <th>Beskrivelse</th>
      <th>Beløp</th>
    </tr>
<?php
    $TotaleUtgifter = 0;
    foreach ($Utgifter as $Utgift) {
?>
    <tr>
      <td><?php echo $Utgift['DatoBokfort']; ?></td>
      <td><?php echo $Utgift['PersonInitialer']; ?></td>
      <td><?php echo $Utgift['Beskrivelse']; ?></td>
      <td style="text-align: right;">kr <?php echo number_format($Utgift['Belop'],2,',','.'); ?></td>
    </tr>
<?php
      $TotaleUtgifter = $TotaleUtgifter + $Utgift['Belop'];
    }
?>
    <tr>
      <td colspan="3"><b>Totalt:</b></td>
      <td style="text-align: right;"><b>kr <?php echo number_format($TotaleUtgifter,2,',','.'); ?></b></td>
    </tr>
  </table>
</fieldset>
<?php } ?>

<?php if ($Prosjekt['ProsjektID'] > 0) { ?>
<?php echo form_open('prosjekter/prosjekt/'.$Prosjekt['ProsjektID']); ?>
<input type="hidden" name="ProsjektID" value="<?php echo $Prosjekt['ProsjektID']; ?>" />
<fieldset>
  <legend>Kommentarer</legend>
<table>
<?php
  if (isset($Prosjekt['Kommentarer'])) {
    foreach ($Prosjekt['Kommentarer'] as $Kommentar) {
?>
  <tr>
    <td><?php echo date("d.m.Y H:i:s",strtotime($Kommentar['DatoRegistrert'])); ?></td>
    <td><?php echo $Kommentar['PersonNavn']; ?></td>
    <td><?php echo $Kommentar['Kommentar']; ?></td>
  </tr>
<?php
    }
  }
?>
<?php if (($Prosjekt['StatusID'] < 5) and (in_array('501',$UABruker['UAP']))) { ?>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td><textarea name="NyKommentar"></textarea><input type="submit" value="Legg til" name="KommentarLagre" /></td>
  </tr>
<?php } ?>
</table>
</fieldset>
<?php echo form_close(); ?>
<?php } ?>
