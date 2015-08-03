<?php
  $Redigerbar = 0;
  if (($Utstyr['ID'] == 0) and (in_array('401',$UABruker['UAP']))) {
    $Redigerbar = 1;
  } elseif (($Utstyr['ID'] > 0) and (in_array('402',$UABruker['UAP'])))  {
    $Redigerbar = 1;
  }
?>
<?php echo form_open('materiell/utstyr'); ?>
<input type="hidden" name="ID" value="<?php echo set_value('ID',$Utstyr['ID']); ?>" />
<input type="hidden" name="ForeldreID" value="0" />
<fieldset>
  <legend>Utstyr</legend>

  <p>
    <label>ID:</label>
    <?php echo $Utstyr['UID']; ?>
  </p>

  <p>
    <label for="FaggruppeID">Faggruppe:</label>
    <select name="FaggruppeID" id="FaggruppeID"<?php if ($Redigerbar == 0) { echo " disabled"; } ?>>
      <option value="0" <?php echo set_select('FaggruppeID',0,($Utstyr['FaggruppeID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Faggrupper)) {
    foreach ($Faggrupper as $Faggruppe) {
?>
      <option value="<?php echo $Faggruppe['ID']; ?>" <?php echo set_select('FaggruppeID',$Faggruppe['ID'],($Utstyr['FaggruppeID'] == $Faggruppe['ID']) ? TRUE : FALSE); ?>><?php echo $Faggruppe['Navn']; ?></option>
<?php
    }
  }
?>
    </select>
  </p>

  <p>
    <label for="GruppeID">Gruppe:</label>
    <select name="GruppeID" id="GruppeID"<?php if ($Redigerbar == 0) { echo " disabled"; } ?>>
      <option value="0" <?php echo set_select('GruppeID',0,($Utstyr['GruppeID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Grupper)) {
    foreach ($Grupper as $Gruppe) {
?>
      <option value="<?php echo $Gruppe['ID']; ?>" <?php echo set_select('GruppeID',$Gruppe['ID'],($Utstyr['GruppeID'] == $Gruppe['ID']) ? TRUE : FALSE); ?>><?php echo $Gruppe['Navn']; ?></option>
<?php
    }
  }
?>
    </select>
  </p>

  <p>
    <label for="TypeID">Type:</label>
    <select name="TypeID" id="TypeID"<?php if ($Redigerbar == 0) { echo " disabled"; } ?>>
      <option value="0" <?php echo set_select('TypeID',0,($Utstyr['TypeID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Typer)) {
    foreach ($Typer as $Type) {
?>
      <option value="<?php echo $Type['ID']; ?>" <?php echo set_select('TypeID',$Type['ID'],($Utstyr['TypeID'] == $Type['ID']) ? TRUE : FALSE); ?>><?php echo $Type['Navn']; ?></option>
<?php
    }
  }
?>
    </select>
  </p>

  <p>
    <label for="ProdusentID">Produsent:</label>
    <select name="ProdusentID" id="ProdusentID"<?php if ($Redigerbar == 0) { echo " disabled"; } ?>>
      <option value="0" <?php echo set_select('ProdusentID',0,($Utstyr['ProdusentID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Produsenter)) {
    foreach ($Produsenter as $Produsent) {
?>
      <option value="<?php echo $Produsent['ID']; ?>" <?php echo set_select('ProdusentID',$Produsent['ID'],($Utstyr['ProdusentID'] == $Produsent['ID']) ? TRUE : FALSE); ?>><?php echo $Produsent['Navn']; ?></option>
<?php
    }
  }
?>
    </select>
  </p>

  <p>
    <label for="LeverandorID">Leverandør:</label>
    <select name="LeverandorID" id="LeverandorID"<?php if ($Redigerbar == 0) { echo " disabled"; } ?>>
      <option value="0" <?php echo set_select('LeverandorID',0,($Utstyr['LeverandorID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Leverandorer)) {
    foreach ($Leverandorer as $Leverandor) {
?>
      <option value="<?php echo $Leverandor['ID']; ?>" <?php echo set_select('LeverandorID',$Leverandor['ID'],($Utstyr['LeverandorID'] == $Leverandor['ID']) ? TRUE : FALSE); ?>><?php echo $Leverandor['Navn']; ?></option>
<?php
    }
  }
?>
    </select>
  </p>

  <p>
    <label for="DatoAnskaffet">Dato anskaffet:</label>
    <input type="date" name="DatoAnskaffet" id="DatoAnskaffet" value="<?php echo set_value('DatoAnskaffet',$Utstyr['DatoAnskaffet']); ?>"<?php if ($Redigerbar == 0) { echo " disabled"; } ?> />
  </p>

  <p>
    <label for="Modell">Modell:</label>
    <input type="text" name="Modell" id="Modell" value="<?php echo set_value('Modell',$Utstyr['Modell']); ?>"<?php if ($Redigerbar == 0) { echo " disabled"; } ?> />
  </p>

  <p>
    <label for="Serienummer">Serienummer:</label>
    <input type="text" name="Serienummer" id="Serienummer" value="<?php echo set_value('Serienummer',$Utstyr['Serienummer']); ?>"<?php if ($Redigerbar == 0) { echo " disabled"; } ?> />
  </p>

  <p>
    <label for="Notater">Notater:</label>
    <textarea name="Notater" id="Notater"<?php if ($Redigerbar == 0) { echo " disabled"; } ?>><?php echo set_value('Notater',$Utstyr['Notater']); ?></textarea>
  </p>

  <p>
    <label for="Kostnad">Kostnad:</label>
    <input type="number" name="Kostnad" id="Kostnad" value="<?php echo set_value('Kostnad',$Utstyr['Kostnad']); ?>" step="ANY" />
  </p>

  <p>
    <label for="Lagerplass">Lager:</label>
    <select name="Lagerplass" id="Lagerplass"<?php if ($Redigerbar == 0) { echo " disabled"; } ?>>
      <option value="0.0" <?php echo set_select('Lagerplass','0.0',($Utstyr['Lagerplass'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Lagerplasser)) {
    foreach ($Lagerplasser as $Lagerplass) {
?>
      <optgroup label="<?php echo $Lagerplass['Kode']." ".$Lagerplass['Navn']; ?>">
        <option value="<?php echo $Lagerplass['ID'].".0"; ?>" <?php echo set_select('Lagerplass',$Lagerplass['ID'].".0",($Utstyr['Lagerplass'] == $Lagerplass['ID'].".0") ? TRUE : FALSE); ?>><?php echo $Lagerplass['Kode']." ".$Lagerplass['Navn']." (ingen kasse)"; ?></option>
<?php
      if (isset($Lagerplass['Kasser'])) {
        foreach ($Lagerplass['Kasser'] as $Kasse) {
?>
        <option value="<?php echo $Lagerplass['ID'].".".$Kasse['ID']; ?>" <?php echo set_select('Lagerplass',$Lagerplass['ID'].".".$Kasse['ID'],($Utstyr['Lagerplass'] == $Lagerplass['ID'].".".$Kasse['ID']) ? TRUE : FALSE); ?>><?php echo $Lagerplass['Kode']." ".$Lagerplass['Navn']." ".$Kasse['Navn']; ?></option>
<?php
	}
      }
?>
      </optgroup>
<?php
    }
  }
?>
    </select>
  </p>

  <p>
    <label>Status:</label>
    <span><?php echo $Utstyr['Status']; ?></span>
  </p>

  <p class="handlinger">
    <label>&nbsp;</label>
    <input type="submit" value="Lagre" />
<?php if ($Utstyr['ID'] > 0) { ?>
    <input type="submit" value="Opprett kopi" name="LagreKopi" />
<?php } ?>
  </p>
</fieldset>
<?php echo form_close(); ?>

<?php echo form_open('materiell/nyttvedlikehold'); ?>
<fieldset>
  <legend>Vedlikehold</legend>

  <table>
    <tr>
      <th>Dato</th>
      <th>Utført av</th>
      <th>Notat</th>
    </tr>
<?php
  if (isset($Vedlikehold)) {
    foreach ($Vedlikehold as $Logg) {
?>
    <tr>
      <td><?php echo date('d.m.Y H:i',strtotime($Logg['DatoRegistrert'])); ?></td>
      <td><?php echo $Logg['PersonID']; ?></td>
      <td><?php echo $Logg['Notat']; ?></td>
    </tr>
<?php
    }
  }
?>
  </table>

  <textarea name="NyttVedlikehold"></textarea>
  <input type="submit" value="Lagre vedlikehold" />
</fieldset>
<?php echo form_close(); ?>
