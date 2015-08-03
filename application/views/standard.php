<?php
  include "ameny.php";
?>
<!doctype html>
<html lang="no">
<head>
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="pragma" content="no-cache" />
  <meta charset="utf-8" />
  <title>ADMIS <?php echo $_SERVER['PHP_AUTH_USER']; ?></title>
  <meta name="viewport" content="width=device-with, initial-scale=1" />
  <link href="/css/stilark.css" rel="stylesheet" />
  <link href="/css/stilark-meny.css" rel="stylesheet" />
  <link href="/css/stilark-innhold.css" rel="stylesheet" />
  <link href="/css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet" />
  <script src="/js/jquery-1.10.2.js"></script>
  <script src="/js/jquery-ui-1.10.3.custom.js"></script>
  <style type="text/css">
  <!--
    #ProfilDIV {
      position: fixed;
      background-color: silver;
      border: 1px solid gray;
      top: 60px;
      right: 0px;
      max-width: 200px;
      padding: 0px;
    }
    #ProfilDIV IMG {
      width: 40px;
      height: 40px;
      background-color: yellow;
      clear: none;
    }

    #ProfilDIV .Data {
      display: none;
    }

    #ProfilDIV .ProfilNavn {
      float: right;
      width: 160px;
      height: 40px;
      background-color: yellow;
      display: none;
    }
  -->
  </style>
</head>
<body>

<div id="Toppmeny">
</div>

<div id="Innhold">
<?php echo validation_errors(); ?>
<?php echo $contents; ?>
</div>

<div id="Sidemeny">
<ul>
<?php foreach ($AModuler as $AModul) { ?>
<?php if (in_array($AModul['UAP'],$UABruker['UAP'])) { ?>
  <li class="<?php if ($AModul['URL'] == $this->uri->segment(1)) { echo "modulaktiv"; } else { echo "modul"; } ?>"><a href="<?php echo site_url($AModul['URL']); ?>"><?php echo $AModul['Navn']; ?></a></li>
<?php } ?>
<?php
  if ($AModul['URL'] == $this->uri->segment(1)) {
    foreach ($AModul['Meny'] as $Meny) {
      if (in_array($Meny['UAP'],$UABruker['UAP'])) {
?>
  <li class="<?php if ($Meny['URL'] == $this->uri->segment(2)) { echo "menyaktiv"; } else { echo "meny"; } ?>"><a href="<?php echo site_url($this->uri->segment(1).'/'.$Meny['URL']); ?>"><?php echo $Meny['Navn']; ?></a><?php if (isset($Meny['NyLink'])) { ?><span><a href="<?php echo site_url($this->uri->segment(1).'/'.$Meny['NyLink']); ?>"><img src="/grafikk/icons/add.png" /></a></span><?php } ?></li>
<?php
      }
    }
  }
?>
<?php } ?>
</ul>
</div>

<div id="ProfilDIV">
  <img src="<?php echo base_url(); ?>grafikk/icon-profile.png" /><a href="<?php echo site_url(); ?>/kontakter/person/<?php echo $UABruker['ID']; ?>"><div class="Data ProfilNavn"> <?php echo $UABruker['Fornavn']; ?></a></div>
  <div class="Data">Faggrupper:<br />
<?php
  foreach ($UABruker['Faggrupper'] as $Faggruppe) {
?>
<a href="<?php echo site_url(); ?>/kontakter/minfaggruppe/<?php echo $Faggruppe['FaggruppeID']; ?>"><?php echo $Faggruppe['Navn']; ?></a><br />
<?php
  }
?></div>
</div>
<script>
  $("#ProfilDIV").click(function () {
    $(".Data").toggle('slow');
    $(".Bruker").fadeTottle('');
  });
</script>

<!-- <?php print_r($UABruker); ?> -->
<!-- <?php print_r($AModuler); ?> -->
</body>
</html>
