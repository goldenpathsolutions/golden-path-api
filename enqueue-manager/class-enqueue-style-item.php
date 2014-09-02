<?php

//include dependent file
include_once( 'class-enqueue-item.php' );

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
     * @param  $in_admin
     * @param  $in_front_end
     * @param array $page_criteria
     * @param  $handle
     * @param  $src
     * @param array $deps
     * @param  $ver
     * @param  $media
     *
     * @access public
     * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
     * @version 1.0.0
     * @since 1.0.0
     */
    function __construct( $in_admin,  $in_front_end, 
            array $page_criteria, $handle, $src, array $deps, 
            $ver, $media){

        parent::__construct($in_admin, $in_front_end, $page_criteria, 
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
    
    public function my_enqueue(){
        wp_enqueue_style( 
            $this->get_handle(),
            $this->get_src(),
            $this->get_deps(),
            $this->get_ver(),
            $this->get_media() 
        );
    }

    public function enqueue() {
        add_action( 'wp_enqueue_styles', array( &$this, 'my_enqueue') );
    }

}

