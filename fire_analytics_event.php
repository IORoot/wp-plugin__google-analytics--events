<?php

/*
Plugin Name: _ANDYP - Google Analytics - Fire events
Plugin URI: https://londonparkour.com
Description: Custom TeamBooking Google Analytics firing.
Version: 2.0.0
Author: Andy Pearson
Author URI: https://londonparkour.com
*/

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                     Class for analytics processing                      │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/src/send_analytics.php';

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                   The events that will fire a GA hit                    │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/events/fire_on_class_purchase.php';
require __DIR__.'/events/fire_on_coupon_usage.php';