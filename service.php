<?php

  error_reporting(E_ALL & ~E_NOTICE);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  
require_once 'conf/common.inc.php';
require_once 'inc/html.inc.php';
require_once 'inc/collectd.inc.php';

$host = validate_get(GET('h'), 'host');
$splugin = validate_get(GET('p'), 'plugin');

html_start();

print hosts_navigation();

$services = array();
$hosts = get_all_hosts();
foreach ($hosts as $h) {
  $plugins = collectd_plugins($h);
  foreach ($plugins as $plugin) {
    $services[$plugin][] = $h;
  }
}

// Top navigation for services
print '<ul class="services">';
foreach ($services as $service => $hs) {
  print '<li><a href="service.php?p=' . $service . '">' . $service . '</a></li>';
}
print '</ul>';

if ($splugin && array_key_exists($splugin, $services)) {
  print '<table><tr valign="top">';
  foreach ($services[$splugin] as $h) {
    print '<td>';
		print '<h2>' . $h . '</h2>';
		print graphs_from_plugin($h, $splugin);
    print '</td>';
  }
  print '</tr></table>';
}
else {
  print '<ul>';
  foreach ($services as $service => $hs) {
    print '<li><a href="service.php?p=' . $service . '">' . $service . '</a></li>';
  }
  print '</ul>';
}

html_end();

?>
