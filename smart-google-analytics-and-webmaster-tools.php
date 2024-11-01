<?php
#     /*
#     Plugin Name: Smart Google Analytics & Webmaster Tools
#     Plugin URI: http://www.wpchandra.com/
#     Description: Easily Configure Google Analytics & Webmaster Tools for your websites. 
#     Author: Chandrakesh Kumar
#     Version: 2.0
#     Author URI: http://www.wpchandra.com/
#     */
 
define('wpsmart_blog_name',get_bloginfo('name'));
define('wpsmart_site_url',get_site_url());
define('wpsmart_plugin_url',plugins_url( '/', __FILE__ ));

if (!class_exists('WPChandra_analytics_Webmaster_tools')) {
	class WPChandra_analytics_Webmaster_tools {
		function __construct() {
			add_action('admin_menu', array(&$this, 'wpsmart_menu'));
			add_action('wp_head', array(&$this, 'wpsmart_add_webmaster_head'));
			add_action('admin_head', array(&$this, 'wpsmart_add_js_scripts'), 5);
			register_activation_hook( __FILE__, array(&$this, 'wpsmart_activate') ); //register activation hook
			register_deactivation_hook( __FILE__, array(&$this, 'wpsmart_deactivate') ); //register deactivation hook 

		}

	function wpsmart_menu() {
		add_menu_page('Analytics & Webmaster Tools', 'Webmaster Tools', 'manage_options', 'wpsmart-google-analytics-and-webmaster-tools', array($this, 'google_analytics_and_webmaster_tools_settings_page'),plugins_url( 'images/menu_icon.png', __FILE__ ) );
		add_action( 'admin_init', array($this, 'wpsmart_settings') );
	}
	
	function wpsmart_settings() { //register settings
		register_setting( 'wpsmart-analytics-settings-group', 'wpsmart_google_analytics_code');
		register_setting( 'wpsmart-webmasters-settings-group', 'wpsmart_google_webmaster_code');
		register_setting( 'wpsmart-webmasters-settings-group', 'wpsmart_bring_webmaster_code');
	}

	function wpsmart_activate() { //add default setting values on activation
	    add_option( 'wpsmart_google_analytics_code', '', '', '' );
		add_option( 'wpsmart_google_webmaster_code', '', '', '' );
		add_option( 'wpsmart_bring_webmaster_code', '', '', '' );
	}
	function wpsmart_deactivate() { //delete setting and values on deactivation
	    delete_option( 'wpsmart_google_analytics_code');
		delete_option( 'wpsmart_google_webmaster_code');
		delete_option( 'wpsmart_bring_webmaster_code');
	}
	function wpsmart_add_js_scripts() {
		 if(get_option('wpsmart_google_analytics_code')){
			echo get_option('wpsmart_google_analytics_code');
		}
	}
	function wpsmart_add_webmaster_head(){
		if(get_option('wpsmart_google_webmaster_code')){
			?>
			<meta name="google-site-verification" content="<?php echo get_option('wpsmart_google_webmaster_code'); ?>" />
			<?php
		}
		if(get_option('wpsmart_bring_webmaster_code')){
			?>
			<meta name="google-site-verification" content="<?php echo get_option('wpsmart_bring_webmaster_code'); ?>" />
			<?php
		}
	}
		
	 function google_analytics_and_webmaster_tools_settings_page(){
	 
 ?>

<style type="text/css">
.form-table td.frm_wp_heading{
	padding:0px;
}
</style>
<div class='wrap'> 
	<h1><?php _e('Smart Google Analytics & Webmaster Tools', 'wpchandra'); ?></h1>
	<p class="description"><?php _e('Easily Configure Google Analytics & Webmaster Tools for your websites. Google Analytics & Webmaster Tools provides reports and data that can help you understand how different pages on your website are appearing in search results.', 'wpchandra'); ?></p>
	<?php include('inc/social-media.php'); ?>
	<?php
	$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'analytics_settings';
	if(isset($_GET['tab'])) $active_tab = $_GET['tab'];
	?>
	<h2 class="nav-tab-wrapper">
		<a href="?page=wpsmart-google-analytics-and-webmaster-tools&amp;tab=analytics_settings" class="nav-tab <?php echo $active_tab == 'analytics_settings' ? 'nav-tab-active' : ''; ?>"><?php _e('Analytics Settings', 'wpchandra'); ?></a>
		<a href="?page=wpsmart-google-analytics-and-webmaster-tools&amp;tab=webmaster_settings" class="nav-tab <?php echo $active_tab == 'webmaster_settings' ? 'nav-tab-active' : ''; ?>"><?php _e('Webmaster Tools', 'wpchandra'); ?></a>
		<a href="?page=wpsmart-google-analytics-and-webmaster-tools&amp;tab=donate_now" class="nav-tab <?php echo $active_tab == 'donate_now' ? 'nav-tab-active' : ''; ?>"><?php _e('Donate Now', 'wpchandra'); ?></a>
	</h2>
	
		
		<?php if($active_tab == 'analytics_settings') { ?>
		
		 <form method="post" action="options.php">
     	<?php settings_errors(); ?>
		<?php settings_fields('wpsmart-analytics-settings-group'); ?>
		<?php do_settings_sections('wpsmart-analytics-settings-group'); ?>
		
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
			<h3><?php _e('Google Analytics', 'wpchandra'); ?></h3>
			<div class="inside">
				<p><?php _e('In this area, paste your Google Analytics tracking code.', 'wpchandra'); ?></p>
				
			<table class="form-table">
				
				<tr valign="top">
                	<td style="width:100%;" colspan="2"><textarea rows="14" cols="90" style="margin: 0px; width: 100%; " id="wpsmart_google_analytics_code" name="wpsmart_google_analytics_code"><?php echo get_option('wpsmart_google_analytics_code') ?></textarea></td>
                </tr>
				
				<tr valign="top" align="left">
					<td class="frm_wp_heading"><?php submit_button(); ?></td>
				</tr>
				
				</table>
				
			</div>
			</div>
		</div>
		</form>
		<?php } ?>
		
		
		
		<?php if($active_tab == 'webmaster_settings') { ?>
		
		 <form method="post" action="options.php">
     	<?php settings_errors(); ?>
		<?php settings_fields('wpsmart-webmasters-settings-group'); ?>
		<?php do_settings_sections('wpsmart-webmasters-settings-group'); ?>
		
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
			<h3><?php _e('Webmaster Tools Settings', 'wpchandra'); ?></h3>
			<div class="inside">
				<p><?php _e('You can use the boxes below to verify with the different Webmaster Tools, if your site is already verified, you can just forget about these. Enter the verify meta values for:', 'wpchandra'); ?></p>
				
			<table class="form-table">
			
				 <tr valign="top">
					  <th scope="row" style="width: 180px;"><label class="checkbox" for="wpsmart_google_webmaster_code"><?php _e('Google Webmaster Tools', 'wpchandra'); ?>:</label></th>
					  <td>
						  <input id="wpsmart_google_webmaster_code" type="text" name="wpsmart_google_webmaster_code" value="<?php echo get_option('wpsmart_google_webmaster_code') ?>" size="50" />
					 </td>
				 </tr>
				 
				 <tr valign="top">
					  <th scope="row" style="width: 180px;"><label class="checkbox" for="wpsmart_bring_webmaster_code"><?php _e('Bing Webmaster Tools', 'wpchandra'); ?>:</label></th>
					  <td>
						  <input id="wpsmart_bring_webmaster_code" type="text" name="wpsmart_bring_webmaster_code" value="<?php echo get_option('wpsmart_bring_webmaster_code') ?>" size="50" />
					 </td>
				 </tr>
				 

				<tr valign="top" align="left">
					<td class="frm_wp_heading"><?php submit_button(); ?></td>
				</tr>
		
			</table>
				
			</div>
			</div>
		</div>
		</form>
		<?php } ?>
		
	</div>

	<?php
	
	 }//settings

	}

}

if (class_exists('WPChandra_analytics_Webmaster_tools')) {
	$WPChandra_analytics_Webmaster_tools = new WPChandra_analytics_Webmaster_tools();
}
?>