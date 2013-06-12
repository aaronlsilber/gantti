<?php

require('krumo/class.krumo.php');
require('lib/gantti.php'); 
require('data.php'); 

date_default_timezone_set('UTC');
setlocale(LC_ALL, 'en_US');

$gantti = new Gantti($data, array(
  'title'      => date('n/d/Y'),
  'sort_field' => 'first_name',
  'sort_order' => 'SORT_ASC',
  'cellwidth'  => 100,
  'cellheight' => 60,
  'open_hour'  => 6,
  'close_hour' => 18,
  'preHours'   => 1,
  'sufHours'   => 1,
  'today'      => true
));

?>

<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>Mahatma Gantti</title>
  <meta charset="utf-8" />

  <link rel="stylesheet" href="styles/css/screen.css" />
  <link rel="stylesheet" href="styles/css/gantti.css" />

  <!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

</head>

<body>

<?php echo $gantti ?>

</body>

</html>
