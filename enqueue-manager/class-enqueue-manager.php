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

//include dependent files
include_once 'class-enqueue-script-item.php';
include_once 'class-enqueue-style-item.php';


/**
 * The Enqueue-Manaqer class is a static class through which users manipulate
 * their enqueued items v@see Enqueue_Item.
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
            self::enqueue_item( $item );
        }
    }
    
    /**
     * 
     * Desides whether to enqueue given <code>Enqueue_Item</code>
     * 
     * 
     * @global WP_Post $post
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
        if ( $post && $post->is_admin() && ! $item->in_admin()  ){
            return;
        }

        //if not adding to front end, and this is front end, then bail
        if ( $post && $post->is_font_end() && ! $item->in_front_end() ){
            return;
        }

        /*
         * If criteria were specified, test to see if we should enqueue.
         * If no criteria were specified, then we are not limited and should 
         * enqueue.
         */
        if ( !empty( $item->page_criteria ) ){
            $is_enqueue = self::test_page_criteria( $item->page_criteria );
            
        } else {
            $is_enqueue = true;         
        }
        
        if ( $is_enqueue ){
            $item->enqueue();
        }
    }
    
    private static function test_page_criteria( array $page_criteria ){
        
        //if pages were specified, only add this item if this is the right page
        foreach ( $page_criteria as $page_criterion ) {

            $is_enqueue = self::test_page_criterion( $page_criterion );

            if ( $is_enqueue ){
                break;          //it only takes one success to add the item
            }
        }   
    }
    
    private static function test_page_criterion( $page_criterion ){
        
        global $post;
                
        //handle case where $criteria is a page slug
        if ( $post && ( $post->get_slug() == $page_criterion ) ){
            return true;
        }

        /*
         * case where $criteria is a function used to discern a special
         * type of page such as is_search().
         */
        if ( is_callable( $page_criterion ) && __call( $page_criterion ) ){
            return true;
        }
        
        return false;
    }
}

