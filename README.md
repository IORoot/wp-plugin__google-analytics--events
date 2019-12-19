# wp-plugin__teambooking--GA
Teambooking wordpress plugin customisation to fire a Google Analytics event.

## How it works
Simply fires a CURL request to googleanalytics.com with the correct data on a particular wordpress event.

In this example, we fire it based on the 'tbk_reservation_email_to_customer' action from teambooking. So whenever anyone purchases a class, we see it appear in google analytics.
