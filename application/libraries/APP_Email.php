<?php

class APP_Email extends CI_Email
{
    protected $email_interception = false;

    protected $to_debug = false;

    protected $cc_debug = false;

    protected $bcc_debug = false;

    protected $email_bcc = false;

    /**
     * Set Recipients
     *
     * @param    $to    string
     * @return   CI_Email
     */
    public function to($to)
    {
        if ($this->email_interception) {
            $this->to_debug = $to;
            $to = $this->email_interception;
        }
        return parent::to($to);
    }


    /**
     * Set CC
     *
     * @param    $cc    string
     * @return   CI_Email
     */
    public function cc($cc)
    {
        if ($this->email_interception) {
            $this->cc_debug = $cc;
            $cc = $this->email_interception;
        }
        return parent::cc($cc);
    }


    /**
     * Set BCC
     *
     * @param    $bcc string
     * @param    $limit string
     * @return   CI_Email
     */
    public function bcc($bcc, $limit = '')
    {
        if ($this->email_interception) {
            $this->bcc_debug = $bcc;
            $bcc = $this->email_interception;
        }
        return parent::bcc($bcc, $limit);
    }


    /**
     * Build Final Body and attachments
     *
     * @return	bool
     */
    protected function _build_message()
    {
        //Debug is active ?
        if ($this->email_interception) {

            $debug_separator = $this->newline;
            if ($this->mailtype === 'html') {
                $debug_separator = "<br/>";
            }

            $this->_body .= $debug_separator . $debug_separator . '**** DEBUG ****' . $debug_separator;

            //Debug
            if ($this->to_debug) {
                $this->_body .= ' to: ' . $this->to_debug . $debug_separator;
            }

            if ($this->cc_debug) {
                $this->_body .= ' cc: ' . $this->cc_debug . $debug_separator;
            }

            if ($this->bcc_debug) {
                $this->_body .= ' bcc: ' . $this->bcc_debug . $debug_separator ;
            }
            $this->_body .= '***************' . $debug_separator;
        } elseif ($this->email_bcc) {
            $this->bcc($this->email_bcc);
        }
        return parent::_build_message();
    }
}
