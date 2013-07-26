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

use Kirby\Api\File;
use Kirby\Toolkit\Response;
use Kirby\Toolkit\f;
class FileController extends Controller {
  
  /**
   * Shows a File by URI
   * @param string $uri
   * @return JSON
   */
  public function show($uri) {
    $file = $this->file($uri);
    return response::json($file->toArray());
  }

  /**
   * Creates a File by URI
   * @param string $uri
   * @return JSON
   */
  public function create($uri) {
    $file = file::create($uri, get());
    return response::success('The file has been created');
  }
  /**
   * Updates a File by URI
   * @param string $uri
   * @return JSON
   */
  public function update($uri) {
    $file = File::find($uri);
    if(!$file) raise('The file is not existent.');
    $file->reset(get('meta'));
    if($file->save()) {
      return response::success('file successfully updated');
    } else {
      return raise('an error occured', 500, $file->errors());
    }
  }

  /**
   * Deletes a File by URI
   * @param string $uri
   * @return JSON
   */
  public function delete($uri) {
    $file = $this->file($uri);
    if(!$file->delete()) return raise('File could not be deleted', 400);
    return response::success('successfully deleted');
  }

  /**
   * Checks if File exists 
   * @param string $uri
   * @return mixed
   */
  protected function file($uri) {
    $file = file::find($uri);
    if(!$file) return raise('The file could not be found', 400);
    return $file;
  }
}