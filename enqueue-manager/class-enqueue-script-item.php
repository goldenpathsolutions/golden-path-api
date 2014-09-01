<?php
class Enqueue_Script_Item extends Enqueue_Item {
    
   /**
    *  Stores whether or not to enqueue this item in the footer.
    *  If true, item is enqueued in footer, otherwise false.
    * 
    *  Allowed Values:  true or false
    * 
    * @var boolean
    * @access private
    * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
    * @version 1.0.0
    * @since 1.0.0
    */
   private $in_footer;
   
   /**
    * 
    * Create an instance of an Enqueue_Script_Item
    * 
    * @param type $add_to_admin
    * @param type $add_to_front_end
    * @param type $add_to_pages
    * @param type $handle
    * @param type $src
    * @param type $deps
    * @param type $ver
    * @param type $in_footer
    * 
    * @access public
    * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
    * @version 1.0.0
    * @since 1.0.0
    */
   function __construct(boolean $add_to_admin, boolean $add_to_front_end, 
           array $add_to_pages, string $handle, string $src, array $deps, 
           string $ver, boolean $in_footer){

       parent::__construct($add_to_admin, $add_to_front_end, $add_to_pages, 
               $handle, $src, $deps, $ver);
       
       $this->in_footer = $in_footer;
   }
   
   public function get_in_footer() {
       return $this->in_footer;
   }

   public function set_in_footer($in_footer) {
       $this->in_footer = $in_footer;
       return $this;
   }
}
