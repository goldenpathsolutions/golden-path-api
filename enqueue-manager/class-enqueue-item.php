<?php
/**
 * 
 * This is the base class for all Enqueue Items
 * 
 * @category golden_path_API
 * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
 * @version 1.0.0
 * @since   1.0.0
 * 
 */


/**
 * Here are some handy named constants to make using this class cleaner
 */
//$in_admin
define('IN_ADMIN', true);
define('NOT_IN_ADMIN', false);

//$in_front_end
define('IN_FRONT_END', true);
define('NOT_IN_FRONT_END', false);


/**
 * 
 * Enqueue Item
 * 
 * This class holds the data used to enqueue scripts and stylesheets.
 * It is used by the Enqueue Manager to manage enqueueing them.
 * One Equeue Item is used to manage a single script or stylesheet.
 * 
 * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
 * @version 1.0.0
 * @since   1.0.0
 */
abstract class Enqueue_Item {
   
   /**
    * Indicates whether this item should be added to admin pages.
    * 
    * If false it will stop the function from trying to enqueue this item on 
    * any admin page.
    * 
    *   - true  = item may be added to admin pages
    *   - false = item will not be added to admin pages
    * 
    * @link http://codex.wordpress.org/Function_Reference/is_admin 
    * 
    * 
    * @var boolean 
    * @access private
    * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
    * @version 1.0.0
    * @since 1.0.0
    */
   private $in_admin;
   
   /**
    *
    * @var boolean 
    */
   private $in_front_end;
   private $page_criteria;
   private $handle;
   private $src;
   private $deps;
   private $ver;
   
   /**
    * 
    * Create an instance of an Enqueue_Item, setting all given parameters
    * 
    * @param WP_Post $post
    * @param  $in_admin
    * @param  $in_front_end
    * @param array $page_criteria
    * @param  $handle
    * @param  $src
    * @param array $deps
    * @param  $ver
    * 
    * @access public
    * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
    * @version 1.0.0
    * @since 1.0.0
    */
   function __construct( $in_admin, $in_front_end, 
           array $page_criteria, $handle, $src, array $deps, 
           $ver){

       $this->in_admin = $in_admin;
       $this->in_front_end = $in_front_end;
       $this->page_criteria = $page_criteria;
       $this->handle = $handle;
       $this->src = $src;
       $this->deps = $deps;
       $this->ver = $ver;

   }
   
   public abstract function enqueue();
   
   public function get_item_type() {
       return $this->item_type;
   }

   public function in_admin() {
       return $this->in_admin;
   }

   public function in_front_end() {
       return $this->in_front_end;
   }

   public function get_page_criteria() {
       return $this->page_criteria;
   }

   public function get_handle() {
       return $this->handle;
   }

   public function get_src() {
       return $this->src;
   }

   public function get_deps() {
       return $this->deps;
   }

   public function get_ver() {
       return $this->ver;
   }
   
   public function set_in_admin( $in_admin ) {
       $this->in_admin = $in_admin;
       return $this;
   }

   public function set_in_front_end( $in_front_end ) {
       $this->in_front_end = $in_front_end;
       return $this;
   }

   public function set_page_criteria( $page_criteria ) {
       $this->page_criteria = $page_criteria;
       return $this;
   }

   public function set_handle( $handle ) {
       $this->handle = $handle;
       return $this;
   }

   public function set_src($src) {
       $this->src = $src;
       return $this;
   }

   public function set_deps($deps) {
       $this->deps = $deps;
       return $this;
   }

   public function set_ver($ver) {
       $this->ver = $ver;
       return $this;
   }
}