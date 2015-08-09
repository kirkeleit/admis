<h3 class="sub-header">Utstyrsdetaljer</h3>

<?php echo form_open('materiell/utstyr/'.$Utstyr['UtstyrID']); ?>
<input type="hidden" name="UtstyrID" value="<?php echo set_value('UtstyrID',$Utstyr['UtstyrID']); ?>" />
<div class="panel panel-default">
  <div class="panel-heading">&nbsp;</div>

  <div class="panel-body">
    <div class="form-group">
      <label>ID:</label>
      <?php echo $Utstyr['UID']; ?>
    </div>

    <div class="form-group">
      <label for="FaggruppeID">Faggruppe:</label>
      <select name="FaggruppeID" id="FaggruppeID" class="form-control">
        <option value="0" <?php echo set_select('FaggruppeID',0,($Utstyr['FaggruppeID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Faggrupper)) {
    foreach ($Faggrupper as $Faggruppe) {
?>
        <option value="<?php echo $Faggruppe['FaggruppeID']; ?>" <?php echo set_select('FaggruppeID',$Faggruppe['FaggruppeID'],($Utstyr['FaggruppeID'] == $Faggruppe['FaggruppeID']) ? TRUE : FALSE); ?>><?php echo $Faggruppe['Navn']; ?></option>
<?php
    }
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="GruppeID">Gruppe:</label>
      <select name="GruppeID" id="GruppeID" class="form-control">
        <option value="0" <?php echo set_select('GruppeID',0,($Utstyr['GruppeID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Grupper)) {
    foreach ($Grupper as $Gruppe) {
?>
        <option value="<?php echo $Gruppe['GruppeID']; ?>" <?php echo set_select('GruppeID',$Gruppe['GruppeID'],($Utstyr['GruppeID'] == $Gruppe['GruppeID']) ? TRUE : FALSE); ?>><?php echo $Gruppe['Navn']; ?></option>
<?php
    }
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="TypeID">Type:</label>
      <select name="TypeID" id="TypeID" class="form-control">
        <option value="0" <?php echo set_select('TypeID',0,($Utstyr['TypeID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Typer)) {
    foreach ($Typer as $Type) {
?>
        <option value="<?php echo $Type['TypeID']; ?>" <?php echo set_select('TypeID',$Type['TypeID'],($Utstyr['TypeID'] == $Type['TypeID']) ? TRUE : FALSE); ?>><?php echo $Type['Navn']; ?></option>
<?php
    }
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="ProdusentID">Produsent:</label>
      <select name="ProdusentID" id="ProdusentID" class="form-control">
        <option value="0" <?php echo set_select('ProdusentID',0,($Utstyr['ProdusentID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Produsenter)) {
    foreach ($Produsenter as $Produsent) {
?>
        <option value="<?php echo $Produsent['ProdusentID']; ?>" <?php echo set_select('ProdusentID',$Produsent['ProdusentID'],($Utstyr['ProdusentID'] == $Produsent['ProdusentID']) ? TRUE : FALSE); ?>><?php echo $Produsent['Navn']; ?></option>
<?php
    }
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="Modell">Modell:</label>
      <input type="text" class="form-control" name="Modell" id="Modell" value="<?php echo set_value('Modell',$Utstyr['Modell']); ?>" />
    </div>

    <div class="form-group">
      <label for="Lagerplass">Lager:</label>
      <select name="Lagerplass" id="Lagerplass" class="form-control">
        <option value="0.0" <?php echo set_select('Lagerplass','0.0',($Utstyr['Lagerplass'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Lagerplasser)) {
    foreach ($Lagerplasser as $Lagerplass) {
?>
        <optgroup label="<?php echo $Lagerplass['Kode']." ".$Lagerplass['Navn']; ?>">
          <option value="<?php echo $Lagerplass['LagerplassID'].".0"; ?>" <?php echo set_select('Lagerplass',$Lagerplass['LagerplassID'].".0",($Utstyr['Lagerplass'] == $Lagerplass['LagerplassID'].".0") ? TRUE : FALSE); ?>><?php echo $Lagerplass['Kode']." ".$Lagerplass['Navn']." (ingen kasse)"; ?></option>
<?php
      if (isset($Lagerplass['Kasser'])) {
        foreach ($Lagerplass['Kasser'] as $Kasse) {
?>
          <option value="<?php echo $Lagerplass['LagerplassID'].".".$Kasse['KasseID']; ?>" <?php echo set_select('Lagerplass',$Lagerplass['LagerplassID'].".".$Kasse['KasseID'],($Utstyr['Lagerplass'] == $Lagerplass['LagerplassID'].".".$Kasse['KasseID']) ? TRUE : FALSE); ?>><?php echo $Lagerplass['Kode']." ".$Lagerplass['Navn']." ".$Kasse['Navn']; ?></option>
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
    </div>

    <div class="form-group">
      <label>Status:</label>
      <span><?php echo $Utstyr['Status']; ?></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Lagre" />
      <input type="submit" class="btn btn-default" value="Opprett kopi" name="LagreKopi" />
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">Innkjøp</div>

      <div class="panel-body">
        <div class="form-group">
          <label for="LeverandorID">Leverandør:</label>
          <select name="LeverandorID" id="LeverandorID" class="form-control">
            <option value="0" <?php echo set_select('LeverandorID',0,($Utstyr['LeverandorID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Leverandorer)) {
    foreach ($Leverandorer as $Leverandor) {
?>
            <option value="<?php echo $Leverandor['OrganisasjonID']; ?>" <?php echo set_select('LeverandorID',$Leverandor['OrganisasjonID'],($Utstyr['LeverandorID'] == $Leverandor['OrganisasjonID']) ? TRUE : FALSE); ?>><?php echo $Leverandor['Navn']; ?></option>
<?php
    }
  }
?>
          </select>
        </div>

        <div class="form-group">
          <label for="DatoAnskaffet">Dato anskaffet:</label>
          <input type="date" class="form-control" name="DatoAnskaffet" id="DatoAnskaffet" value="<?php echo set_value('DatoAnskaffet',date('d.m.Y',strtotime($Utstyr['DatoAnskaffet']))); ?>" />
        </div>

        <div class="form-group">
          <label for="Kostnad">Kostnad:</label>
          <input type="number" class="form-control" name="Kostnad" id="Kostnad" value="<?php echo set_value('Kostnad',$Utstyr['Kostnad']); ?>" step="ANY" />
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">Egenskaper</div>

      <div class="panel-body">
        <div class="form-group">
          <label for="Serienummer">Serienummer:</label>
          <input type="text" class="form-control" name="Serienummer" id="Serienummer" value="<?php echo set_value('Serienummer',$Utstyr['Serienummer']); ?>" />
        </div>

        <div class="form-group">
          <label for="Notater">Notater:</label>
          <textarea name="Notater" class="form-control" id="Notater"><?php echo set_value('Notater',$Utstyr['Notater']); ?></textarea>
        </div>
      </div>

    </div>
  </div>
</div>
<?php echo form_close(); ?>

<div class="panel panel-default">
  <div class="panel-heading">Vedlikehold</div>

  <div class="panel-body">
<?php
  if (isset($Vedlikehold)) {
    foreach ($Vedlikehold as $Logg) {
      switch ($Logg['NyStatusID']) {
        case 1:
          $klasse = 'panel-success';
          break;
        case 2:
          $klasse = 'panel-success';
          break;
        case 3:
          $klasse = 'panel-danger';
          break;
        case 4:
          $klasse = 'panel-danger';
          break;
        case 5:
          $klasse = 'panel-danger';
          break;
      }
?>
    <div class="panel panel-default <?php echo $klasse; ?>">
      <div class="panel-heading"><?php echo date('d.m.Y H:i',strtotime($Logg['DatoRegistrert'])).", av ".$Logg['PersonNavn']; ?></div>
      <div class="panel-body"><?php echo nl2br($Logg['Notat']); ?></div>
    </div>
<?php
    }
  }
?>

<?php echo form_open('materiell/nyttvedlikehold'); ?>
<input type="hidden" name="UtstyrID" value="<?php echo $Utstyr['UtstyrID']; ?>" />
    <div class="panel panel-default">
      <div class="panel-heading">Nytt vedlikehold</div>
      <div class="panel-body">
        <div class="form-group">
          <select name="NyStatus">
            <option value="0">(uendret)</option>
            <option value="1">Klar</option>
            <option value="2">Klar / vedlikehold</option>
            <option value="3">Ikke klar / vedlikehold</option>
            <option value="4">Ikke klar / ødelagt</option>
            <option value="5">Ikke klar / tapt</option>
          </select>
        </div>
        <div class="form-group">
          <textarea name="NyttVedlikehold" id="Notat" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary btn-xs" value="Lagre vedlikehold" />
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>
