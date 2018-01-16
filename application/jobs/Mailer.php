<?php
namespace App\Job;

use APP_Email;

class Mailer extends \Globalis\PuppetSkilled\Queue\Queueable {

    protected $email;

    public function __construct()
    {
        $this->loadBaseEmail();
    }

    protected function loadBaseEmail()
    {
        if (!class_exists('APP_Email')) {
            // Load email library
            app()->load->library('email');
        }
        $this->email = app()->email;

        $this->email->from(app()->settings->get('email.from'));
        $this->email->reply_to(app()->settings->get('email.reply_to'));
    }

    public function handle()
    {
        $this->email->send();
    }

    /**
     * Dynamically handle calls into the email instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $return = $this->email->$method(...$parameters);
        if ($return instanceof APP_Email) {
            return $this;
        }
        return $return;
    }
}
