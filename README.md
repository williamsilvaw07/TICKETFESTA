
# Shortcodes Documentation

## Overview
This document provides a list of shortcodes available in your WordPress theme and a brief description of each.

## Shortcodes

### [todays_sales]
Displays today's sales for the current user.

### [todays_tickets_sold]
Shows the number of tickets sold today by the current user.

### [valid_tickets_sold]
Displays the total valid tickets sold by the current user over all time.

### [revenue]
Shows the total revenue generated by the current user from ticket sales over all time.

### [user_organizers]
Shows all organizers with delect snd edit options

### [event_vanues]
Shows all vanues 


### [recent_activity]
Shows recent activity related to the current user's events, including sales and tickets sold.

### [my_events_shortcode]
 Retrieves events for the current logged-in user.

###  [tribe_community_events view="my_events"]
 Retrieves events for the current logged-in user.

### [dynamic_edit_event]
 Create the edit event form 

 
[organiser_image_gallery]



### [custom_image_gallery]
 orginserzer upload images fucntion and current images 


### [bank_details_form]
 form for user to add the bank details 


### [custom_registration_form]
 user sign up from and event orginserrs 



### [event_submission_response]

To use the [event_submission_response] shortcode, simply place it on the page you've designated for post-submission messages (e.g., event-submission-received). Make sure that the redirection URL after event submission includes the event_id query parameter to ensure the shortcode functions correctly.


### to change tax information (site fee)
edit these three functions
--> functions.php add_extra_fees_for_products()
--> custom-function-frontend.js get_tribe_ticket_fee()
--> admin-order.js get_tribe_ticket_fee()




### Check before any plugin update 
Veune function to allow to add the same veune name 
https://ticketfesta.co.uk/wp-admin/plugin-editor.php?file=the-events-calendar%2Fsrc%2FTribe%2FVenue.php&plugin=the-events-calendar%2Fthe-events-calendar.php
