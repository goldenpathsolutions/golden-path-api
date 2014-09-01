<?php

class Enqueue_Style_Item extends Enqueue_Item {
    
   /**
    * String specifying the media for which this stylesheet has been defined. 
    * Examples: 'all', 'screen', 'handheld', 'print'. See this list for the full 
    * range of valid CSS-media-types.
    * 
    * Default: 'all' 
    * 
    * @url http://codex.wordpress.org/Function_Reference/wp_enqueue_style
    * 
    * @var String
    * @access private
    * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
    * @version 1.0.0
    * @since 1.0.0
    */
   private $media;
   
   /**
    * 
    * Create an instance of an Enqueue_Style_Item, setting given values
    * 
    * @url http://codex.wordpress.org/Function_Reference/wp_enqueue_style
    * 
    * @param Boolean $add_to_admin
    * @param Boolean $add_to_front_end
    * @param array $add_to_pages
    * @param String $handle
    * @param String $src
    * @param array $deps
    * @param String $ver
    * @param String $media
    * 
    * @access public
    * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
    * @version 1.0.0
    * @since 1.0.0
    */
   function __construct(Boolean $add_to_admin, Boolean $add_to_front_end, 
           Array $add_to_pages, String $handle, String $src, Array $deps, 
           String $ver, String $media){

       parent::__construct($add_to_admin, $add_to_front_end, $add_to_pages, 
               $handle, $src, $deps, $ver);
       
       $this->media = $media;
   }
   
   public function get_media() {
       return $this->media;
   }

   public function set_media( $media ) {
       $this->media = $media;
       return $this;
   }
}

