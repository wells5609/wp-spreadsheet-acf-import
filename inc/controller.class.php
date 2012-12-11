<?php

// The MIT License
// 
// Copyright (c) 2012 +THECHURCH+
// 
// Permission is hereby granted, free of charge, to any person obtaining a
// copy of this software and associated documentation files
// (the "Software"), to deal in the Software without restriction,
// including without limitation the rights to use, copy, modify, merge,
// publish, distribute, sublicense, and/or sell copies of the Software, and
// to permit persons to whom the Software is furnished to do so, subject to
// the following conditions:
// 
// The above copyright notice and this permission notice shall be included
// in all copies or substantial portions of the Software.
// 
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
// OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
// MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
// IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
// CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
// TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
// SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

require_once CSVAFPLUGINPATH . '/inc/model.class.php';
require_once CSVAFPLUGINPATH . '/inc/view.class.php';

require_once CSVAFPLUGINPATH . '/inc/PHPExcel/IOFactory.php';

// noncekey
if (!defined('CSVAFNONCEKEY')) {
  define('CSVAFNONCEKEY', '_csvafnonce');
}

/**
 * Constroller for the CSV Advanced Fields plugin.
 * 
 * @package Csvaf
 * @version 0.1
 */
class CsvafController {
  /**
   * Handle the incoming request.
   * 
   * @static
   * @access public
   * @return void
   */
  public static function Handle () {
    // Permissions
    if (!current_user_can('manage_options')) {
      return wp_die(
        __('You do not have sufficient permissions to access this page.')
      );
    }

    // Check state.
    // If we have a valid nonce then render out the next step.
    if (  is_string($_POST[CSVAFNONCEKEY])
       && wp_verify_nonce($_POST[CSVAFNONCEKEY], CSVAFNONCEKEY)
       ) {
      return self::Handleupload();
    }

    self::Uploadform();
  }

  /**
   * Render the upload form
   * 
   * @param string $action The form action.
   * @static
   * @access public
   * @return void
   */
  protected static function Uploadform ($action = '') {
    if ('' != $action) {
      $action = $_SERVER['REQUEST_URI'] . '&step=' . $action;
    }

    // nonce stuff
    $noncevalue = wp_create_nonce(CSVAFNONCEKEY);

    echo CsvafView::Uploadform($action, CSVAFNONCEKEY, $noncevalue);
  }

  protected static function Handleupload () {
    if (!is_array($_FILES['csvaf_data'])) {
      return self::Uploadform();
    }

    // We have a file.
    // Lets give it to phpexcel to handle.
    $tmpname    = $_FILES['csvaf_data']['tmp_name'];
    $filename   = $tmpname . $_FILES['csvaf_data']['name'];
    move_uploaded_file($tmpname, $filename);

    $doc        = PHPExcel_IOFactory::load($filename);
    unlink($filename);

    $doc_array  = $doc->getActiveSheet()->toArray(null, true, true, true);
    var_dump($doc_array);
  }

  /**
   * Show our entry in the admin menu.
   * 
   * @static
   * @access public
   * @return void
   */
  public static function Adminmenu () {
    add_menu_page(
      'CSV Advanced Fields'
    , 'Upload CSV'
    , 'import'
    , 'upload-csv'
    , array('CsvafController', 'Handle')
    );
  }
}
