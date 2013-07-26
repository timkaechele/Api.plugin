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

namespace Kirby\Api;

use Kirby\Toolkit\C;
use Kirby\Toolkit\F;
use Kirby\Toolkit\Dir;
use Kirby\Toolkit\Str;
use Kirby\Toolkit\Model;
use Kirby\Toolkit\Error;
use Kirby\Toolkit\Txtstore;
use Kirby\Toolkit\Router\Route;


class Page extends Model {  

  public $page = null;

  public function __construct($page = null) {
    $this->page = $page;
    parent::__construct(array());
    if(!is_null($page) and $content = $page->content()) {
      foreach($content->data() as $key => $value) {
        $this->set($key, (string)$value);
      }
    }
  }
  /**
   * Checks if the page is new
   * @return boolean false
   */
  public function isNew() {
    return false;
  }
  /**
   * Updates a given page
   * @return mixed
   */
  protected function update() {
    /*if(!empty($this->data['template'])) {
      dump($this->page);
      //
      if(!f::move($this->page->content()->root(), $this->data['template'] . '.' . c::get('content.file.extension', 'txt'))) return error::raise('template', 'template could not be changed');
    }
    // check for an existing content file*/
    if(!$this->page->content()) return false;

    // get the full path to the content file
    $file = $this->page->content()->root();

    // create the text file
    return txtstore::write($file, $this->data);

  }
  /**
   * Deletes the Page folder
   * @return boolean
   */
  public function delete() {
    return dir::remove($this->page->root());
  }

  /**
   * finds a given page by URI
   * @param string $uri
   * @return mixed
   */
  static public function find($uri) {
    #dump($uri);
    $page = page($uri);
    
    #exit($page->uri());
    return ($page) ? new static($page) : null;
    //return (!$page or $page->uri() != $uri) ? null : new static($page);
  }
  /**
   * Creates given Page with given Params by URI
   * @param string $uri
   * @param array $params
   * @return mixed
   */
  static public function create($uri, $params = array()) {
    #if(page($uri)) return raise('The page already exists', 400);
    $validation = v($params, array(
      'num'     => array('numeric'),
      'content' => array('required')
    ));


    if($validation->failed()) return raise('You have to pass content', 400);

    // api/page/{docs/new-page}
    $path = str::split($uri, '/');
    $slug = str::slug(array_pop($path));

    // does the parent exist
    $parent = empty($path) ? site() : page(implode('/', $path));    

    // don't go on without a parent
    if(!$parent) return raise('parent', 400);

    // check for an existing page
    $exists = page($parent->uri() . '/' . $slug);

    // don't create a page twice
    if($exists and $exists->uri() == $parent->uri() . '/' . $slug) return raise('The page already exists', 400);

    // define some defaults
    $defaults = array(
      'num'      => null,
      'template' => $slug
    );

    // final options to work with
    $options = array_merge($defaults, $params);

    // make sure there's a valid template
    if(empty($options['template'])) $options['template'] = $slug;

    // create a clean directory name
    $dir  = (!empty($options['num'])) ? $options['num'] . '-' . $slug : $slug;
    $file = $options['template'] . '.' . c::get('content.file.extension', 'txt');
    $root = $parent->root() . DS . $dir;

    // make sure the directory has been created
    if(!dir::make($root)) return raise('The directory could not be created', 500);

    // create the text file
    if(!txtstore::write($root . DS . $file, (array)$options['content'])) return raise('The content could not be saved', 500);

    // build the uri for the new page
    $uri = ($parent->isSite()) ? $slug : $parent->uri() . '/' . $slug;

    // get a fresh site object
    $site = site(c::get());
    $page = $site->children()->find($uri);

    return (!$page) ? raise('The page could not be created', 500) : new static($page);

  }
  /**
   * Returns an array with childrens
   * @return array
   */
  protected function children() {

    $children = array();

    foreach($this->page->children() as $child) {
      $children[] = array(
        'uri'   => $child->uri(),
        'title' => (string)$child->title() 
      );      
    }
    return $children;
  }

  /**
   * Returns an array with all Files
   * @return array
   */
  protected function files() {
    $files = array();
    foreach($this->page->files()->filterBy('extension', '!=', c::get('content.file.extension', 'txt')) as $file) {
      $files[] = array(
        'uri' => $this->page->uri().'/'.urlencode($file->filename()),
        'url' => $file->url(),
        );
    }
    return $files;
  }
  /**
   * Returns an array with parsed page data
   * @return array
   */
  protected function kirbytext() {
    $kirbytext = array();
    foreach($this->data as $k => $d) {
      $kirbytext[$k] = kirbytext($d);
    }
    return $kirbytext;
  }
  /**
   * Returns an array with all Page Informations
   * @return array
   */
  public function toArray() {
    return array(
      'id'       => $this->page->id(),
      'num'      => $this->page->num(),
      'uid'      => $this->page->uid(),
      'uri'      => $this->page->uri(),
      'url'      => $this->page->url(),
      'tinyurl'  => $this->page->tinyurl(),
      'children' => $this->children(),
      'template' => $this->page->template(),
      'content'  => array(
        'raw'       => $this->data,
        'html' => $this->kirbytext(),
      ),
      'files'    => $this->files(),
    );    
  }
}