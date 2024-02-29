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
?>








