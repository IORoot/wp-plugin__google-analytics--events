<?php

/*
Plugin Name: _ANDYP - Team Booking - Google Analytics Firing
Plugin URI: https://londonparkour.com
Description: Custom TeamBooking Google Analytics firing.
Version: 1.0.0
Author: Andy Pearson
Author URI: https://londonparkour.com
*/

/*
 * Uses the TBK_RESERVATION_EMAIL_TO_CUSTOMER Action provided by Team Booking
 * to fire an event on google analytics.
 *
 * Uses the send_analytics_event function (see themes/londonparkour.com/functions/send_analytics_code.php)
 * to send the event.
 */

/*
 * Send Analytics Event.
 */
function send_analytics_event($category = 'unassigned', $action = 'unassigned', $label = 'unassigned', $value = 1){

    $data = array(
        'v' => 1,                           // VERSION
        'tid' => 'UA-116670575-1',          // URCHIN
        'cid' => gen_uuid(),                // RANDOM
        't' => 'event'                      // EVENT
    );

    $data['ec'] = $category;
    $data['ea'] = $action;
    $data['el'] = $label;
    $data['ev'] = $value;
    $data['uip']= $_SERVER['REMOTE_ADDR'];
    $data['ua']=  $_SERVER['HTTP_USER_AGENT'];

    $url = 'https://www.google-analytics.com/collect';
    $content = http_build_query($data);
    $content = utf8_encode($content);

    $ch = curl_init();
    curl_setopt($ch,CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-type: application/x-www-form-urlencoded'));
    curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
    curl_setopt($ch,CURLOPT_POST, TRUE);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $content);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);

    return;
}


/*
 * Generate a random string.
*/
function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}


add_action('tbk_reservation_email_to_customer', 'analytics_goal_hit', 10, 2);

function analytics_goal_hit($email, $reservation){

    // IF Discount used, use price discount price.
        $price = $reservation->getPrice();
        if($reservation->getDiscount()){
            $price = $reservation->getPriceDiscounted();

            // Send the 'coupon used' event.
            send_analytics_event(
                'coupon used',
                $reservation->getServiceName(),
                $reservation->getCustomerDisplayName(),
                1
            );

        }

    // Send a 'class booking' event.
        send_analytics_event(
            'class booking',
            $reservation->getServiceName(),
            $reservation->getCustomerDisplayName(),
            $price
        );

    return;
}