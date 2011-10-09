A copy of http://pommi.nethuis.nl/category/cgp/ to track my own changes/additions

service.php
Overview by service shows a graph for a service/plugin for all servers

dashboard.php
Shows a selection of graphs
Add something like this to your config file

    # dashboard
    $CONFIG['dashboard'] = array(
      'cols' => 3,
      'graphs' => array(
        array('p' => 'cpu', 'pi' => '_Total', 't' => 'cpu', 'h' => 'ATTIKS002', 's' => 3600),
        array('p' => 'cpu', 'pi' => '_Total', 't' => 'cpu', 'h' => 'ATTIKS003', 's' => 3600),
        array('p' => 'cpu', 'pi' => '_Total', 't' => 'cpu', 'h' => 'ATTIKS004', 's' => 3600),
        array('p' => 'load', 'pi' => '', 't' => 'load', 'h' => 'static.53.72.46.78.clients.your-server.de', 's' => 3600),
      ),
    );
