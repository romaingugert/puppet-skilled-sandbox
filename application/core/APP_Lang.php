<?php
defined('BASEPATH') or exit('No direct script access allowed');

class APP_Lang extends CI_Lang
{

    protected $subDirectories = [''];

    public function addSubdirectory($subDirectory)
    {
        $this->subDirectories[] = trim($subDirectory, '/') .'/';
    }

    /**
     * Language line
     *
     * Fetches a single line of text from the language array
     *
     * @param   string  $line       Language line key
     * @param   bool    $log_errors Whether to log an error message if the line is not found
     * @return  string  Translation
     */
    public function line($line, $log_errors = true)
    {
        $value = $this->_line($line);

        if ($value === false) {
            // Try to load langage file
            $value = $this->autoloadFromLine($line);
            if ($value === false && $log_errors === true) {
                log_message('error', 'Could not find the language line "'.$line.'"');
            }
        }
        return $value;
    }

    protected function autoloadFromLine($line)
    {
        $directories = explode('_', $line);
        $basePath = APPPATH.'language/'.config_item('language').'/';
        $path = '';
        foreach ($directories as $directory) {
            foreach ($this->subDirectories as $subDirectory) {
                if (file_exists($basePath.$subDirectory.$path.$directory.'_lang.php')) {
                    $this->load($subDirectory.$path.$directory.'_lang.php');
                    return $this->_line($line);
                }
            }
            $path .= $directory.'/';
        }
        return $this->_line($line);
    }

    protected function _line($line)
    {
        return isset($this->language[$line]) ? $this->language[$line] : false;
    }
}
