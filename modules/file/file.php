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

use Kirby\Toolkit\Router\Route;
class FileModule extends Module {

  public function routes() {
    route::get('api/file/(:all)',           'file > file::show');
    route::post('api/file/create/(:all)',   'file > file::create');
    route::post('api/file/update/(:all)',   'file > file::update');
    route::put('api/file/update/(:all)',    'file > file::update');
    route::delete('api/file/delete/(:all)', 'file > file::delete');
  }
  
  public function autoloader() {
    $autoloader = new autoloader();
    $autoloader->root = __DIR__ . DS . 'models';
    $autoloader->namespace = 'Kirby\\Api';
    $autoloader->start();
  }

}