<?php

/*
Plugin Name: _ANDYP - Team Booking - Google Analytics Firing
Plugin URI: https://londonparkour.com
Description: Custom TeamBooking Google Analytics firing.
Version: 2.0.0
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


//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                  ACF Admin Page for Options & Settings                  │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/admin/acf_admin_page.php';

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                     Class for analytics processing                      │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/src/send_analytics.php';

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                   The events that will fire a GA hit                    │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/src/fire_on_class_purchase.php';