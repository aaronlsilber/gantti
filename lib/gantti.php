<?php

require('calendar.php');

class Gantti {

	var $cal       = null;
	var $data      = array();
	var $first     = false;
	var $last      = false;
	var $options   = array();
	var $cellstyle = false;
	var $blocks    = array();
	var $months    = array();
	var $days      = array();
	var $seconds   = 0;

	function __construct($data, $params=array()) {

		$defaults = array(
      'title'      => false,
		  'sort_field' => 'first_name',
		  'sort_order' => 'SORT_DESC', // Use PHP sort flag constants
      'cellwidth'  => 50,
      'cellheight' => 40,
      'open_hour'	 => 6,
      'close_hour' => 18,
      'preHours' 	 => 2,
      'sufHours' 	 => 2,
      'today'      => true,
		);

		date_default_timezone_set('America/New_York'); // @TODO: set this timezone from DB

		$this->options = array_merge($defaults, $params);
		$this->cal     = new Calendar();
		$this->data    = $data;
		$this->seconds = 60*60;

		$this->cellstyle = 'style="width: ' . $this->options['cellwidth'] . 'px; height: ' . $this->options['cellheight'] . 'px"';

		// parse data and find first and last date
		$this->parse();
	}

	function parse() {

		// Sort data
		foreach ($this->data as $key => $row) {
			$sort_field[$key] = $row[ $this->options['sort_field'] ];
		}
		array_multisort($sort_field, constant($this->options['sort_order']), $this->data);
		// End sorting

		foreach($this->data as $d) {

			// Alter the format of the label by field
			switch ($this->options['sort_field']) {
				case 'first_name':
					$label = $d['first_name'] . ' ' . $d['last_name'];
					break;

				case 'last_name':
					$label = $d['last_name'] . ', ' . $d['first_name'];
					break;
				
				default:
					$label = $d[ $this->options['sort_field'] ];
					break;
			}

			$this->blocks[] = array(
        'label' 				=> $label,
        'tech_id'				=> $d['tech_id'],
        'type'    			=> $d['type'],
        'appt_id'				=> @$d['appt_id'],
        'customer_name' => @$d['customer_name'],
        'first_name'		=> $d['first_name'],
        'last_name'			=> $d['last_name'],
        'start' 				=> @$start = $d['start'],
        'end'   				=> @$end   = $d['end'],
        'class' 				=> @$d['class']
			);

		}

		// build the hours
		for ($i = $this->options['open_hour']; $i <= $this->options['close_hour']; $i++) { 
			$this->hours[] = $i;
		}

	}

	function getBlock($i, $block) {

		// Dont run if this block is a placeholder ('empty')
		if ( $block['type'] != 'empty' ) {

			$block_hrs_past = date('G', $block['start']) + (date('i', $block['start'])/60);
			$offset = $block_hrs_past - ($this->options['open_hour'] - $this->options['preHours']);
			$top    = round($i * ($this->options['cellheight'] + 1));
			$left   = round($offset * $this->options['cellwidth']);
			$width  = (($block['end'] - $block['start']) / 60 / 60) * $this->options['cellwidth']-1;

			if ( $block['type'] == 'break' ) {
				$height = round($this->options['cellheight']);
			} else {
				$height = round($this->options['cellheight']-8);
			}

			$class  = ($block['class']) ? ' ' . $block['class'] : '';
			$class .= ' ' . $block['type'];

			$style = '';

			switch ($block['type']) {
				case 'break':
					$label = 'Break';
					$style = 'line-height: ' . $this->options['cellheight'] . 'px;';
					break;

				case 'appointment':
					$label  = '<div class="field--times">';
					$label .= date('g:ia', $block['start']) . ' &rarr; ' . date('g:ia', $block['end']);
					$label .= '</div>';

					$label .= '<div class="field--customer">';
					$label .= $block['customer_name'];
					$label .= '</div>';
					break;
				
				default:
					$label = '';
					break;
			}

			$data_attr = array();
			$data_attr[] = 'data-apptid="' . $block['appt_id'] . '"';
			$data_attr = implode(' ', $data_attr);

			$output  = '<span ' . $data_attr . ' class="gantt-block' . $class . '" style="left: ' . $left . 'px; width: ' . $width . 'px; height: ' . $height . 'px">';
				if ($block['type'] == 'appointment')
				$output .= '<a href="/appointments/update_appointment/' . $block['appt_id'] . '">';

				$output .= '<strong class="gantt-block-label" style="' . $style . '">' . $label . '</strong>';

				if ($block['type'] == 'appointment')
				$output .= '</a>';
			$output .= '</span>';

			return $output;
		}
	}

