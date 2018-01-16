<?php
if (!empty($this->fetch('messages'))) :
    $time = 4000;
    foreach ($this->fetch('messages') as $message) :
        echo $this->block(
            $message['template'],
            [
                'title' => $message['title'],
                'message' => $message['message'],
                'time' => $time
            ]
        );
        $time += 4000;
    endforeach;
endif;
