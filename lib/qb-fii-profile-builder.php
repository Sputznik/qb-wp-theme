<?php

class FII_PROFILE_BUILDER extends FII_BASE {

  function __construct(){
    add_filter( 'get_post_metadata', array( $this, 'wppbc_custom_restrict_all_posts' ), 10, 3 );
  }

  function wppbc_custom_restrict_all_posts( $value, $object_id, $meta_key ){
    if( get_post_type( $object_id ) !== 'post' ){
      return $value;
    }

    // SKIP IF IN ADMIN AREA (optional - allows admins to edit without issues)
    if( is_admin() ){
      return $value;
    }

    // INJECT USER STATUS RESTRICTION(Require logged-in users)
    if( $meta_key === 'wppb-content-restrict-user-status' ){
      return 'loggedin';
    }
    return $value;

  }

}

FII_PROFILE_BUILDER::getInstance();