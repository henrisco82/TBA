<?php
  // Load Config 
  require_once 'config/config.php';

// // Autoload Core Libraries Like
// require_once 'libraries/core.php';
//   require_once 'libraries/controller.php';
//   require_once 'libraries/database.php';

// Session Helpers
require_once 'helper/session_helper.php';

// URL Helpers
require_once 'helper/url_helper.php';

// php spreadsheet
require_once 'libraries/vendor/autoload.php';

// jpgraph library 
require_once ('libraries/jpgraph/jpgraph.php');
require_once ('libraries/jpgraph/jpgraph_line.php');
require_once ('libraries/jpgraph/jpgraph_bar.php');


  
  spl_autoload_register(function($className){
      if($className != "ReadFileData")
         require_once 'libraries/' . $className . '.php';
  });
  

