<?php  if ( ! defined('OP_DIR')) exit('No direct script access allowed');
$config['name'] = __('Template Style 2 - Flat Border', OP_SN);
$config['screenshot'] = 'styles/ms-2b.jpg';
$config['screenshot_thumbnail'] = 'styles/ms-2b.jpg';
$config['description'] = __('This fixed width template is perfect for pages using a header image', OP_SN);
$config['header_width'] = 1060;

$config['header_layout'] = array(
	'menu-positions' => array(
		'alongside' => array(
			'title' => __('Logo With Alongside Navigation', OP_SN),
			'preview' => array(
				'image' => OP_IMG.'previews/navpos_alongside.png',
				'width' => 477,
				'height' => 67
			),
			'link_color' => true,
			'link_selector' => '.banner .nav > li > a',
			'dropdown_selector' => '.banner .nav a',
		),
		'below' => array(
			'title' => __('Banner/Header with navigation below', OP_SN),
			'preview' => array(
				'image' => OP_IMG.'previews/navpos_below.png',
				'width' => 477,
				'height' => 89
			),
		)
	)
);