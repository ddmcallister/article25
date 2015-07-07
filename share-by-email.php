<?php
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
        echo '<h3 class="email-h3">';
        echo 'Enter Your Information:</h3>';
        echo '<div class="col">';
        echo '<input class="email-inputs" type="email" name="from-email" placeholder="Email Address" value="' . ( isset( $_POST["from-email"] ) ? esc_attr( $_POST["from-email"] ) : '' ) . '" size="40" />';
        echo '<input class="email-inputs" type="text" name="from-name" placeholder="Email signature… (E.g. “Sincerely, John”)" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["from-name"] ) ? esc_attr( $_POST["from-name"] ) : '' ) . '" size="40" />';
        echo '</fieldset>';
        echo '<fieldset>';
        echo '<h3 class="email-h3">';
        echo 'Choose Your Recipients and Write Your Email:</h3>';
        echo '<input class="email-inputs" type="text" name="recips" pattern="^([^@]+@[^.]+(\.[^.]+))+(\s?[,]\s?|$)+$" placeholder="Enter email addresses here separated by commas" value="' . ( isset( $_POST["recips"] ) ? esc_attr( $_POST["recips"] ) : '' ) . '" size="40" />';
        echo '<textarea class="email-txt" rows="10" cols="35" name="mssg">' . ( isset( $_POST["mssg"] ) ? esc_attr( $_POST["mssg"] ) : '' ) . '</textarea>';
        echo '</fieldset>';
        echo '<div><input id="email-btn" type="submit" name="form-submitted" value="Send an Email"></div>';
        echo '</form>';
}


function deliver_mail() {
    // if the submit button is clicked, send the email
    if ( isset( $_POST['form-submitted'] ) ) {
        $message = esc_textarea( $_POST["mssg"] );
        $to = sanitize_text_field( $_POST["recips"] );
        $subject = "test email";
        $headers = 'From: ' . sanitize_text_field( $_POST["from-name"] ) . ' <' . sanitize_email( $_POST["from-email"] ) . '>' . "\r\n";


        // If email has been process for sending, display a success message
        if ( wp_mail( $to, $subject, $message, $headers) ) {
            echo '<div>';
            echo '<p>Thanks for contacting me, expect a response soon.</p>';
            echo '</div>';
        } else {
            echo 'An unexpected error occurred';
        }
    }
}
 
function dm_shortcode() {
    ob_start();
    deliver_mail();
    html_form_code();
 
    return ob_get_clean();
}
 
add_shortcode( 'sitepoint_contact_form', 'dm_shortcode' );
 
?>