<?php
add_filter( 'auth_cookie_expiration', 'qrb_subscriber_auth_cookie_expiration', 10, 3 );

function qrb_subscriber_auth_cookie_expiration( $expiration, $user_id, $remember ) {
    $user = get_userdata( $user_id );

    if ( ! $user ) {
        return $expiration;
    }

    if ( in_array( 'subscriber', (array) $user->roles, true ) ) {
        return 30 * DAY_IN_SECONDS;
    }

    return $expiration;
}


function qrb_persist_subscriber_cookies( $cookie, $expire, $expiration, $user_id, $scheme ) {
    $user = get_userdata( $user_id );
    
    if ( ! $user || ! in_array( 'subscriber', (array) $user->roles, true ) ) {
        return;
    }

    if ( 0 === $expire ) {
        $forced_expiry = time() + ( 30 * DAY_IN_SECONDS );
        
        $cookie_names = array(
            'logged_in'  => LOGGED_IN_COOKIE,
            'secure_auth' => SECURE_AUTH_COOKIE,
        );

        $cookie_name = $cookie_names[ $scheme ] ?? AUTH_COOKIE;

        setcookie( $cookie_name, $cookie, $forced_expiry, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );
        
        if ( COOKIEPATH != SITECOOKIEPATH ) {
            setcookie( $cookie_name, $cookie, $forced_expiry, SITECOOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );
        }
    }
}

add_action( 'set_auth_cookie', 'qrb_persist_subscriber_cookies', 10, 5 );
add_action( 'set_logged_in_cookie', 'qrb_persist_subscriber_cookies', 10, 5 );