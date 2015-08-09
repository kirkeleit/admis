<h3 class="sub-header">Prosjektdetaljer</h3>

<?php echo form_open('prosjekter/prosjekt/'.$Prosjekt['ProsjektID']); ?>
<input type="hidden" name="ProsjektID" id="ProsjektID" value="<?php echo set_value('ProsjektID',$Prosjekt['ProsjektID']); ?>" />

<div class="panel panel-default">
  <div class="panel-heading">&nbsp;</div>

  <div class="panel-body">

    <div class="form-group">
      <label for="ProsjektAr">Prosjektår:</label>
      <input type="number" class="form-control" name="ProsjektAr" id="ProsjektAr" value="<?php echo set_value('ProsjektAr',($Prosjekt['ProsjektAr'] == '' ? date('Y') : $Prosjekt['ProsjektAr'])); ?>" required />
    </div>

    <div class="form-group">
      <label for="FaggruppeID">Faggruppe:</label>
      <select name="FaggruppeID" id="FaggruppeID" class="form-control">
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
    </div>

    <div class="form-group">
      <label for="PersonProsjektlederID">Prosjektleder:</label>
      <select name="PersonProsjektlederID" id="PersonProsjektlederID" class="form-control">
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
    </div>

    <div class="form-group">
      <label for="DatoProsjektstart">Prosjektperiode:</label>
      <input type="date" class="form-control" name="DatoProsjektstart" id="DatoProsjektstart" value="<?php echo set_value('DatoProsjektstart',($Prosjekt['DatoProsjektstart'] == '' ? '' : ($Prosjekt['DatoProsjektstart'] != '0000-00-00' ? date('d.m.Y',strtotime($Prosjekt['DatoProsjektstart'])) : ''))); ?>" />
      <input type="date" class="form-control" name="DatoProsjektslutt" id="DatoProsjektslutt" value="<?php echo set_value('DatoProsjektslutt',($Prosjekt['DatoProsjektslutt'] == '' ? '' : ($Prosjekt['DatoProsjektslutt'] != '0000-00-00' ? date('d.m.Y',strtotime($Prosjekt['DatoProsjektslutt'])) : ''))); ?>" />
    </div>

    <div class="form-group">
      <label for="Prosjektnavn">Prosjektnavn:</label>
      <input type="text" class="form-control" name="Prosjektnavn" id="Prosjektnavn" value="<?php echo set_value('Prosjektnavn',$Prosjekt['Prosjektnavn']); ?>" required />
    </div>

    <div class="form-group">
      <label for="Formaal" style="vertical-align: top">Formål:</label>
      <textarea name="Formaal" class="form-control" id="Formaal" rows="6" cols="46" required><?php echo set_value('Formaal',$Prosjekt['Formaal']); ?></textarea>
    </div>

    <div class="form-group">
      <label for="Prosjektmaal" style="vertical-align: top">Prosjektmål:</label>
      <textarea name="Prosjektmaal" class="form-control" id="Prosjektmaal" rows="6" cols="46" required><?php echo set_value('Prosjektmaal',$Prosjekt['Prosjektmaal']); ?></textarea>
    </div>

    <div class="form-group">
      <label for="Maalgruppe" style="vertical-align: top">Målgruppe:</label>
      <textarea name="Maalgruppe" class="form-control" id="Maalgruppe" rows="6" cols="46" required><?php echo set_value('Maalgruppe',$Prosjekt['Maalgruppe']); ?></textarea>
    </div>

    <div class="form-group">
      <label for="Prosjektbeskrivelse" style="vertical-align: top">Prosjektbeskrivelse:</label>
      <textarea name="Prosjektbeskrivelse" class="form-control" id="Prosjektbeskrivelse" rows="6" cols="46" required><?php echo set_value('Prosjektbeskrivelse',$Prosjekt['Prosjektbeskrivelse']); ?></textarea>
    </div>

    <div class="form-group">
      <label for="Arbeidstimer">Arbeidstimer:</label>
      <input type="number" class="form-control" name="Arbeidstimer" value="<?php echo set_value('Arbeidstimer',$Prosjekt['Arbeidstimer']); ?>" />
    </div>

    <div class="form-group">
      <label for="Budsjettramme">Budsjettramme:</label>
      <input type="number" class="form-control" name="Budsjettramme" id="Budsjettramme" value="<?php echo set_value('Budsjettramme',$Prosjekt['Budsjettramme']); ?>" step="1000" required />
    </div>

  <div class="form-group">
    <label for="Status">Status:</label>
    <span><?php echo ($Prosjekt['Status'] == '' ? 'Under registrering' : $Prosjekt['Status']); ?></span>
  </div>

    <div class="form-group">
      <div class="btn-group">
        <input type="submit" value="Lagre" name="ProsjektLagre" class="btn btn-primary" />
        <input type="submit" value="Slett" name="ProsjektSlett" class="btn btn-danger" />
      </div>
      <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Handling <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
          <li><a href="#">Send til godkjenning</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#">Godkjenn prosjekt</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#">Sett til påbegynt</a></li>
          <li><a href="#">Sett til fullført</a></li>
        </ul>
      </div>
    </div>

  </div>
