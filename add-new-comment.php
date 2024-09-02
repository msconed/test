<?php
require __DIR__."/tests.php";



if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if (!empty($_POST['_token']) and !empty($_SESSION['_token'])) {
        if (hash_equals($_SESSION['_token'], $_POST['_token'])) {
                if(!empty($_POST["new_comment"]) and strlen($_POST["new_comment"]) > 0)
                {
                    $text = htmlspecialchars($_POST["new_comment"]);
                    Database::addComment($text);
                } else { 
                    $_SESSION['errorMessage'] = "<script>alert(\"Нужно написать сообщение...\")</script>";     
                }
        }
    }    
}
Misc::goHome();