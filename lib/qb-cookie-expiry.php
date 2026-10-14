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