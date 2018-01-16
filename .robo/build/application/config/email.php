<?php

//The “user agent”.
$config['useragent'] = '<##PROJECT_NAME##>';

//The mail sending protocol. (mail, sendmail, or smtp)
$config['protocol'] = '<##EMAIL_PROTOCOL##>';

//The server path to Sendmail.
$config['mailpath'] = '/usr/sbin/sendmail';

//SMTP Server Address.
$config['smtp_host'] = '<##EMAIL_HOST##>';

//SMTP Username.
$config['smtp_user'] = '';

//SMTP Password.
$config['smtp_pass'] = '';

//SMTP Port.
$config['smtp_port'] = <##EMAIL_PORT##>;

//SMTP Timeout (in seconds).
$config['smtp_timeout'] = 5;

//Enable persistent SMTP connections. (true or false)
$config['smtp_keepalive'] = false;

//SMTP Encryption (tls or ssl)
$config['smtp_crypto'] = '';

//Enable word-wrap. (true or false)
$config['wordwrap'] = true;

//Character count to wrap at.
$config['wrapchars'] = 	76;

//Type of mail. If you send HTML email you must send it as a complete web page.
//Make sure you don’t have any relative links or relative image paths otherwise they will not work.
//(text or html)
$config['mailtype'] = 'html';

//Character set (utf-8, iso-8859-1, etc.).
$config['charset'] = 'utf-8';

//Whether to validate the email address true or false
$config['validate'] = false;

//Email Priority. 1 = highest. 5 = lowest. 3 = normal.
$config['priority'] = 3;

//Newline character. (Use “\r\n” to comply with RFC 822).
//“\r\n” or “\n” or “\r”
$config['crlf'] = "\r\n";

//Newline character. (Use “\r\n” to comply with RFC 822).
//“\r\n” or “\n” or “\r”
$config['newline'] = "\r\n";

//Enable BCC Batch Mode. (true or false)
$config['bcc_batch_mode'] = false;

//Number of emails in each BCC batch.
$config['bcc_batch_size'] = 200;

//Enable notify message from server (true or false)
$config['dsn'] = false;

//Email interception false | mail
$config['email_interception'] = '<##DEVELOPER_MAIL##>';

//Email store instead of send (for tests)
$config['email_store'] = <##EMAIL_STORE##>;
$config['email_store_dir'] = 'tests/_emails/';

//Email bcc false | mail
$config['email_bcc']  = false;
