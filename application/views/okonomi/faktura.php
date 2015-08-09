<h3 class="sub-header">Fakturadetaljer</h3>

<?php echo form_open('/okonomi/faktura/'.$Faktura['FakturaID']); ?>
<input type="hidden" name="FakturaID" value="<?php echo $Faktura['FakturaID']; ?>" />
<div class="panel panel-default">
  <div class="panel-heading">&nbsp;</div>

  <div class="panel-body">
    <div class="form-group">
      <label for="OrganisasjonID">Mottaker:</label>
      <select name="OrganisasjonID" class="form-control">
        <option value="0" <?php echo set_select('OrganisasjonID',0,($Faktura['OrganisasjonID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  foreach ($Organisasjoner as $Organisasjon) {
?>
        <option value="<?php echo $Organisasjon['OrganisasjonID']; ?>" <?php echo set_select('OrganisasjonID',$Organisasjon['OrganisasjonID'],($Faktura['OrganisasjonID'] == $Organisasjon['OrganisasjonID']) ? TRUE : FALSE); ?>><?php echo $Organisasjon['Navn']; ?></option>
<?php
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="Referanse">Referanse:</label>
      <input type="text" class="form-control" name="Referanse" value="<?php echo set_value('Referanse',$Faktura['Referanse']); ?>" />
    </div>

    <div class="form-group">
      <label for="PersonRegistrertID">Ansvarlig person:</label>
      <select name="PersonAnsvarligID" class="form-control">
        <option value="0" <?php echo set_select('PersonAnsvarligID',0,($Faktura['PersonAnsvarligID'] == 0) ? TRUE : FALSE); ?>>(ingen valgt)</option>
<?php
  foreach ($Personer as $Person) {
?>
        <option value="<?php echo $Person['PersonID']; ?>" <?php echo set_select('PersonAnsvarligID',$Person['PersonID'],($Faktura['PersonAnsvarligID'] == $Person['PersonID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
  }
?>
      </select>
      <span class="help-block">Hvem er ansvarlig for å få klargjort faktura og sendt til fakturering?</span>
    </div>

    <div class="form-group">
      <label for="DatoFakturadato">Fakturadato:</label>
      <input type="date" name="DatoFakturadato" class="form-control" value="<?php echo set_value('DatoFakturadato',($Faktura['DatoFakturadato'] != '0000-00-00' ? ($Faktura['DatoFakturadato'] == '' ? '' : date('d.m.Y',strtotime($Faktura['DatoFakturadato']))) : '')); ?>" />
    </div>

    <div class="form-group">
      <label for="Notater">Notater:</label>
      <textarea name="Notater" class="form-control"><?php echo set_value('Notater',$Faktura['Notater']); ?></textarea>
    </div>

    <div class="input-group">
      <div class="btn-group">
<?php if ($Faktura['StatusID'] == 0) { ?>
        <input type="submit" class="btn btn-primary" name="FakturaLagre" value="Lagre" />
        <input type="submit" class="btn btn-success" name="FakturaTilfakturering" value="Send til fakturering" />
        <input type="submit" class="btn btn-default" name="FakturaFakturert" value="Fakturert" disabled />
<?php } elseif ($Faktura['StatusID'] == 1) { ?>
        <input type="submit" class="btn btn-primary" name="FakturaLagre" value="Lagre" disabled />
        <input type="submit" class="btn btn-default" name="FakturaTilfakturering" value="Send til fakturering" disabled />
<?php if (in_array('312',$UABruker['UAP'])) { ?>
        <input type="submit" class="btn btn-success" name="FakturaFakturert" value="Fakturert" />
<?php } else { ?>
        <input type="submit" class="btn btn-default" name="FakturaFakturert" value="Fakturert" disabled />
<?php } ?>
<?php } else { ?>
        <input type="submit" class="btn btn-primary" name="FakturaLagre" value="Lagre" disabled />
        <input type="submit" class="btn btn-default" name="FakturaTilfakturering" value="Send til fakturering" disabled />
        <input type="submit" class="btn btn-default" name="FakturaFakturert" value="Fakturert" disabled />
<?php } ?>
      </div>
    </div>

  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Fakturalinjer</div>

  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover table-condensed">
        <thead>
          <tr>
            <th>Produktnummer</th>
            <th>Beskrivelse</th>
            <th>Pris</th>
            <th>Antall</th>
            <th>Sum</th>
          </tr>
        </thead>
        <tbody>
<?php
  $TotalSum = 0;
  if (isset($Faktura['Fakturalinjer'])) {
    foreach ($Faktura['Fakturalinjer'] as $Linje) {
      $TotalSum = $TotalSum + ($Linje['Pris'] * $Linje['Antall']);
?>
          <tr>
            <td><?php echo $Linje['Produktnummer']; ?></td>
            <td id="EndreVarelinje<?php echo $Linje['LinjeID']; ?>"><?php echo $Linje['Beskrivelse']; ?></td>
            <td class="text-right"><?php echo 'kr '.number_format($Linje['Pris'],2,',','.'); ?></td>
            <td class="text-center"><?php echo $Linje['Antall'].' stk'; ?></td>
            <td class="text-right"><?php echo 'kr '.number_format(($Linje['Pris'] * $Linje['Antall']),2,',','.'); ?></td>
          </tr>
<script>
  $('#EndreVarelinje<?php echo $Linje['LinjeID']; ?>').click(function() {
    $('#FakturalinjeLinjeID').val('<?php echo $Linje['LinjeID']; ?>');
    $('#FakturalinjeProduktnummer').val('<?php echo $Linje['Produktnummer']; ?>');
    $('#FakturalinjeBeskrivelse').val('<?php echo $Linje['Beskrivelse']; ?>');
    $('#FakturalinjePris').val('<?php echo $Linje['Pris']; ?>');
    $('#FakturalinjeAntall').val('<?php echo $Linje['Antall']; ?>');
  });
</script>
<?php
    }
  }
?>
          <tr>
            <td colspan="4">&nbsp;</td>
            <td class="text-right"><?php echo 'kr '.number_format($TotalSum,2,',','.'); ?></td>
          </tr>
          <tr><input type="hidden" name="FakturalinjeLinjeID" id="FakturalinjeLinjeID"value="" />
            <td><input type="text" class="form-control" name="FakturalinjeProduktnummer" id="FakturalinjeProduktnummer" /></td>
            <td><input type="text" class="form-control" name="FakturalinjeBeskrivelse" id="FakturalinjeBeskrivelse" /></td>
            <td><input type="number" class="form-control" name="FakturalinjePris" id="FakturalinjePris" /></td>
            <td><input type="number" class="form-control" name="FakturalinjeAntall" id="FakturalinjeAntall" /></td>
            <td><input type="submit" class="btn btn-default" name="FakturaLagrelinje" value="Lagre linje" /></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php echo form_close(); ?>
