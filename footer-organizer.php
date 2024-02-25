<?php
/**
 * The template for displaying the footer.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        
    </footer>
</div>

<?php
wp_footer();
?>
<script>
    jQuery('.flux-checkout__login-button.login-button').each(function() {
        // Add classes 'xoo-el-action-sc' and 'xoo-el-login-tgr'
        jQuery(this).addClass('xoo-el-action-sc xoo-el-login-tgr');
    });
</script>
</body>
</html>