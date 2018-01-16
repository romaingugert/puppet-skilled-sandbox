<?php
namespace App\View\Cell;

class DebugBar extends \Globalis\PuppetSkilled\View\Cell
{
    public function display()
    {
        $this->CI->load->helper('text');
        $data = [];
        $data['benchmarks'] = $this->getBenchMarks();
        $data['databases'] = $this->getQueries();
        $data['config'] = $this->CI->config->config;
        $data['controller_info'] = $this->CI->router->class.'/'.$this->CI->router->method;
        $data['uri_string'] = $this->CI->uri->uri_string;
        return $this->render('main', $data);
    }

    protected function getBenchMarks()
    {
        $benchmarks = array();
        foreach ($this->CI->benchmark->marker as $key => $val) {
            if (preg_match('/(.+?)_end$/i', $key, $match)
                && isset($this->CI->benchmark->marker[$match[1].'_end'], $this->CI->benchmark->marker[$match[1].'_start'])
            ) {
                $benchmarks[$match[1]] = $this->CI->benchmark->elapsed_time($match[1].'_start', $key);
            }
        }
        return $benchmarks;
    }

    protected function getQueries()
    {
        $dbs = [];
        // Let's determine which databases are currently connected to
        foreach (get_object_vars($this->CI) as $name => $cobject) {
            if (is_object($cobject)) {
                if ($cobject instanceof \CI_DB) {
                    $dbs[get_class($this->CI).':$'.$name] = $cobject;
                } elseif ($cobject instanceof \CI_Model) {
                    foreach (get_object_vars($cobject) as $mname => $mobject) {
                        if ($mobject instanceof \CI_DB) {
                            $dbs[get_class($cobject).':$'.$mname] = $mobject;
                        }
                    }
                }
            }
        }
        return $dbs;
    }
}
