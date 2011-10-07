<?php

# global functions

function GET($index) {
	if (isset($_GET[$index]))
		return $_GET[$index];
	return null;
}

function validate_get($value, $type) {
	switch($type) {
		case 'host':
			if (!preg_match('/^[\d\w\W]+$/u', $value))
				return NULL;
		break;
		case 'plugin':
		case 'type':
			if (!preg_match('/^\w+$/u', $value))
				return NULL;
		break;
		case 'pinstance':
		case 'tinstance':
			if (!preg_match('/^[\d\w-]+$/u', $value))
				return NULL;
		break;
	}

	return $value;
}

function crc32hex($str) {
	return sprintf("%x",crc32($str));
}

function error_image() {
	header("Content-Type: image/png");
	readfile('layout/error.png');
	exit;
}

function get_all_hosts() {
  $h = array();

  # show all categorized hosts
  if (is_array($CONFIG['cat'])) {
    foreach ($CONFIG['cat'] as $cat => $hosts) {
      $h = array_merge($h, $hosts);
    }
  }
  # search for uncategorized hosts
  if ($chosts = collectd_hosts()) {
    $h = array_merge($chosts, $h);
  }

  return $h;
}
