<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>::ML Default Index::</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="https://bootswatch.com/cyborg/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
      html,
      body {
        height: 100%;
      }
      .mr05{margin-right: .5em;}
      .navbar-default {
          background-color: #222222;
      }
      .navbar-brand {
          float: left;
          padding: 15px 15px;
          font-size: 18px;
          line-height: 20px;
          height: 50px;
      }
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        margin: 0 auto -60px;
        padding: 0 0 60px;
      }
      #footer {
        height: 60px;
        background-color: #222222;
      }

      #wrap > .container {
        padding: 60px 15px 0;
      }
      .container .credit {
        margin: 20px 0;
      }
      #footer > .container {
        padding-left: 15px;
        padding-right: 15px;
      }
      canvas{
        width: 100%;
        height: auto;
      }
      code {
        font-size: 80%;
      }
      .panel{
        margin-top: 10em;
      }
    </style>
  </head>
  <body>
<!-- Wrap all page content here -->
<div id="wrap">

  <!-- Fixed navbar -->
  <div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><i class="mr05 glyphicon glyphicon-console"></i><?php echo gethostname(); ?></a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">Home</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">VM Services <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <?php
              $host = $_SERVER['HTTP_HOST'];
              preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
              $url = $matches[0];
              ?>
              <li><a href="http://adminer.<?php echo $url ?>">Adminer</a></li>
              <li><a href="http://dashboard.<?php echo $url ?>">VM Dashboard</a></li>
              <li><a href="http://mail.<?php echo $url ?>">MailCatcher</a></li>
              <li class="divider"></li>
              <li class="dropdown-header">Development</li>
              <li><a href="http://shopware.<?php echo $url ?>">Shopware Frontend</a></li>
              <li><a href="http://shopware.<?php echo $url ?>/backend">Shopware Backend</a></li>
            </ul>
          </li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>

  <!-- Begin page content -->
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="panel-title">ML Default Indexpage</h2>
      </div>
      <div class="panel-body">
        <p class="lead">This is the default index Page for <a href="http://<?php echo $host; ?>"><?php echo $host; ?></a>.</p>
        <p>Remove it and start Coding.</p>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="panel-title">PHP Info</h2>
      </div>
      <div class="panel-body">
        <?php phpinfo(); ?>
      </div>
    </div>
  </div>
</div>

<div id="footer">
  <div class="container">
    <p class="text-muted credit text-center">&copy; <?php echo date("Y") ?> <a href="http://mono-labs.de">mono-labs | S&ouml;ren Oehding</a>.</p>
  </div>
</div>

  <!-- script references -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trianglify/0.4.0/trianglify.min.js"></script>
    <script>
      var pattern = Trianglify({
          width: window.innerWidth,
          height: window.innerHeight,
          cell_size: 40
      });
      // document.body.appendChild(pattern.canvas())
      canvas = pattern.canvas();
      $('body').css({'background-image':"url(" + canvas.toDataURL("image/png")+ ")" });
  </script>
  </body>
</html>