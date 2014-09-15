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
 * @version 1.1.0
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
        
        if ( $item ) {
            array_push( self::$items_to_enqueue, $item );
        }
        
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
     * @global WP_Post $post
     * @param Enqueue_Item $item
     * @return boolean. False if item was not enqueued
     * 
     * @author Patrick Jackson <pjackson@goldenpathsolutions.com>
     * @version 1.1.0
     * @since   1.1.0
     */
    protected static function enqueue_item( Enqueue_Item $item ){
                                    
        /*
         * If this is admin, and we don't want to admin, then bail.
         * If this is is front end (not admin), and we don't want to add to
         * front end, then bail.
         */
        if ( is_admin() ){
            if ( ! $item->in_admin() ){ // & don't add to admin
                return false;
            }
        } else { // this is front end...
            if ( ! $item->in_front_end() ){ // & don't add to front end
                return false;
            }
        }

        /*
         * If criteria were specified, test to see if we should enqueue.
         * If no criteria were specified, then we are not limited and should 
         * enqueue.
         */
        $criteria = $item->get_page_criteria();
        if ( ! empty( $criteria ) ){
            if ( ! self::test_page_criteria( $criteria ) ){
                return false;
            }
        }
        
        // enqueue the item
        $item->enqueue();
    }
    
    /**
     * Loop through criteria. If any are met, return true, otherwise false
     * 
     * @param array $page_criteria
     * @return boolean
     * 
     * @version 1.0.1
     * @since 1.1.0
     */
    private static function test_page_criteria( array $page_criteria ){
        foreach ( $page_criteria as $page_criterion ) {
            if ( self::test_page_criterion( $page_criterion ) ){
                return true;
            }
        }  
        return false;
    }
    
    /**
     * 
     * Run through the tests for the given criterion
     * 
     * @access private
     * @global WP_Post $post
     * @param type $page_criterion
     * @return boolean True if tests pass, otherwise false
     * 
     * @version 1.1.0
     * @since 1.1.0
     */
    private static function test_page_criterion( $page_criterion ){
        
        global $post;
                
        /*
         * Test for, and handle case where page has a parent (ancestors) indicated 
         * in the slug. Bails if there's a parent but it doesn't match this page, 
         * otherwise continues testing
         */
        $last_slash = strrpos( $page_criterion, '/' );
        if ( $last_slash !== false ) {  // if ancestor indicated in criterion...
            // if ancestors fail to match the given list... 
            $ancestor_string = substr( $page_criterion, 0, $last_slash );
            if ( ! self::test_post_ancestors( $ancestor_string ) ){ 
                return false;
            }
        }
                        
        /*
         * Handle case where $post is any kind of post (page, post, custom), 
         * returns true when criterion is slug of $post
         */
        $slug = substr( $page_criterion, ($last_slash + 1), strlen( $page_criterion ) );
        if ( $post && self::get_the_slug( $post->ID ) === $slug ){
            return true;
        }

        /*
         * case where $criteria is a function used to discern a special
         * type of page such as is_search().
         */
        if ( is_callable( $page_criterion ) && call_user_func( $page_criterion ) ){
            return true;
        }
        
        return false;
    }
    
    /**
     * Tests whether the ancestors indicated by $ancestor_slug are $local_post's
     * ancestors.  All must be in order.
     * 
     * String is assumed to consist of ancestor slugs separated by forward slashes.
     * Example: <great-grandparent-slug>/<grandprent-slug>/<parent-slug>
     * 
     * @global WP_Post $post
     * @param string $ancestors_slug
     * @return boolean true if all ancestors represented in slug are the ancestors
     *          of $local_post
     */
    private static function test_post_ancestors( $ancestors_slug = '' ){
        global $post;
        
        /*
         * Shouldn't happen, but if there are no ancestors indicated, then
         * assume an ancestor search is not a criterion and therefore passes
         */
        if ( empty( $ancestors_slug ) ){
            return true;
        }
        
        /*
         * get list of ancestor slugs.  If more than one, order them from parent 
         * to oldest.  If only 
         */
        $ancestor_slugs = strrpos( $ancestors_slug, '/' ) !== false ? 
                array_reverse( explode( '/', $ancestors_slug ) ) :
                array ( $ancestors_slug );
        $ancestor_ids = get_post_ancestors( $post );
        $idx = 0; // keep track of which ancestor we're on. 0 = parent
        
        foreach ( $ancestor_ids as $ancestor_id ){
            // fail as soon as we find a slug that doesn't match its ancestor
            if ( self::get_the_slug( $ancestor_id ) !== $ancestor_slugs[ $idx++ ] ){
                return false;
            }
        }
        
        return true; // ...if all ancestors match
    }
    
    /**
     * 
     * Get the slug for the post with given id.
     * 
     * @global WP_Post $post
     * @param int $id
     * @return string The slug for given post id
     */
    private static function get_the_slug( $id=null ){
        if( empty($id) ){
            global $post;
            if( empty($post) ){
                return ''; // No global $post var available.
            }
            $id = $post->ID;
        }

        $slug = basename( get_permalink($id) );
        return $slug;
    }
}

