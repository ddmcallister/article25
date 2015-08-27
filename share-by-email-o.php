<?php
/*fail sent email loaded from header reloaded page*/
/*
Plugin Name: Email Share Form
Plugin URI: https://github.com/ddmcallister/article25
Description: Allows users to edit and send email from form
Version: 1.0
Author: Destanie McAllister
Author URI: https://github.com/ddmcallister/article25
*/

function html_form_code() {
        echo '<form id="0tb-email" action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
        echo '<fieldset>';
        echo '<h3 class="ztbcampaigns-h3">';
        echo 'Enter Your Information:</h3>';
        echo '<div class="col">';
        echo '<input class="ztbcampaigns-inputs" type="email" name="from-email" placeholder="Email Address" value="' . ( isset( $_POST["from-email"] ) ? esc_attr( $_POST["from-email"] ) : '' ) . '" size="40" />';
        echo '<input class="ztbcampaigns-inputs" type="text" name="from-name" placeholder="Your Name" pattern="[a-zA-Z0-9]+" value="' . ( isset( $_POST["from-name"] ) ? esc_attr( $_POST["from-name"] ) : '' ) . '" size="40" />';
        echo '</fieldset>';
        echo '<fieldset>';
        echo '<h3 class="ztbcampaigns-h3">';
        echo 'Choose Your Recipients and Write Your Email:</h3>';
        echo '<input class="ztbcampaigns-inputs" type="text" name="recips" pattern="^([^@]+@[^.]+(\.[^.]+))+(\s?[,]\s?|$)+$" placeholder="Enter email addresses here separated by commas" value="' . ( isset( $_POST["recips"] ) ? esc_attr( $_POST["recips"] ) : '' ) . '" size="40" />';
        echo '<textarea class="email-txt" rows="10" cols="35" name="mssg">Dear Friends,

More than 3 lakh (300,000) people die every year in India from tuberculosis because of improper diagnosis, prevention and treatment. There are more than 2 million TB cases in India every year—largely concentrated in India’s most populous cities.

However, it is possible to end deaths from TB. Comprehensive TB programs have been implemented all over the world—from major metropolitan cities like Lima in Peru to the most difficult-to-reach rural villages of Siberia in Russia. These programs have succeeded in significantly reducing deaths from TB.

While TB programs in India have taken some steps to curbing the epidemic they still have many gaps. Please help India take steps to change this by signing this petition calling on Indian leaders to implement comprehensive programs to end TB deaths: bit.ly/ztbpetition

Email signature… (E.g. “Sincerely, John”)' . ( isset( $_POST["mssg"] ) ? esc_attr( $_POST["mssg"] ) : '' ) . '</textarea>';
        echo '</fieldset>';
        echo '<div><input class="ztbcampaigns-btn" id="email-btn" type="submit" name="form-submitted" value="Send an Email"></div>';
        echo '</form>';
}


function deliver_mail() {
    // if the submit button is clicked, send the email
    if ( isset( $_POST['form-submitted'] ) ) {
        $message = esc_textarea( $_POST["mssg"] );
        $to = sanitize_text_field( $_POST["recips"] );
        $subject = 'end TB deaths in India';
        $headers = 'From: ' . sanitize_text_field( $_POST["from-name"] ) . ' <' . sanitize_email( $_POST["from-email"] ) . '>' . "\r\n";
        $headers .= 'Location: http://zerotbdeaths.org/pledge-email-petition-thank-you/' . "\r\n";

        // If email has been process for sending, redirect
        /*if ( wp_mail( $to, $subject, $message, $headers) ) {
            
        } else {
            echo '<p class="post-submit">An error occurred. Make sure you have used commas to separate multiple email addresses.</p>';
        }*/
    }
    wp_mail( $to, $subject, $message, $headers);
}
 
function dm_shortcode() {
    ob_start();
    deliver_mail();
    html_form_code();
 
    return ob_get_clean();
}
 
add_shortcode( 'sitepoint_contact_form', 'dm_shortcode' );
 
?>