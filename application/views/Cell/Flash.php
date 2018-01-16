<?php
namespace App\View\Cell;

class Flash extends \Globalis\PuppetSkilled\View\Cell
{
    const FLASH_MSG_KEY = 'flash_msg';

    public function display()
    {
        return $this->render('default', ['messages' => $this->session->{self::FLASH_MSG_KEY}]);
    }
}
