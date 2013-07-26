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
use Kirby\Api\Page;
use Kirby\Toolkit\Response;

use Kirby\Api\Site;

class SiteController extends Controller {
  /**
   * Shows the Informations stored in site.txt
   * @return array JSON
   */
  public function show() {  
    $site = new Site();
    return response::json($site->toArray());
  }

  /**
   * Shows general stats about the page
   * @return array JSON
   */
  public function stats() {
    $site = new Site();
    return response::json($site->stats());
  }
  /**
   * Shows an array with all Sites
   * @return array JSON
   */
  public function index() {
    $site = new Site();
    return response::json($site->index());
  }
}