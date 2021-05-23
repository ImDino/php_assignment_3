<?php

class Message
{
    public static function set($message) {
        $_SESSION['confirmMsg'] = $message;
    }

    public static function check()
    {
        if ($_SESSION['confirmMsg']) {
            self::print($_SESSION['confirmMsg']);
            $_SESSION['confirmMsg'] = null;
        }
    }

    public static function print($text)
    {
        $html = <<< HTML
                <div class="my-2 alert alert-success message message-animation">
                    <span>$text</span>
                </div>
                HTML;
        echo $html;
    }

    public static function printError($message = 'Något gick snett! Försök igen.')
    {
        $html = <<< HTML
                <div class="my-2 alert alert-danger message message-animation">
                    <span>$message</span>
                </div>
                HTML;
        echo $html;
    }
}

?>