<?php
/**
 * Kirby 2 API.plugin
 * @package Api Plugin
 * @author Bastian Allgeier Bastian@getkirby.com
 * @author Tim Kächele TimKaechele@me.com
 * @link http://github.com/timkaechele/Api.plugin
 * @copyright Bastian Allgeier & Tim Kächele
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

// only run this plugin on subpath "api"
if(site()->uri()->path()->first() != 'api') return;

// load the app framework
require(__DIR__ . DS . 'vendors' . DS . 'app' . DS . 'bootstrap.php');

// remove all previous registered routes
router::reset();

// install all available modules
app::modules(__DIR__ . DS . 'modules');

// register an error event
event::on('kirby.app.error', function($error) {    
  $response = response::error($error->getMessage(), $error->getCode());
  $response->header();
  echo $response;
}, $overwrite = true);

app::run();
exit;