<?php
/**
 * Plugin Name: Multistep Form
 * Description: Create a multistep form in WordPress.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access to this file
}

// Function to display the form step
function render_form_step($step) {
    switch ($step) {
        case 1:
            render_step_one();
            break;
        case 2:
            render_step_two();
            break;
        case 3:
            render_step_three();
            break;
        default:
            render_step_one();
            break;
    }
}

$required = array('login', 'password', 'confirm', 'name', 'phone', 'email');


// Function to render the first step of the form
function render_step_one() {
    if (isset($_POST['step']) && $_POST['step'] == 1) {
        // Process and validate data from step one
        $fname = sanitize_text_field($_POST['fname']);
        $error = false;
        foreach($required as $field) {
          if (empty($_POST[$field])) {
            $error = true;
          }
        }

        if ($error) {
          echo "All fields are required.";
        } else {
          echo "Proceed...";
        }
        $lname = sanitize_text_field($_POST['lname']);
        // Add more validation as needed

        // Proceed to the next step if data is valid
        render_step_two();
    } else {
        // Display step one form
        ?>
        <h1>Step 1: Name</h1>
        <form method="POST">
            <input type="hidden" name="step" value="1">
            <input type="text" name="fname" placeholder="First name" required>
            <input type="text" name="lname" placeholder="Last name" required>
            <input type="submit" value="Next">
        </form>
        <?php
    }
}

// Function to render the second step of the form
function render_step_two() {
    if (isset($_POST['step']) && $_POST['step'] == 2) {
        // Process and validate data from step two
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        // Add more validation as needed

        // Proceed to the next step if data is valid
        render_step_three();
    } else {
        // Display step two form
        ?>
        <h1>Step 2: Contact Info</h1>
        <form method="POST">
            <input type="hidden" name="step" value="2">
            <p><input type="email" name="email" placeholder="E-mail"></p>
            <p><input type="text" name="phone" placeholder="Phone"></p>
            <input type="submit" value="Next">
        </form>
        <?php
    }
}

// Function to render the third step of the form
function render_step_three() {
    if (isset($_POST['step']) && $_POST['step'] == 3) {
        // Process and validate data from step three
        $dd = sanitize_text_field($_POST['dd']);
        $mm = sanitize_text_field($_POST['mm']);
        $yyyy = sanitize_text_field($_POST['yyyy']);
        // Add more validation as needed

        // You can process the final step here and send emails to the admin and client
        // After processing, you can redirect to a thank you page or display a success message.

    } else {
        // Display step three form
        ?>
        <h1>Step 3: Birthday</h1>
        <form method="POST">
            <input type="hidden" name="step" value="3">
            <p><input type="text" name="dd" placeholder="dd"></p>
            <p><input type="text" name="mm" placeholder="mm"></p>
            <p><input type="text" name="yyyy" placeholder="yyyy"></p>
            <input type="submit" value="Submit">
        </form>
        <?php
    }
}

// Function to display the form based on the current step
function display_multistep_form() {
    if (isset($_POST['step'])) {
        $step = intval($_POST['step']);
        render_form_step($step);
    } else {
        render_step_one();
    }
}

// Shortcode to display the multistep form
function multistep_form_shortcode() {
    ob_start();
    display_multistep_form();
    return ob_get_clean();
}
add_shortcode('multistep_form', 'multistep_form_shortcode');
