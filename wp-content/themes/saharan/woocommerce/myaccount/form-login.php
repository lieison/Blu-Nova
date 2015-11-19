<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.6
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="customer_login" id="customer_login">
	<div class="row">
		<div class="col-xs-12 col-md-6">

	<?php endif; ?>

			<form method="post" class="login">
				<div class="form-fields">
					<h2><?php esc_html_e( 'Login', 'saharan' ); ?></h2>
					
					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<p class="form-row form-row-wide">
						<label for="username"><?php esc_html_e( 'Username or email address', 'saharan' ); ?> <span class="required">*</span></label>
						<input type="text" class="input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
					</p>
					<p class="form-row form-row-wide">
						<label for="password"><?php esc_html_e( 'Password', 'saharan' ); ?> <span class="required">*</span></label>
						<input class="input-text" type="password" name="password" id="password" />
					</p>

					<?php do_action( 'woocommerce_login_form' ); ?>
				</div>
				<div class="form-action">
					<?php wp_nonce_field( 'woocommerce-login' ); ?>
					<p class="lost_password">
						<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'saharan' ); ?></a>
					</p>
					<input type="submit" class="button" name="login" value="<?php esc_html_e( 'Login', 'saharan' ); ?>" /> 
					<label for="rememberme" class="inline">
						<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember me', 'saharan' ); ?>
					</label>
				</div>

				<?php do_action( 'woocommerce_login_form_end' ); ?>
				
			</form>

	<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

		</div>

		<div class="col-xs-12 col-md-6">

			<form method="post" class="register">
				<div class="form-fields">
					<h2><?php esc_html_e( 'Register', 'saharan' ); ?></h2>
					
					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

						<p class="form-row form-row-wide">
							<label for="reg_username"><?php esc_html_e( 'Username', 'saharan' ); ?> <span class="required">*</span></label>
							<input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
						</p>

					<?php endif; ?>

					<p class="form-row form-row-wide">
						<label for="reg_email"><?php esc_html_e( 'Email address', 'saharan' ); ?> <span class="required">*</span></label>
						<input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
					</p>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
			
						<p class="form-row form-row-wide">
							<label for="reg_password"><?php esc_html_e( 'Password', 'saharan' ); ?> <span class="required">*</span></label>
							<input type="password" class="input-text" name="password" id="reg_password" />
						</p>

					<?php endif; ?>

					<!-- Spam Trap -->
					<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php esc_html_e( 'Anti-spam', 'saharan' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

					<?php do_action( 'woocommerce_register_form' ); ?>
					<?php do_action( 'register_form' ); ?>

					<?php do_action( 'woocommerce_register_form_end' ); ?>
				</div>
				<div class="form-action">
					<?php wp_nonce_field( 'woocommerce-register' ); ?>
					<input type="submit" class="button" name="register" value="<?php esc_html_e( 'Register', 'saharan' ); ?>" />
				</div>
			</form>

		</div>
	</div>
</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
