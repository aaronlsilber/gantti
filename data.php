<?php

$data = array();
$test = array();

$data[] = array(
  'label' => 'Project 1',
  'id'    => '015264',
  'start' => '2013-06-20', 
  'end'   => '2013-06-26'
);

$data[] = array(
  'label' => 'Project 1',
  'id'    => '015268',
  'start' => '2013-04-22', 
  'end'   => '2013-05-22'
);

$test['152648'] = array(
  '0' => array(
    'appt_id' => '015268',
    'start'   => '2013-04-22', 
    'end'     => '2013-05-22'
  ),
  '1' => array(
    'appt_id' => '015268',
    'start'   => '2013-04-22', 
    'end'     => '2013-05-22'
  ),
);

dpm($test);

// $data[] = array(
//   'label' => 'Project 2',
//   'start' => '2012-04-18', 
//   'end'   => '2012-04-20'
// );

// $data[] = array(
//   'label' => 'Project 3',
//   'start' => '2012-05-25', 
//   'end'   => '2012-06-20'
// );

// $data[] = array(
//   'label' => 'Project 4',
//   'start' => '2012-05-06', 
//   'end'   => '2012-06-17',
//   'class' => 'important',
// );

// $data[] = array(
//   'label' => 'Project 5',
//   'start' => '2012-05-11', 
//   'end'   => '2012-06-03', 
//   'class' => 'urgent',
// );

// $data[] = array(
//   'label' => 'Project 6',
//   'start' => '2012-05-15', 
//   'end'   => '2012-07-03'
// );

// $data[] = array(
//   'label' => 'Project 7',
//   'start' => '2012-06-01', 
//   'end'   => '2012-07-03', 
//   'class' => 'important',
// );

// $data[] = array(
//   'label' => 'Project 8',
//   'start' => '2012-06-01', 
//   'end'   => '2012-08-05'
// );

// $data[] = array(
//   'label' => 'Project 9',
//   'start' => '2012-07-22', 
//   'end'   => '2012-09-05',
//   'class' => 'urgent',
// );

?>