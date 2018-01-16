<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('redirect_referrer')) {
    function redirect_referrer($default = '')
    {
        if (!isset(app()->CI->agent)) {
            app()->load->library('user_agent');
        }
        if (app()->agent->referrer()) {
            redirect(app()->agent->referrer());
        } else {
            redirect($default);
        }
    }
}


if (!function_exists('csrf_anchor')) {
    /**
     * Csrf anchor Link
     *
     * Creates an anchor based on the local URL.
     *
     * @param    string   the URL
     * @param    string   the link title
     * @param    mixed    any attributes
     * @return   string
     */
    function csrf_anchor($uri = '', $title = '', $attributes = '')
    {
        $siteUrl = is_array($uri)
            ? site_url($uri)
            : (preg_match('#^(\w+:)?//#i', $uri) ? $uri : site_url($uri));
            $title = (string) $title;

        if ($title === '') {
            $title = $siteUrl;
        }

        if ($attributes !== '') {
            if (is_array($attributes)) {
                if (!isset($attributes['title'])) {
                    $attributes['title'] = $title;
                }
            }
            $attributes = _stringify_attributes($attributes);
        }
        $CI = get_instance();
        // Add CSRF field if enabled, but leave it out for GET requests and requests to external websites
        if ($CI->config->item('csrf_protection') === true) {
            $html = '<form action="'.$siteUrl.'" method="post" class="d-inline" accept-charset="'.strtolower(config_item('charset')).'">';
            $html .= '<input type="hidden" name="'.$CI->security->get_csrf_token_name().'" value="'.html_escape($CI->security->get_csrf_hash()).'" />';
            $html .= '<button type="submit" '.$attributes.'>'.$title.'</button>';
            $html .= '</form>';
            return $html;
        } else {
            return '<a href="'.$siteUrl.'"'.$attributes.'>'.$title.'</a>';
        }
    }
}

if (!function_exists('route_is_accessible')) {
    function route_is_accessible($route)
    {
        $capability = str_replace('/', '.', $route);
        return app()->authenticationService->userCan($capability);
    }
}

if (!function_exists('uri_is_active')) {
    function uri_is_active($uri)
    {
        $currentUri = app()->uri->uri_string();
        $currentController = app()->router->class;
        $currentDirectory = app()->router->directory;
        $defaultController = app()->router->default_controller;

        if ($uri == '' && ($currentDirectory.$currentController != $defaultController)) {
            return false;
        }
        if (preg_match('/^' .preg_quote($uri, '/'). '/i', $currentUri)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('anchor')) {
    /**
     * Anchor Link
     *
     * Creates an anchor based on the local URL.
     *
     * @param    string   the URL
     * @param    string   the link title
     * @param    mixed    any attributes
     * @return   string
     */
    function anchor($uri = '', $title = '', $attributes = '')
    {
        $title = (string) $title;
        $siteUrl = is_array($uri)
            ? site_url($uri)
            : (preg_match('#^(\w+:)?//#i', $uri) ? $uri : site_url($uri));

        if ($title === '') {
            $title = $siteUrl;
        }

        if ($attributes !== '') {
            if (is_array($attributes)) {
                if (!isset($attributes['title'])) {
                    $attributes['title'] = $title;
                }
            }
            $attributes = _stringify_attributes($attributes);
        }

        return '<a href="'.$siteUrl.'"'.$attributes.'>'.$title.'</a>';
    }
}
if (!function_exists('navigation_anchor')) {
    function navigation_anchor($uri = '', $title = '', $attributes = '', $secure = true, $withLi = true)
    {
        if ($secure) {
            if (is_string($secure)) {
                $check = route_is_accessible($secure);
            } else {
                $check = route_is_accessible($uri);
            }
            if ($check === false) {
                return '';
            }
        }

        if (!isset($attributes['class'])) {
            $attributes['class'] = 'waves-effect';
        }

        $anchor = anchor($uri, $title, $attributes);
        if ($withLi) {
            $class = 'bold';
            if (uri_is_active($uri)) {
                $class .= ' active';
            }
            $anchor = '<li class="' . $class . '">' . $anchor . '</li>';
        }
        return $anchor;
    }
}

if (!function_exists('current_base_url')) {
    function current_base_url($with_method = false)
    {
        static $current_base_url;

        if (!$current_base_url) {
            list($method) =  array_slice(app()->uri->rsegments, 1, 1);
            $toRemove =  array_slice(app()->uri->rsegments, 2);
            $segments = app()->uri->segments;
            // Remove form segments
            if (($toRemove = count($toRemove))) {
                array_splice($segments, count($segments) - $toRemove);
            }

            if ($with_method) {
                if (end($segments) != $method) {
                    $segments[] = $method;
                }
            } else {
                if (end($segments) == $method) {
                    array_pop($segments);
                }
            }
            $current_base_url = implode('/', $segments);
        }
        return $current_base_url;
    }
}