	function getDays($wrapstyle, $cellstyle, $block) {
		$html = array();

		$html[] = '<ul class="gantt-hours">';
		for( $i = $this->options['open_hour'] - $this->options['preHours']; $i <= $this->options['close_hour'] + $this->options['sufHours']; $i++ ) {
			$closed = ($i < $this->options['open_hour'] || $i > $this->options['close_hour']) ? ' closed' : '';

			$appt_time = strtotime($i . ':00');

			$data_attr = array();
			// Creates a timestamp for this hour so our front-end understands this
			$data_attr[] = 'data-time="' . $appt_time . '"';
			$data_attr[] = 'data-techid="' . $block['tech_id'] . '"';
			$data_attr = implode(' ', $data_attr);

			$html[] = '<li ' . $data_attr . 'class="gantt-hour' . $closed . '" ' . $wrapstyle . '>';
			$html[] = '<a href="/create_appointment/' . $appt_time . '/' . $block['tech_id'] . '">';
			$html[] = '<span ' . $cellstyle . '>';
			$html[] = '+';
			$html[] = '</span>';
			$html[] = '</a>';
			$html[] = '</li>';
		}
		$html[] = '</ul>';

		return implode('', $html);
	}

	function render() {

		$html = array();

		// common styles
		$cellstyle  = 'style="line-height: ' . $this->options['cellheight'] . 'px; height: ' . $this->options['cellheight'] . 'px"';
		$wrapstyle  = 'style="width: ' . $this->options['cellwidth'] . 'px"';
		$totalstyle = 'style="width: ' . ((count($this->hours) + $this->options['preHours'] + $this->options['sufHours'])* $this->options['cellwidth']) . 'px"';
		
		// start the diagram
		$html[] = '<figure class="gantt">';

			// sidebar with labels
			$html[] = '<aside>';
				$html[] = '<ul class="gantt-labels" style="margin-top: ' . ($this->options['cellheight']*1) . 'px">';

					$firstTimeEnter = true;
					$rememberLastId;
					
					foreach($this->blocks as $i => $block) {

						if($firstTimeEnter)	{

							$html[] = '<li class="gantt-label"><strong ' . $cellstyle . '>' . $block['label'] . '</strong></li>';

							$firstTimeEnter = false;
							$rememberLastId = $block['label'];

						} else if ($rememberLastId != $block['label']) {

							$html[] = '<li class="gantt-label"><strong ' . $cellstyle . '>' . $block['label'] . '</strong></li>';

							$rememberLastId=$block['label'];
						}
					}

				$html[] = '</ul>';
			$html[] = '</aside>';


			// data section
			$html[] = '<section class="gantt-data">';

				// data header section
				$html[] = '<header>';
					// hour headers
					$html[] = '<ul class="gantt-hours" ' . $totalstyle . '>';

						for ($i = $this->options['open_hour'] - $this->options['preHours']; $i <= $this->options['close_hour'] + $this->options['sufHours']; $i++) {
							$closed = ($i < $this->options['open_hour'] || $i > $this->options['close_hour']) ? ' closed' : '';
							$hour = $i > 12 ? $i - 12 : $i;
							$html[] = '<li class="gantt-hour' . $closed . '" ' . $wrapstyle . '><span ' . $cellstyle . '>' . $hour . '</span></li>';
						}

					$html[] = '</ul>';
				// end header
				$html[] = '</header>';

				// main items
				$html[] = '<ul class="gantt-items" ' . $totalstyle . '>';

				$firstTimeEnter = true;
				$rememberLastId = "";

				foreach($this->blocks as $i => $block) {

					if( $firstTimeEnter == true ) {
							
						$html[] = '<li class="gantt-item">';
							$html[] = $this->getDays($wrapstyle, $cellstyle, $block); // days
							$html[] = $this->getBlock($i, $block); // event block
						$firstTimeEnter = false;
						$rememberLastId = $block['label'];

					} else if ( $rememberLastId != $block['label'] ){

						$html[] = '</li>';
						
						$html[] = '<li class="gantt-item">';
							$html[] = $this->getDays($wrapstyle, $cellstyle, $block); // days
							$html[] = $this->getBlock($i, $block); // event block
						$rememberLastId = $block['label'];

					} else if ( $rememberLastId == $block['label'] ){
						
						$html[] = $this->getBlock($i, $block); // the block 
						
					}

				}

				$html[] = '</ul>';

				if( $this -> options['today'] ) {

					// now
					$now = time();
					$now_hrs = intval( date('G', $now) );
					$now_min = intval( date('i', $now) );

					// hours past in the current day (float)
					// ex: 2:35pm would equal 14.5833
					$day_hrs_past = $now_hrs + $now_min / 60;

					$offset = $day_hrs_past - ($this->options['open_hour'] - $this->options['preHours']);
					$left   = round($offset * $this->options['cellwidth']);

				  $html[] = '<time style="top: ' . ($this->options['cellheight'] * 1) . 'px; left: ' . $left . 'px" datetime="' . date('G:i', $now) . '">Now</time>';

				}

			// end data section
			$html[] = '</section>';

		// end diagram
		$html[] = '</figure>';

		return implode('', $html);

	}


  function __toString() {
  	return $this->render();
  }
}
