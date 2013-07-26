<?php
/**
 * Kirby 2 API.plugin
 * @package Linky Plugin
 * @author Bastian Allgeier Bastian@getkirby.com
 * @author Tim Kächele TimKaechele@me.com
 * @link http://github.com/timkaechele/Linky.plugin
 * @copyright Bastian Allgeier & Tim Kächele
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Kirby\Api;

use Kirby\Toolkit\C;
use Kirby\Toolkit\Model;

class Site extends Model {  

  public $site = null;
  
  /**
   * 
   */
  public function __construct($data = array()) {

    $this->site = site();        

    parent::__construct(array());
      
    foreach($this->site->content()->data() as $key => $value) {
      $this->set($key, (string)$value);
    }

  }
  
  /** 
   * Returns an Array with Children
   * @return array 
   */
  protected function children() {

    $children = array();
    foreach($this->site->children() as $child) {
      $children[] = array(
        'num'   => $child->num(),
        'uid'   => $child->uid(),
        'uri'   => $child->uri(),
        'title' => (string)$child->title() 
      );      
    }
    return $children;
  }

  /**
   * Returns all files in an array
   * @return array
   */
  protected function files() {
    $files = array();
    foreach($this->site->files()->filterBy('extension', '!=', c::get('content.file.extension', 'txt')) as $file) {
      $files[] = array(
        'url' => $file->url(),
        'name' => urlencode($file->filename()),
        'type' => $file->type(),
        );
    }
    return $files;
  }
  
  /**
   * 
   */
  protected function kirbytext() {
    $kirbytext = array();
    foreach($this->data as $k => $d) {
      $kirbytext[$k] = kirbytext($d);
    }
    return $kirbytext;
  }
  
  /**
   * Generates an array with Site.txt Informations
   * @return array 
   */
  public function toArray() {
    return array(
      'url'      => $this->site->url(),
      'pages'    => $this->children(),
      'content'  => array(
        'raw'       => $this->data,
        'html' => $this->kirbytext(),
      ),
      'files'    => $this->files(),
    );    
  }
  /**
   * Generates an array with statistical Informations
   * @return array 
   */
  public function stats() {
    $index = $this->site->pages()->index();
    $stats = array(
      'pages' => array(
        'total'     => count($index),
        'visible'   => 0, 
        'invisible' => 0
      ),
      'files' => array(
        'total'     => 0,
        'images'    => 0,
        'videos'    => 0,
        'sounds'    => 0,
        'documents' => 0,
        'others'    => 0,
      )
    );
    foreach($index as $p) {
      if($p->isVisible()) {
        $stats['pages']['visible']++;
      } else {
        $stats['pages']['invisible']++;
      }
      $stats['files']['total']     += $p->files()->filterBy('extension', '!=', 'txt')->count();
      $stats['files']['images']    += $p->images()->count();
      $stats['files']['videos']    += $p->videos()->count();
      $stats['files']['sounds']    += $p->sounds()->count();
      $stats['files']['documents'] += $p->documents()->count();
      $stats['files']['others']    += $p->others()->count();
    }
    return $stats;
  }

  /**
   * Generates an Index of all Pages
   * @return array 
   */
  public function index() {
    $index = array();
    foreach($this->site->pages()->index() as $page) {
      $index[] = array(
        'url'     => $page->url(),
        'uid'     => $page->uid(),
        'uri'     => $page->uri(),
        'tinyurl' => $page->tinyurl(),
        );
    }
    return $index;
  }
}