<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',true);

define('BASEDIR', 	realpath(dirname(__FILE__).'/../'));
define('LIBDIR',  	BASEDIR . '/libs');

require LIBDIR.'/Mobile_Detect.php';
require LIBDIR.'/CallMe.php';

$options = array(
	'numbers' => array(
		'Denmark' => array(
			'cell' => '+4540574975'
		)
	),
	'skype' => 'jeppe.dyrby',
	'latitude' => '-658452172246743490',
);

