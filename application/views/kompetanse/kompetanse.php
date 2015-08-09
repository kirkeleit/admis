<h3 class="sub-header">Kompetansedetaljer</h3>

<?php echo form_open('kompetanse/kompetanseinfo/'.$Kompetanse['KompetanseID']); ?>
<input type="hidden" name="KompetanseID" value="<?php echo set_value('KompetanseID',$Kompetanse['KompetanseID']); ?>" />
<div class="panel panel-default">
  <div class="panel-heading">&nbsp;</div>

  <div class="panel-body">
    <div class="form-group">
      <label for="Navn">Navn:</label>
      <input type="text" class="form-control" name="Navn" value="<?php echo set_value('Navn',$Kompetanse['Navn']); ?>" />
    </div>

    <div class="form-group">
      <label for="TypeID">Type:</label>
      <select name="TypeID" class="form-control">
        <option value="0"<?php echo set_select('TypeID',0,($Kompetanse['TypeID'] == 0) ? TRUE : FALSE); ?>>RK-kurs</option>
        <option value="1"<?php echo set_select('TypeID',0,($Kompetanse['TypeID'] == 1) ? TRUE : FALSE); ?>>RK-erfaring</option>
        <option value="2"<?php echo set_select('TypeID',0,($Kompetanse['TypeID'] == 2) ? TRUE : FALSE); ?>>Sertifikat</option>
        <option value="3"<?php echo set_select('TypeID',0,($Kompetanse['TypeID'] == 3) ? TRUE : FALSE); ?>>Intern opplæring</option>
      </select>
    </div>

    <div class="form-group">
      <label for="Timer">Timer:</label>
      <input type="number" name="Timer" class="form-control" value="<?php echo set_value('Timer',($Kompetanse['Timer'] > 0 ? $Kompetanse['Timer'] : '')); ?>" />
    </div>

    <div class="form-group">
      <label for="Gyldighet">Gyldighet:</label>
      <input type="number" name="Gyldighet" class="form-control" value="<?php echo set_value('Gyldighet',($Kompetanse['Gyldighet'] > 0 ? $Kompetanse['Gyldighet'] : '')); ?>" />
    </div>

    <div class="form-group">
      <label for="Beskrivelse">Beskrivelse:</label>
      <textarea class="form-control" name="Beskrivelse"><?php echo set_value('Beskrivelse',$Kompetanse['Beskrivelse']); ?></textarea>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Lagre" name="KompetanseLagre" />
    </div>
  </div>
</div>
