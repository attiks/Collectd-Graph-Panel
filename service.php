<?php

  error_reporting(E_ALL & ~E_NOTICE);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  
require_once 'conf/common.inc.php';
require_once 'inc/html.inc.php';
require_once 'inc/collectd.inc.php';

$host = validate_get(GET('h'), 'host');
$splugin = validate_get(GET('p'), 'plugin');
$subplugin = validate_get(GET('s'), 'plugin');

html_start();

$services = array();
$hosts = get_all_hosts();
foreach ($hosts as $h) {
  $plugins = collectd_plugins($h);
  foreach ($plugins as $plugin) {
    $plugindata = collectd_plugindata($h, $plugin);
    $plugindata = group_plugindata($plugindata);
    $services[$plugin]['#hosts'][] = $h;
    foreach($plugindata as $pd) {
      if ($pd['t'] != $plugin) {
        $services[$plugin][$pd['t']][md5($h)] = $h;
      }
    }
  }
}

print '<div class="services"><ul class="services">';
foreach ($services as $service => $hs) {
  if (substr($service, 0, 1) != '#') {
    print '<li><a href="service.php?p=' . $service . '">' . $service . '</a><ul>';
    foreach ($hs as $k => $s) {
      if (substr($k, 0, 1) != '#') {
        print '<li><a href="service.php?p=' . $service . '&amp;s=' . $k . '">' . $k . '</a></li>';
      }
    }
    print '</ul></li>';
  }
}
print '</ul></div>';

if ($splugin && array_key_exists($splugin, $services)) {
  print '<table><tr valign="top">';
  foreach ($services[$splugin]['#hosts'] as $h) {
    print '<td>';
		print '<h2>' . $h . '</h2>';
    if (isset($subplugin)) {
      global $CONFIG;

      $plugindata = collectd_plugindata($h, $splugin);
      $plugindata = group_plugindata($plugindata);

      foreach ($plugindata as $items) {
        if ($items['t'] == $subplugin) {
          $items['h'] = $h;

          $time = array_key_exists($plugin, $CONFIG['time_range'])
            ? $CONFIG['time_range'][$plugin]
            : $CONFIG['time_range']['default'];

          printf('<a href="%s"><img src="%s"></a>'."\n",
            build_url('detail.php', $items, $time),
            build_url('graph.php', $items, $time)
          );
        }
      }
    }
    else {
      print graphs_from_plugin($h, $splugin);
    }
    print '</td>';
  }
  print '</tr></table>';
}

html_end();

?>
