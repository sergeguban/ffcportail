<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class FieldErrorHelper extends Helper {
    
   var $helpers = array("Html");
    
   public function display($row,$field){
      if (isset($row['error']) && isset($row['error']["$field"])){
         $display = '<td class="error-message">' . $row["$field"]  .  '</td>';
      }  else {
         $display = '<td>' . $row["$field"] . '</td>';
      }

      return $display;
   }
    
 
    
   public function checkField($userRow){
      if ( isset($userRow['error'])){
         return  '<td>' .  $this->Html->image('test-fail-icon.png', array('alt' => 'record pas valide !')) . '</td>' ;
      } else {
         return  '<td>' .  $this->Html->image('test-pass-icon.png', array('alt' => 'record pas valide !')) . '</td>' ;
      }

   }
    
}
