<?php
/**
 * Internationalization helper.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists('Kirki_l10n')) {

    /**
     * Handles translations
     */
    class Kirki_l10n
    {

        /**
         * The plugin textdomain
         *
         * @access protected
         * @var string
         */
        protected $textdomain = 'materialis';

        /**
         * The class constructor.
         * Adds actions & filters to handle the rest of the methods.
         *
         * @access public
         */
        public function __construct()
        {

            add_action('plugins_loaded', array($this, 'load_textdomain'));

        }

        /**
         * Load the plugin textdomain
         *
         * @access public
         */
        public function load_textdomain()
        {

            if (null !== $this->get_path()) {
                load_textdomain($this->textdomain, $this->get_path());
            }
            load_plugin_textdomain($this->textdomain, false, Kirki::$path . '/languages');

        }

        /**
         * Gets the path to a translation file.
         *
         * @access protected
         * @return string Absolute path to the translation file.
         */
        protected function get_path()
        {
            $path_found = false;
            $found_path = null;
            foreach ($this->get_paths() as $path) {
                if ($path_found) {
                    continue;
                }
                $path = wp_normalize_path($path);
                if (file_exists($path)) {
                    $path_found = true;
                    $found_path = $path;
                }
            }

            return $found_path;

        }

        /**
         * Returns an array of paths where translation files may be located.
         *
         * @access protected
         * @return array
         */
        protected function get_paths()
        {

            return array(
                WP_LANG_DIR . '/' . $this->textdomain . '-' . get_locale() . '.mo',
                Kirki::$path . '/languages/' . $this->textdomain . '-' . get_locale() . '.mo',
            );

        }

        /**
         * Shortcut method to get the translation strings
         *
         * @static
         * @access public
         *
         * @param string $config_id The config ID. See Kirki_Config.
         *
         * @return array
         */
        public static function get_strings($config_id = 'global')
        {

            $translation_strings = array(
                'background-color'      => esc_attr__('Background Color', 'materialis'),
                'background-image'      => esc_attr__('Background Image', 'materialis'),
                'no-repeat'             => esc_attr__('No Repeat', 'materialis'),
                'repeat-all'            => esc_attr__('Repeat All', 'materialis'),
                'repeat-x'              => esc_attr__('Repeat Horizontally', 'materialis'),
                'repeat-y'              => esc_attr__('Repeat Vertically', 'materialis'),
                'inherit'               => esc_attr__('Inherit', 'materialis'),
                'background-repeat'     => esc_attr__('Background Repeat', 'materialis'),
                'cover'                 => esc_attr__('Cover', 'materialis'),
                'contain'               => esc_attr__('Contain', 'materialis'),
                'background-size'       => esc_attr__('Background Size', 'materialis'),
                'fixed'                 => esc_attr__('Fixed', 'materialis'),
                'scroll'                => esc_attr__('Scroll', 'materialis'),
                'background-attachment' => esc_attr__('Background Attachment', 'materialis'),
                'left-top'              => esc_attr__('Left Top', 'materialis'),
                'left-center'           => esc_attr__('Left Center', 'materialis'),
                'left-bottom'           => esc_attr__('Left Bottom', 'materialis'),
                'right-top'             => esc_attr__('Right Top', 'materialis'),
                'right-center'          => esc_attr__('Right Center', 'materialis'),
                'right-bottom'          => esc_attr__('Right Bottom', 'materialis'),
                'center-top'            => esc_attr__('Center Top', 'materialis'),
                'center-center'         => esc_attr__('Center Center', 'materialis'),
                'center-bottom'         => esc_attr__('Center Bottom', 'materialis'),
                'background-position'   => esc_attr__('Background Position', 'materialis'),
                'background-opacity'    => esc_attr__('Background Opacity', 'materialis'),
                'on'                    => esc_attr__('ON', 'materialis'),
                'off'                   => esc_attr__('OFF', 'materialis'),
                'all'                   => esc_attr__('All', 'materialis'),
                'cyrillic'              => esc_attr__('Cyrillic', 'materialis'),
                'cyrillic-ext'          => esc_attr__('Cyrillic Extended', 'materialis'),
                'devanagari'            => esc_attr__('Devanagari', 'materialis'),
                'greek'                 => esc_attr__('Greek', 'materialis'),
                'greek-ext'             => esc_attr__('Greek Extended', 'materialis'),
                'khmer'                 => esc_attr__('Khmer', 'materialis'),
                'latin'                 => esc_attr__('Latin', 'materialis'),
                'latin-ext'             => esc_attr__('Latin Extended', 'materialis'),
                'vietnamese'            => esc_attr__('Vietnamese', 'materialis'),
                'hebrew'                => esc_attr__('Hebrew', 'materialis'),
                'arabic'                => esc_attr__('Arabic', 'materialis'),
                'bengali'               => esc_attr__('Bengali', 'materialis'),
                'gujarati'              => esc_attr__('Gujarati', 'materialis'),
                'tamil'                 => esc_attr__('Tamil', 'materialis'),
                'telugu'                => esc_attr__('Telugu', 'materialis'),
                'thai'                  => esc_attr__('Thai', 'materialis'),
                'serif'                 => _x('Serif', 'font style', 'materialis'),
                'sans-serif'            => _x('Sans Serif', 'font style', 'materialis'),
                'monospace'             => _x('Monospace', 'font style', 'materialis'),
                'font-family'           => esc_attr__('Font Family', 'materialis'),
                'font-size'             => esc_attr__('Font Size', 'materialis'),
                'mobile-font-size'      => esc_attr__('Mobile Font Size', 'materialis'),
                'font-weight'           => esc_attr__('Font Weight', 'materialis'),
                'line-height'           => esc_attr__('Line Height', 'materialis'),
                'font-style'            => esc_attr__('Font Style', 'materialis'),
                'letter-spacing'        => esc_attr__('Letter Spacing', 'materialis'),
                'top'                   => esc_attr__('Top', 'materialis'),
                'bottom'                => esc_attr__('Bottom', 'materialis'),
                'left'                  => esc_attr__('Left', 'materialis'),
                'right'                 => esc_attr__('Right', 'materialis'),
                'center'                => esc_attr__('Center', 'materialis'),
                'justify'               => esc_attr__('Justify', 'materialis'),
                'color'                 => esc_attr__('Color', 'materialis'),
                'add-image'             => esc_attr__('Add Image', 'materialis'),
                'change-image'          => esc_attr__('Change Image', 'materialis'),
                'no-image-selected'     => esc_attr__('No Image Selected', 'materialis'),
                'add-file'              => esc_attr__('Add File', 'materialis'),
                'change-file'           => esc_attr__('Change File', 'materialis'),
                'no-file-selected'      => esc_attr__('No File Selected', 'materialis'),
                'remove'                => esc_attr__('Remove', 'materialis'),
                'select-font-family'    => esc_attr__('Select a font-family', 'materialis'),
                'variant'               => esc_attr__('Variant', 'materialis'),
                'subsets'               => esc_attr__('Subset', 'materialis'),
                'size'                  => esc_attr__('Size', 'materialis'),
                'height'                => esc_attr__('Height', 'materialis'),
                'spacing'               => esc_attr__('Spacing', 'materialis'),
                'ultra-light'           => esc_attr__('Thin (100)', 'materialis'),
                'ultra-light-italic'    => esc_attr__('Thin (100) Italic', 'materialis'),
                'light'                 => esc_attr__('Extra light (200)', 'materialis'),
                'light-italic'          => esc_attr__('Extra light (200) Italic', 'materialis'),
                'book'                  => esc_attr__('Light (300)', 'materialis'),
                'book-italic'           => esc_attr__('Light (300) Italic', 'materialis'),
                'regular'               => esc_attr__('Normal (400)', 'materialis'),
                'italic'                => esc_attr__('Normal (400) Italic', 'materialis'),
                'medium'                => esc_attr__('Medium (500)', 'materialis'),
                'medium-italic'         => esc_attr__('Medium (500) Italic', 'materialis'),
                'semi-bold'             => esc_attr__('Semi Bold (600)', 'materialis'),
                'semi-bold-italic'      => esc_attr__('Semi Bold (600) Italic', 'materialis'),
                'bold'                  => esc_attr__('Bold (700)', 'materialis'),
                'bold-italic'           => esc_attr__('Bold (700) Italic', 'materialis'),
                'extra-bold'            => esc_attr__('Extra Bold (800)', 'materialis'),
                'extra-bold-italic'     => esc_attr__('Extra Bold (800) Italic', 'materialis'),
                'ultra-bold'            => esc_attr__('Black (900)', 'materialis'),
                'ultra-bold-italic'     => esc_attr__('Black (900) Italic', 'materialis'),
                'invalid-value'         => esc_attr__('Invalid Value', 'materialis'),
                'add-new'               => esc_attr__('Add new', 'materialis'),
                'row'                   => esc_attr__('row', 'materialis'),
                'limit-rows'            => esc_attr__('Limit: %s rows', 'materialis'),
                'open-section'          => esc_attr__('Press return or enter to open this section', 'materialis'),
                'back'                  => esc_attr__('Back', 'materialis'),
                'reset-with-icon'       => sprintf(esc_attr__('%s Reset', 'materialis'), '<span class="dashicons dashicons-image-rotate"></span>'),
                'text-align'            => esc_attr__('Text Align', 'materialis'),
                'text-transform'        => esc_attr__('Text Transform', 'materialis'),
                'none'                  => esc_attr__('None', 'materialis'),
                'capitalize'            => esc_attr__('Capitalize', 'materialis'),
                'uppercase'             => esc_attr__('Uppercase', 'materialis'),
                'lowercase'             => esc_attr__('Lowercase', 'materialis'),
                'initial'               => esc_attr__('Initial', 'materialis'),
                'select-page'           => esc_attr__('Select a Page', 'materialis'),
                'open-editor'           => esc_attr__('Open Editor', 'materialis'),
                'close-editor'          => esc_attr__('Close Editor', 'materialis'),
                'switch-editor'         => esc_attr__('Switch Editor', 'materialis'),
                'hex-value'             => esc_attr__('Hex Value', 'materialis'),
                'addwebfont'            => esc_attr__('Add Web Font', 'materialis'),
            );

            // Apply global changes from the kirki/config filter.
            // This is generally to be avoided.
            // It is ONLY provided here for backwards-compatibility reasons.
            // Please use the kirki/{$config_id}/l10n filter instead.
            $config = apply_filters('kirki/config', array());
            if (isset($config['i18n'])) {
                $translation_strings = wp_parse_args($config['i18n'], $translation_strings);
            }

            // Apply l10n changes using the kirki/{$config_id}/l10n filter.
            return apply_filters('kirki/' . $config_id . '/l10n', $translation_strings);

        }
    }
}
