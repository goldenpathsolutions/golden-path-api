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
class Enqueue_Item {
   
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
   private $add_to_admin;
   private $add_to_front_end;
   private $add_to_pages;
   private $handle;
   private $src;
   private $deps;
   private $ver;
   
   /**
    * 
    * Create an instance of an Enqueue_Item, setting all given parameters
    * 
    * @param boolean $add_to_admin
    * @param boolean $add_to_front_end
    * @param array $add_to_pages
    * @param string $handle
    * @param string $src
    * @param string $deps
    * @param string $ver
    * 
    * @access public
    * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
    * @version 1.0.0
    * @since 1.0.0
    */
   function __construct(boolean $add_to_admin, boolean $add_to_front_end, 
           array $add_to_pages, string $handle, string $src, string $deps, 
           string $ver){

       $this->add_to_admin = $add_to_admin;
       $this->add_to_front_end = $add_to_front_end;
       $this->add_to_pages = $add_to_pages;
       $this->handle = $handle;
       $this->src = $src;
       $this->deps = $deps;
       $this->ver = $ver;

   }
   
   public function get_item_type() {
       return $this->item_type;
   }

   public function get_add_to_admin() {
       return $this->add_to_admin;
   }

   public function get_add_to_front_end() {
       return $this->add_to_front_end;
   }

   public function get_add_to_pages() {
       return $this->add_to_pages;
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
   
   public function set_add_to_admin(Boolean $add_to_admin) {
       $this->add_to_admin = $add_to_admin;
       return $this;
   }

   public function set_add_to_front_end($add_to_front_end) {
       $this->add_to_front_end = $add_to_front_end;
       return $this;
   }

   public function set_add_to_pages($add_to_pages) {
       $this->add_to_pages = $add_to_pages;
       return $this;
   }

   public function set_handle($handle) {
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