<?php

  error_reporting(E_ALL & ~E_NOTICE);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  
require_once 'conf/common.inc.php';
require_once 'inc/html.inc.php';
require_once 'inc/collectd.inc.php';

html_start();

print '<div class="dashboard cols-' . $CONFIG['dashboard']['cols'] . '">';
  foreach ($CONFIG['dashboard']['graphs'] as $plugin) {
    print '<div class="dashboard-graph">';
      printf('<h2><a href="%s">%s</a></h2>'."\n", $CONFIG['weburl'].'/host.php?h='.htmlentities($plugin['h']), $plugin['h']);
      printf('<a href="%s">'."\n", build_url('detail.php', $plugin));
        printf('<img src="%s">'."\n", build_url('graph.php', $plugin));
      print '</a>';
    print '</div>';
  }
print '</div>';

html_end();

?>
