<?php

class Message
{
    public static function set($message) {
        $_SESSION['confirmMsg'] = $message;
    }

    public static function check()
    {
        $confirmMsg = $_SESSION['confirmMsg'] ?? null;
        
        if ($confirmMsg) {
            self::print($confirmMsg);
            $_SESSION['confirmMsg'] = null;
        }
    }

    public static function print($text)
    {
        $html = <<< HTML
                <div class="my-2 alert alert-success message message-animation">
                    <h4>$text</h4>
                </div>
                HTML;
        echo $html;
    }

    public static function printError($message = 'Något gick snett! Försök igen.')
    {
        $html = <<< HTML
                <div class="my-2 alert alert-danger message message-animation">
                    <h4>$message</h4>
                </div>
                HTML;
        echo $html;
    }
}

?>