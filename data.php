<?php

$data = array();

// Load Breaks

  $data[] = array(
    'first_name' => 'Aaron',
    'last_name' => 'Silber',
    'type'    => 'break',
    'tech_id' => '156489156',
    'start'   => 1370966400,
    'end'     => 1370970000
  );

  $data[] = array(
    'first_name' => 'Brent',
    'last_name' => 'Bobberson',
    'type'    => 'break',
    'tech_id' => '256489156',
    'start'   => 1370966400-(60*60*2.5),
    'end'     => 1370970000-(60*60*2)
  );

// Add Empty

  // @TODO: Add empty rows
  $data[] = array(
    'first_name' => 'Brent',
    'last_name' => 'Bobberson',
    'type'    => 'empty',
    'tech_id' => '256489156',
  );

  $data[] = array(
    'first_name' => 'Sarah',
    'last_name' => 'Richards',
    'type'    => 'empty',
    'tech_id' => '156489181',
  );

  $data[] = array(
    'first_name' => 'Jason',
    'last_name' => 'Xavier',
    'type'    => 'empty',
    'tech_id' => '156489636',
  );

// Load Appointments

  $data[] = array(
    'first_name' => 'Sean',
    'last_name' => 'Schoolcraft',
    'type'    => 'appointment',
    'tech_id' => '123987654',
    'appt_id' => '81',
    'customer_name' => 'Barbara Jackson',
    'start'   => 1370949300,
    'end'     => 1370949300+(60*60*.5)
  );

  $data[] = array(
    'first_name' => 'Sean',
    'last_name' => 'Schoolcraft',
    'type'    => 'appointment',
    'tech_id' => '123987654',
    'appt_id' => '3',
    'customer_name' => 'Rupert Murdok',
    'start'   => time()-(60*60*5),
    'end'     => time()-(60*60*4)
  );

  $data[] = array(
    'first_name' => 'Aaron',
    'last_name' => 'Silber',
    'type'    => 'appointment',
    'tech_id' => '156489156',
    'appt_id' => '104',
    'customer_name' => 'Orange Banana',
    'start'   => time()-(60*60*3),
    'end'     => time()-(60*60*1.5)
  );

  $data[] = array(
    'first_name' => 'Sean',
    'last_name' => 'Schoolcraft',
    'type'    => 'appointment',
    'tech_id' => '123987654',
    'appt_id' => '4052',
    'customer_name' => 'Brandon Marlow',
    'start'   => time()-(60*60*7.5),
    'end'     => time()-(60*60*6)
  );

  $data[] = array(
    'first_name' => 'John',
    'last_name' => 'Bonny',
    'type'    => 'appointment',
    'tech_id' => '123987644',
    'appt_id' => '4052',
    'customer_name' => 'Shane Woodsburry',
    'start'   => time()-(60*60*7),
    'end'     => time()-(60*60*6.0)
  );

?>