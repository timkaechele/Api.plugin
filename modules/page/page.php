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
class PageModule extends Module {
  
  public function routes() {
    route::get('api/page/(:all)',           'page > page::show');
    route::post('api/page/create/(:all)',   'page > page::create');
    route::post('api/page/update/(:all)',   'page > page::update');
    route::put('api/page/update/(:all)',    'page > page::update');
    route::delete('api/page/delete/(:all)', 'page > page::delete');
  }
  
  public function autoloader() {
    $autoloader = new autoloader();
    $autoloader->root = __DIR__ . DS . 'models';
    $autoloader->namespace = 'Kirby\\Api';
    $autoloader->start();
  }

}