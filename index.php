<?php

require('krumo/class.krumo.php');
require('lib/gantti.php'); 
require('data.php'); 

date_default_timezone_set('UTC');
setlocale(LC_ALL, 'en_US');

$gantti = new Gantti($data, array(
  'title'      => 'Demo',
  'cellwidth'  => 40,
  'cellheight' => 50,
  'today'      => true
));

$gantti2 = new Gantti($test, array(
  'title'      => 'Demo',
  'cellwidth'  => 40,
  'cellheight' => 50,
  'today'      => true
));


function dpm($code) {
  krumo($code);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>Mahatma Gantti – A simple PHP Gantt Class</title>
  <meta charset="utf-8" />

  <link rel="stylesheet" href="styles/css/screen.css" />
  <link rel="stylesheet" href="styles/css/gantti.css" />

  <!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

</head>

<body>

<header>

<h1>Mahatma Gantti</h1>
<h2>A simple PHP Gantt Class</h2>

</header>

<?php echo $gantti ?>

</body>

</html>
