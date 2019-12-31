<?php

//  ┌─────────────────────────────────────────────────────────────────────────┐ 
//  │                                                                         │░
//  │       Fire an event when a customer makes a purchase of a class.        │░
//  │                                                                         │░
//  └─────────────────────────────────────────────────────────────────────────┘░
//   ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░                                                                          
add_action('tbk_reservation_email_to_customer', 'analytics_goal_hit_coupon_used', 10, 2);

function analytics_goal_hit_coupon_used($email, $reservation){

    // Check If there is a discount coupon being used first.
    if($reservation->getDiscount()){

        // create new object
        $GA = new send_analytics();

        /**
         * Fire an analytics event
         * 
         * Category = 'coupon used'
         * Action = 'Beginner Class'
         * Label = 'A Person'
         * Value = 1
         */
        $GA->send_analytics_event(
            'coupon used',
            $reservation->getServiceName(),
            $reservation->getCustomerDisplayName(),
            1
        );

    }

    return;
}