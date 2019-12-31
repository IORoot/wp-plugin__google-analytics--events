<?php

//  ┌─────────────────────────────────────────────────────────────────────────┐ 
//  │                                                                         │░
//  │       Fire an event when a customer makes a purchase of a class.        │░
//  │                                                                         │░
//  └─────────────────────────────────────────────────────────────────────────┘░
//   ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░                                                                          
add_action('tbk_reservation_email_to_customer', 'analytics_goal_hit', 10, 2);

function analytics_goal_hit($email, $reservation){

        // IF Discount used, use price discount price.
        $price = $reservation->getPrice();

        // create now object
        $GA = new send_analytics();

        if($reservation->getDiscount()){

            $price = $reservation->getPriceDiscounted();

            // Send the 'coupon used' event.
            $GA->send_analytics_event(
                'coupon_used',
                $reservation->getServiceName(),
                $reservation->getCustomerDisplayName(),
                1
            );

        }

        // Send a 'class booking' event.
        $GA->send_analytics_event(
            'class_booking',
            $reservation->getServiceName(),
            $reservation->getCustomerDisplayName(),
            $price
        );

    return;
}