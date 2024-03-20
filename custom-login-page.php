<?php
/* Template Name: Custom Login Page */

get_header();

// Redirect logged in users to home page
if (is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}

// Define variables
$username = '';
$error = '';

// Check if form is submitted
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $creds = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => true
    );

    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        $error = $user->get_error_message();
    } else {
        wp_redirect(home_url('/dashboard'));
        exit;
    }
}

// Login Form
?>
<div class="custom-login-form">
    <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo esc_attr($username); ?>" required>
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </p>
        <?php if ($error) echo '<p class="error">' . $error . '</p>'; ?>
        <p>
            <?php wp_nonce_field('login_action', 'login_nonce'); ?>
            <input type="submit" name="submit" value="Login">
        </p>
    </form>
    <p>
        <a href="<?php echo wp_lostpassword_url(); ?>">Forgot Password?</a>
    </p>
    <p>
        Don't have an account? <a href="https://thaynna-william.co.uk/organiser-sign-up/">Sign Up</a>
    </p>
</div>

<?php
get_footer();









// Function to fetch current user's events and associated tickets with frontend debugging and title
function fetch_user_events_with_tickets_debug() {
    // Check if user is logged in
    if (is_user_logged_in()) {
        // Get current user ID
        $user_id = get_current_user_id();
        
        // Get user's events
        $user_events = tribe_get_events( array(
            'author' => $user_id, // Filter events by user ID
            'posts_per_page' => -1, // Get all events
        ) );

        // Initialize output variable
        $output = '';

        // Add title indicating shortcode is working
        $output .= '<h2>Events and Tickets for Current User:</h2>';

        // Debugging: Output user ID
        $output .= '<p>User ID: ' . $user_id . '</p>';

        // Debugging: Output number of events found
        $output .= '<p>Number of Events Found: ' . count($user_events) . '</p>';

        // Loop through user's events
        foreach ($user_events as $event) {
            // Get event ID
            $event_id = $event->ID;

            // Get tickets attached to the event
            $woo_tickets = TribeWooTickets::get_instance();
            $ticket_ids = $woo_tickets->get_tickets_ids($event_id);

            // Debugging: Output event ID and number of tickets
            $output .= '<p>Event ID: ' . $event_id . ' - Number of Tickets: ' . count($ticket_ids) . '</p>';

            // Start building output for the event
            $output .= '<div class="event">';
            $output .= '<h3>' . get_the_title($event_id) . '</h3>'; // Event title

            // Loop through tickets
            foreach ($ticket_ids as $ticket_id) {
                // Get ticket title and other ticket data as needed
                $ticket_title = get_the_title($ticket_id);
                // You can add more ticket data retrieval here if needed

                // Add ticket information to output
                $output .= '<p>Ticket: ' . $ticket_title . '</p>';
            }

            $output .= '</div>'; // End of event
        }

        return $output;
    } else {
        return '<p>You must be logged in to view your events.</p>';
    }
}
// Register shortcode
add_shortcode('user_events_with_tickets', 'fetch_user_events_with_tickets_debug');
?>


























