<?php


//include dependent file
include_once( 'class-enqueue-item.php' );

/**
 * Here are some handy named constants to make using this class cleaner
 */
//$in_footer
define('IN_FOOTER', true);
define('NOT_IN_FOOTER', false);


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
    * @param  $in_admin
    * @param  $in_front_end
    * @param array $page_criteria
    * @param  $handle
    * @param  $src
    * @param array $deps
    * @param  $ver
    * @param  $in_footer
    * 
    * @access public
    * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
    * @version 1.0.0
    * @since 1.0.0
    */
   function __construct($in_admin, $in_front_end, 
           array $page_criteria, $handle, $src, array $deps, 
           $ver, $in_footer){

       parent::__construct($in_admin, $in_front_end, $page_criteria, 
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
    
    public function enqueue_scripts_action(){
        wp_enqueue_script( 
            $this->get_handle(),
            $this->get_src(),
            $this->get_deps(),
            $this->get_ver(),
            $this->get_in_footer() 
        );
    }

    public function enqueue() {
        add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts_action') );
    }

}
