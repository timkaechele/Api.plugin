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

class PageController extends Controller {
  /**
   * Shows a given page by URI
   * @param string $uri
   * @return array JSON
   */ 
  public function show($uri) {
    $page = $this->page($uri);
    return response::json($page->toArray());
  }
  /**
   * Creates a given page by URI
   * @param string $uri
   * @return array JSON
   */
  public function create($uri) {
    $page = page::create($uri, get());
    return response::success('The page has been created', $page->toArray());
  }
  /**
   * Updates a given page by URI
   * @param string $uri
   * @return array JSON
   */
  public function update($uri) {
    $page = $this->page($uri);    
    $page->reset(get('content'));
    if($page->save()) {
      return response::success('page successfully updated', $this->page($uri)->toArray());  
    } else {
      return raise('Page could not be saved', 500);
    }
  }
  /**
   * Deletes a given page by URI
   * @param string $uri
   * @return array JSON
   */
  public function delete($uri) {
    $page = $this->page($uri);
    if(!$page->delete()) return response::error();
    return response::success('successfully deleted');
  }
  /**
   * Creates a Page Object
   * @param string $uri
   * @return mixed
   */
  protected function page($uri) {
    $page = page::find($uri);
    if(!$page) return raise('The Page could not be found.', 400);
    return $page;
  }
}