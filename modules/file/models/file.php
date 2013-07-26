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
use Kirby\Toolkit\Upload;

class File extends Model {  

  public $file = null;

  public function __construct($file = null) {

    $this->file = $file;

    parent::__construct(array());

    if(!is_null($file) and $meta = $file->meta()) {
      
      foreach($meta->data() as $key => $value) {
        $this->set($key, (string)$value);
      }

    }

  }
  /**
   * Checks if page is new
   * @return boolean
   */
  public function isNew() {
    return false;
  }

  /**
   * Parses the raw Data to HTML
   * @return string HTML
   */
  protected function kirbytext() {
    $kirbytext = array();
    foreach ($this->data as $k => $d) {
      $kirbytext[$k] = kirbytext($d);
    }
    return $kirbytext;
  }

  /**
   * Returns an Array with all File Informations
   * @return mixed
   */
  public function toArray() {

    return array(
      'url'         => $this->file->url(),
      'name'        => $this->file->name(),
      'filename'    => $this->file->filename(),
      'mime'        => $this->file->mime(),
      'extension'   => $this->file->extension(),
      'size'        => $this->file->size(),
      'nicesize'    => $this->file->niceSize(),
      'type'        => $this->file->type(),
      'meta' => array(
        'raw'       => $this->data,
        'html' => $this->kirbytext(),
        ),
      );
  }

  
  /**
   * Deletes a File object
   * @return mixed
   */
  public function delete() {
    // Remove File
    if(!f::remove($this->file->root())) return raise('file could not be deleted', 500);
    // if existent remove Meta Informations File 
    if($this->file->meta()->root()) {
      if(!f::remove($this->file->root())) return raise('meta file could not be deleted', 500);
    }
  }
  /**
   * @param string $uri
   * @param array $data
   */
  static public function create($uri, $data) {
    $parsed = self::parse($uri);

    $parent = page($parsed['parent']);
    // Check if Page exists
    if(!$parent) return raise('The given Page is not existent', 400);
    // Return Error if File already exists
    if(f::exists($parent->root(). DS .$parsed['file'])) return raise('file exists', 'a file with this name already exists.');

    // Upload File
    $upload = new Upload('file', $parent->root() . DS . $parsed['file']);

    // Return Error if Upload Failed
    if($upload->failed()) return raise($upload->error()->message(), 400);
    
    // Write Data only if meta array is set
    if(!empty($data['meta'])) {
      if(!Txtstore::write($upload->file() . '.' . c::get('content.file.extension', 'txt'), $data['meta'])) return raise('meta', 'not written');
    }

    return true;
  }
  /**
   * Updates a given file 
   * @return mixed
   */
  protected function update() {
    $parent = $this->file->page();
    if(empty($_FILES['file'])) return raise('you have to pass a file', 400);  
    $upload = new Upload('file', $parent->root(). DS . $this->file->filename());
    if($upload->failed()) return raise($upload->error()->message, 400);
    $metaFile = $this->file->root() . '.' . c::get('content.file.extension', 'txt');
    if(!Txtstore::write($metaFile, $this->data)) return raise('meta file could not be created', 400);
    return true;
  }
  /**
   * Finds a specific file by URI
   * @param  string $uri
   * @return mixed
   */
  static public function find($uri) {
    $page = self::parse($uri);
    $parent = page($page['parent']);
    if(!$parent) return raise('file-not-found', 400);
    $file = $parent->files()->find($page['file']);
    return ($page['file']) ? new static($file) : null;
  }

  /**
   * Parses the URI and gives the Parent and file name back
   * @param string uri
   * @return array
   */
  protected static function parse($uri) {
    $parent = explode('/', $uri);
    $file   = array_pop($parent);
    $parent = implode('/', $parent);
    return array(
      'parent'  => $parent,
      'file'    => $file
      );
  }  
}

 
