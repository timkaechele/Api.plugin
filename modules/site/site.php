<?php
/**
 * Kirby 2 API.plugin
 * @package Api Plugin
 * @author Bastian Allgeier Bastian@getkirby.com
 * @author Tim Kächele TimKaechele@me.com
 * @link http://github.com/timkaechele/Linky.plugin
 * @copyright Bastian Allgeier & Tim Kächele
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Kirby\Toolkit\Router\Route;
class SiteModule extends Module {

  public function routes() {
    route::get('api/site',       'site > site::show');
    route::get('api/site/stats', 'site > site::stats');
    route::get('api/site/index', 'site > site::index');
  }
  
  public function autoloader() {

    $autoloader = new autoloader();
    $autoloader->root = __DIR__ . DS . 'models';
    $autoloader->namespace = 'Kirby\\Api';
    $autoloader->start();

  }

}