</div>
<?php echo form_close(); ?>

<?php if (isset($Innkjopsordrer)) { ?>
<?php $TotalOrdresum = 0; ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Innkjøpsordrer</h3>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover table-condensed">
        <thead>
          <tr>
            <th>Dato</th>
            <th>Referanse</th>
            <th>Ansvarlig</th>
            <th>Ordresum</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
<?php foreach ($Innkjopsordrer as $Ordre) { ?>
<?php $TotalOrdresum = $TotalOrdresum + $Ordre['OrdreSum']; ?>
          <tr>
            <td><?php echo date('d.m.Y',strtotime($Ordre['DatoRegistrert'])); ?></td>
            <td><?php echo $Ordre['Referanse']; ?></td>
            <td><?php echo $Ordre['PersonAnsvarligNavn']; ?></td>
            <td><?php echo 'kr '.number_format($Ordre['OrdreSum'],2,',','.'); ?></td>
            <td><?php echo $Ordre['Status']; ?></td>
          </tr>
<?php } ?>
          <tr>
            <td colspan="3">&nbsp;</td>
            <td><?php echo 'kr '.number_format($TotalOrdresum,2,',','.'); ?></td>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php } ?>

<?php if (isset($Utgifter)) { ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Utgifter</h3>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-condensed">
      <thead>
        <tr>
          <th>Dato</th>
          <th>Initialer</th>
          <th>Beskrivelse</th>
          <th>Beløp</th>
        </tr>
<?php
    $TotaleUtgifter = 0;
    foreach ($Utgifter as $Utgift) {
      $TotaleUtgifter = $TotaleUtgifter + $Utgift['Belop'];
?>
    <tr>
      <td><?php echo date('d.m.Y',strtotime($Utgift['DatoBokfort'])); ?></td>
      <td><?php echo $Utgift['PersonInitialer']; ?></td>
      <td><?php echo $Utgift['Beskrivelse']; ?></td>
      <td class="text-right"><?php echo 'kr '.number_format($Utgift['Belop'],2,',','.'); ?></td>
    </tr>
<?php
    }
?>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td class="text-right"><?php echo 'kr '.number_format($TotaleUtgifter,2,',','.'); ?></td>
      </tr>
    </table>
  </div>
</div>
<?php } ?>

<?php if ($Prosjekt['ProsjektID'] > 0) { ?>
<?php echo form_open('prosjekter/prosjekt/'.$Prosjekt['ProsjektID']); ?>
<input type="hidden" name="ProsjektID" value="<?php echo $Prosjekt['ProsjektID']; ?>" />
<div class="panel panel-default">
  <div class="panel-heading">Kommentarer</div>
  <div class="panel-body">

<?php
  if (isset($Prosjekt['Kommentarer'])) {
    foreach ($Prosjekt['Kommentarer'] as $Kommentar) {
?>
    <div class="panel panel-default panel-info">
      <div class="panel-heading"><?php echo date('d.m.Y H:i',strtotime($Kommentar['DatoRegistrert'])).", av ".$Kommentar['PersonNavn']; ?></div>
      <div class="panel-body"><?php echo nl2br($Kommentar['Kommentar']); ?></div>
    </div>
<?php
    }
  }
?>

<?php if (($Prosjekt['StatusID'] < 5) and (in_array('501',$UABruker['UAP']))) { ?>
    <div class="panel panel-default">
      <div class="panel-heading">Nytt kommentar</div>
      <div class="panel-body">
        <div class="form-group">
          <textarea name="NyKommentar" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary btn-xs" value="Legg inn kommentar" name="KommentarLagre" />
        </div>
      </div>
    </div>
<?php } ?>

  </div>
</div>
<?php echo form_close(); ?>
<?php } ?>
