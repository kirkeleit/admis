<!doctype html>
<html lang="no">
<head>
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="pragma" content="no-cache" />
  <meta charset="utf-8" />
  <title>BØMLO RKH PORTAL</title>
  <meta name="viewport" content="width=device-with, initial-scale=1" />
  <link href="/css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet" />
  <script src="/js/jquery-1.10.2.js"></script>
  <script src="/js/jquery-ui-1.10.3.custom.js"></script>
  <style type="text/css">
    #Topp {
      position: fixed;
      background-color: silver;
      border-bottom: 2px solid gray;
      top: 0px;
      right: 0px;
      left: 0px;
      height: 100px;
      padding: 0px;
    }
    #Sidemeny {
      position: fixed;
      background-color: red;
      border-right: 2px solid gray;
      top: 102px;
      left: 0px;
      bottom: 0px;
      width: 120px;
    }
    #Innhold {
      position: fixed;
      background-color: white;
      top: 102px;
      left: 122px;
      right: 20px;
      bottom: 0px;
    }
    #Utstyrsliste {
      position: fixed;
      background-color: blue;
      top: 102px;
      right: 0px;
      /*width: 20px;*/
      max-width: 400px;
      bottom: 0px;
    }

    #Utstyrsliste DIV {
      display: none;
      width: 400px;
    }
  </style>
  <script>
    var Utlevering = 0;
    var TilUtlevering = new Array(0);

    function StartSok(Soketekst) {
      if (Soketekst == "&STARTUTLEVERING&") {
        StartUtlevering();
      } else if (Soketekst == "&STOPPUTLEVERING&") {
        StoppUtlevering();
      } else {
        if (isNaN(Soketekst)) {
          ID = Number(Soketekst.substring(1));
        } else {
          ID = Number(Soketekst);
        }
        if (Utlevering == 0) {
        location.href = '<?php echo site_url(); ?>/materiell/utstyr/'+ID;
        } else {
          HentUtstyr(ID);
        }
      }
      $('#Sokefelt').focus();
    }

    function StartUtlevering() {
      Utlevering = 1;
      $('.Utstyr').show();
      $('#Sokefelt').focus();
    }

    function StoppUtlevering() {
      Utlevering = 0;
      $('.Utstyr').hide();
      $('#Sokefelt').focus();
    }

    function HentUtstyr(ID) {
      $.getJSON("<?php echo base_url(); ?>index.php/materiell/hentutstyrinfo/"+ID, function(data) {
        if (data != null) {
          var Utstyr = {ID:data.ID,UID:data.UID,Modell:data.Modell};
          TilUtlevering[TilUtlevering.length] = Utstyr;
          console.log(TilUtlevering);
          var TR = '<tr><td>'+TilUtlevering.length+'</td><td>'+data.Navn+'</td></tr>';
          $('#Utstyrskvittering > tbody:last').append(TR);
        }
      });
    }
  </script>
</head>
<body>

<div id="Topp">
<input type="text" name="Sokefelt" id="Sokefelt" placeholder="Søk her" />
<input type="button" value="SØK" name="Sokeknapp" id="Sokeknapp" />
<input type="button" value="START UTLEVERING" name="StartUtlevering" id="StartUtlevering" />
<script>
  $('#Sokefelt').keypress(function(e) {
    if (e.which == 13) {
      StartSok($('#Sokefelt').val());
      $('#Sokefelt').val('');
    }
  });
  $('#Sokeknapp').click(function() {
    StartSok($('#Sokefelt').val());
    $('#Sokefelt').val('');
  });
  $('#StartUtlevering').click(function() {
    StartUtlevering();
  });
</script>
</div>

<div id="Sidemeny">
sidemeny
</div>

<div id="Innhold">
<?php echo validation_errors(); ?>
<?php echo $contents; ?>
</div>

<div id="Utstyrsliste">
<div class="Utstyr"><span>UTSTYRSKVITTERING</span>
<table id="Utstyrskvittering">
  <tr>
    <th>#</th>
    <th>Utstyr</th>
  </tr>
  <tbody>

  </tbody>
</table></div>
</div>
<script>
  $(document).ready(function() {
    $('#Sokefelt').focus();
  });
</script>
</body>
</html>
