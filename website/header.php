<!DOCTYPE html> <?php include_once('functions.php'); ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>proML - <?php echo(getPageName()); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/custom.css" rel="stylesheet">
    <link href="/css/datatables.css" rel="stylesheet">

  </head>

  <body data-spy="scroll" data-target="#navbar-sidebar">

    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/index.php"><img src="/images/logo-w-s.png" /></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="/index.php">Home</a></li>
            <li><a href="/run_job.php">Run Job</a></li>
            <li><a href="/results.php">Results</a></li>
            <li><a href="/our_study.php">proML Research</a></li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="help">Help <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="help">
                <li><a href="/help.php#about">About</a></li>
                <li><a href="/help.php#references">References</a></li>
                <li class="divider"></li>
                <li><a href="/help.php#interpret">Interpret Status Codes</a></li>

              </ul>
            </li>
          </ul>

        </div>
      </div>
    </nav>