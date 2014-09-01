<?php
/**
 * Enqueue Manager
 * 
 * The Enqueue Manager adds to the existing script and style enqueueing functionality
 * of WordPress to include specifying on which pages scrips and styles should
 * be added.
 * 
 * The Enqueue Manager uses WordPress's existing enqueue operations, and should
 * be used in place of them.
 * 
 * @package canned_fresh
 * @author  Patrick Jackson <pjackson@goldenpathsolutions.com>
 * @version 1.0.0
 * @created 2014-08-28
 * 
 */


/**
 * The Enqueue-Manaqer class is a static class through which users manipulate
 * their enqueued items @see Enqueue_Item.
 *
 * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
 * @version 1.0.0
 * @since   1.0.0
 */
class Enqueue_Manager {
    
    /**
     *
     * $items_to_enqueue is the array of Enqueue_Items being managed.
     * They are enqueued using the enqueue_items() function.
     * 
     * @var Array[Enque_Item]
     * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
     * @version 1.0.0
     * @since   1.0.0
     */
    private static $items_to_enqueue = array();
    
    /**
     * 
     * Adds an Enqueue_Item to the array of managed items.
     * You must subsequently call enqueue_items() to enqueue the added item.
     * 
     * @param Enqueue_Item $item
     * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
     * @version 1.0.0
     * @since   1.0.0
     */
    public static function add_item( Enqueue_Item $item ){
        
        if ( $item )
            array_push( self::$items_to_enqueue, $item );
        
    }
    
    /**
     *  Adds one or more Enqueue_Items listed in the $items array.
     *  Calls the add_item() function for each item in the array.
     * 
     * @param array $items
     * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
     * @version 1.0.0
     * @since   1.0.0
     */
    public static function add_items( Array $items ){
        
        if ( ! isEmpty($items)) {
            foreach ($items as $item) {
                self::add_item($item);
            }
        }
    }
    
    /**
     *  Performs the work of deciding whether to, and enqueueing,
     *  the <code>Enqueue_Items</code> in the <code>$items_to_enqueue</code> array.
     * 
     * @see enqueue_item()
     * 
     * @var Array[Enque_Item]
     * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
     * @version 1.0.0
     * @since   1.0.0
     */
    public static function enqueue_items(){
                
        foreach ( self::$items_to_enqueue as $item ){
            enqueue_item( $item );
        }
    }
    
    /**
     * 
     * Desides whether to enqueue given <code>Enqueue_Item</code>
     * 
     * 
     * @global type $post
     * @param Enqueue_Item $item
     * @return type
     * 
     * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
     * @version 1.0.0
     * @since   1.0.0
     */
    protected static function enqueue_item( Enqueue_Item $item ){
        
        global $post;
        
        $is_enqueue = false; //enqueue this item when true
            
        //if not adding to admin, and this is admin, then bail -- don't add
        if ( ! $item->get_add_to_admin && $post->is_admin() ){
            return;
        }

        //if not adding to front end, and this is front end, then bail
        if ( ! $item->get_add_to_front_end && $post->is_admin()){
            return;
        }

        //if no pages were specified, enqueue this item
        if ( isEmpty( $item->add_to_pages ) ){
            $is_enqueue = true;
        } else {

            //if pages were specified, only add this item if this is the right page
            foreach ( $item->add_to_pages as $page_slug ) {

                if ( $post->get_slugh() == $page_slug ){
                    $is_enqueue = true;
                    break;                  //we only need one match to enqueue
                }
            }
        }
        
        if ( $is_enqueue ){
            if ( get_class($item) == "Enqueue_Script_Item" ){
                enqueue_script( $item );
            }
            
            if( get_class($item) == "Enqueue_Style_Item" ){
                enqueue_style( $item );
            }
        }
    }
    
    protected function enqueue_script( Enqueue_Script_Item $item ){
        wp_enqueue_script( 
            $item->get_handle(),
            $item->get_src(),
            $item->get_deps(),
            $item->get_ver(),
            $item->get_in_footer() 
        );
    }
    
    protected function enqueue_style( Enqueue_Style_Item $item ){
        wp_enqueue_style( 
            $item->get_handle(),
            $item->get_src(),
            $item->get_deps(),
            $item->get_ver(),
            $item->get_media() 
        );
    }
}

