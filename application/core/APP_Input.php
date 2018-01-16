<?php
/**
 * Surcharge Input problème sur le vérification CSRF (trop tot)
 */
class APP_Input extends CI_Input
{
    /**
     * Class constructor
     *
     * Determines whether to globally enable the XSS processing
     * and whether to allow the $_GET array.
     *
     * @return    void
     */
    public function __construct()
    {
        $this->_allow_get_array   = (config_item('allow_get_array') === true);
        $this->_enable_xss        = (config_item('global_xss_filtering') === true);
        $this->_enable_csrf       = (config_item('csrf_protection') === true);
        $this->_standardize_newlines  = (bool) config_item('standardize_newlines');
        $this->security =& load_class('Security', 'core');
        // Do we need the UTF-8 class?
        if (UTF8_ENABLED === true) {
            $this->uni = load_class('Utf8', 'core');
        }
        // Sanitize global arrays
        $this->_sanitize_globals();
        log_message('info', 'Input Class Initialized');
    }
}
