<?php
/*
Plugin Name: TinyMCE Overline Button
Plugin URI: https://github.com/h0tw1r3/wp-tinymce-overline-button/
Description: TinyMCE button for applying overline style
Version: 1.0
Author: Jeffrey Clark
Author URI: http://github.com/h0tw1r3/
Credits: Geert De Deckere
*/

new TinyMCE_Overline_Button;

class TinyMCE_Overline_Button {

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		add_action('init', array($this, 'wp_init'));
	}

	/**
	 * Initialize the plugin
	 *
	 * @return void
	 */
	public function wp_init()
	{
		if ( get_user_option('rich_editing') !== 'true')
            return;

		// Note: the TinyMCE Advanced plugin also uses these hooks and uses priority 999.
		// We need a higher priority in order for the button to be added succesfully.
		// See: http://wordpress.org/extend/plugins/tinymce-advanced/
		add_filter('mce_buttons_2', array($this, 'mce_buttons_2'), 1000);
        add_filter('mce_external_plugins', array($this, 'mce_external_plugins'), 1000);
        wp_register_style('tinymce-overline', plugins_url('style.css', __FILE__));
    }

	/**
	 * Add button to the second row of the TinyMCE editor, after underline
	 *
	 * @param array $buttons ordered button list
	 * @return array $buttons
	 */
	public function mce_buttons_2($buttons)
	{
		// Look for the regular link button
		if (FALSE === ($key = array_search('underline', $buttons)))
		{
			// Append the button to the end of the row if no link button was found
			$buttons[] = 'overline';
		}
		else
		{
            // Insert the overline button after the underline button
            array_splice($buttons, $key+1, 0, array('overline'));
		}

		return $buttons;
	}

	/**
	 * Register the JavaScript file for the button
	 *
	 * @param array $plugins TinyMCE plugin files
	 * @return array $plugins
	 */
	public function mce_external_plugins($plugins)
    {
        wp_enqueue_style('tinymce-overline');
		$suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '_src' : '';
		$plugins['overline'] = plugin_dir_url(__FILE__).'plugin'.$suffix.'.js';
		return $plugins;
	}

}
