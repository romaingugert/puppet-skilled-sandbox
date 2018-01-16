<?php


if (!function_exists('form_open')) {
    /**
     * Form Declaration
     *
     * Creates the opening portion of the form.
     *
     * @param    string    the URI segments of the form destination
     * @param    array    a key/value pair of attributes
     * @param    array    a key/value pair hidden data
     * @return    string
     */
    function form_open(\Globalis\PuppetSkilled\Library\FormValidation $validator, $action = '', array $attributes = array(), array $hidden = array())
    {
        $CI = get_instance();

        // Register validator
        $CI->form_validation = $validator;

        // If no action is provided then set to the current url
        if (!$action) {
            $action = $CI->config->site_url($CI->uri->uri_string());
        } // If an action is not a full URL then turn it into one
        elseif (strpos($action, '://') === false) {
            $action = $CI->config->site_url($action);
        }

        $attributes = _attributes_to_string($attributes);

        if (stripos($attributes, 'method=') === false) {
            $attributes .= ' method="post"';
        }

        if (stripos($attributes, 'accept-charset=') === false) {
            $attributes .= ' accept-charset="'.strtolower(config_item('charset')).'"';
        }

        $form = '<form action="'.$action.'"'.$attributes.">\n";

        // Add CSRF field if enabled, but leave it out for GET requests and requests to external websites
        if ($CI->config->item('csrf_protection') === true && strpos($action, $CI->config->base_url()) !== false && ! stripos($form, 'method="get"')) {
            $hidden[$CI->security->get_csrf_token_name()] = $CI->security->get_csrf_hash();
        }

        if (is_array($hidden)) {
            foreach ($hidden as $name => $value) {
                $form .= '<input type="hidden" name="'.$name.'" value="'.html_escape($value).'" />'."\n";
            }
        }
        return $form;
    }
}

if (!function_exists('form_csrf_input')) {
    /**
     * Get CSRF hidden input
     *
     * @return string
     */
    function form_csrf_input()
    {
        $CI = get_instance();
        if ($CI->config->item('csrf_protection') === true) {
            return '<input type="hidden" name="'.$CI->security->get_csrf_token_name().'" value="'.html_escape($CI->security->get_csrf_hash()).'" />'."\n";
        }
        return '';

    }

}

if (!function_exists('is_required_field')) {
    function is_required_field($field)
    {
        $validator = _get_validation_object();
        if ($validator && $validator->isRequired($field)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('set_required_symbol')) {
    function set_required_symbol($field)
    {
        $validator = _get_validation_object();
        if (is_required_field($field)) {
            return ' ' . lang('general_required_symbol');
        }
        return '';
    }
}

if (!function_exists('form_label')) {
    /**
     * Form Label Tag
     * Si le field a un Id différent de son nom, dans le param attributes on met un tableau avec la clé 'for'
     *
     * @param    string    The text to appear onscreen
     * @param    string    The field the label applies to
     * @param    string    Additional attributes
     * @return   string
     */
    function form_label($label_text, $field, $attributes = array())
    {
        $label = '<label';
        $defaults = [
            'for' => $field,
            'class' => '',
        ];
        $defaults = $attributes + $defaults;
        if (form_error($field)) {
            $defaults['data-error'] = str_replace(['<p>', '</p>'], '', form_error($field));
            $defaults['class'] .= ' active';
        }
        $label .= _attributes_to_string($defaults);
        return $label.'>'.lang_libelle($label_text).set_required_symbol($field).'</label>';
    }
}

if (!function_exists('form_input')) {
    /**
     * Text Input Field
     *
     * @param    string     Input name
     * @param    string     Default value
     * @param    array      attributes
     * @return   string
     */
    function form_input($name, $default_value = '', $extra = array())
    {
        $defaults = [
            'type'  => 'text',
            'name'  => $name,
            'class' => 'validate',
            'id'    => $name,
        ];
        $defaults['value'] = set_value($name, $default_value, false);
        $defaults = $extra + $defaults;
        if (form_error($name)) {
            $defaults['class'] = ' invalid';
        }

        return '<input ' . _attributes_to_string($defaults) . " />";
    }
}

if (!function_exists('form_error')) {
    /**
     * Form Error
     *
     * Returns the error for a specific form field. This is a helper for the
     * form validation class.
     *
     * @param       string
     * @param       string
     * @param       string
     * @return      string
     */
    function form_error($field = '', $prefix = '', $suffix = '')
    {
        if (false === ($OBJ = _get_validation_object())) {
            return '';
        }
        return $OBJ->error($field, $prefix, $suffix);
    }
}

if (!function_exists('_get_validation_object')) {
    /**
     * Validation Object
     *
     * Determines what the form validation class was instantiated as, fetches
     * the object and returns it.
     *
     * @return    mixed
     */
    function _get_validation_object()
    {
        $CI = get_instance();
        // We set this as a variable since we're returning by reference.
        if (!isset($CI->form_validation) || !is_object($CI->form_validation)) {
            return false;
        }
        return $CI->form_validation;
    }
}


if (!function_exists('_attributes_to_string')) {
    /**
     * Attributes To String
     *
     * Helper function used by some of the form helpers
     *
     * @param    mixed
     * @return   string
     */
    function _attributes_to_string($attributes)
    {
        if (empty($attributes)) {
            return '';
        }

        if (is_object($attributes)) {
            $attributes = (array) $attributes;
        }

        if (is_array($attributes)) {
            $atts = '';
            foreach ($attributes as $key => $val) {
                $atts .= ' '.$key."='".html_escape($val)."'";
            }
            return $atts;
        }

        if (is_string($attributes)) {
            return ' '.$attributes;
        }

        return false;
    }
}
