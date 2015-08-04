<?php
  include "ameny.php";
?>
<!DOCTYPE html>
<html lang="no">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <title>ADMIS Bømlo RKH</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/css/admis.css" rel="stylesheet" />
  </head>
  <body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">ADMIS</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
<?php foreach ($AModuler as $AModul) { ?>
<?php if (in_array($AModul['UAP'],$UABruker['UAP'])) { ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $AModul['Navn']; ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
<?php
      foreach ($AModul['Meny'] as $Meny) {
        if (in_array($Meny['UAP'],$UABruker['UAP'])) {
?>
                <li><?php echo anchor('/'.$AModul['URL'].'/'.$Meny['URL'],$Meny['Navn']); ?></li>
<?php
        }
      }
?>
              </ul>
            </li>
<?php } ?>
<?php } ?>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php if ($this->session->flashdata('Infomelding')) { ?>
          <div class="alert alert-info" role="alert"><?php echo $this->session->flashdata('Infomelding'); ?></div>
<?php } ?>
        <?php echo $contents; ?>
        </div>
      </div>
    </div>

  </body>
</html>
