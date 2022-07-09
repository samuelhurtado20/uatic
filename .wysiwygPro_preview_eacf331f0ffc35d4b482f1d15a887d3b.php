<?php
if ($_GET['randomId'] != "Qfz8mO_1EFQnNWyn7Q53WoK69ANhbrUFUkhBdP_RkddXhCMyZeX5vkTqBS8TUkCN") {
    echo "Access Denied";
    exit();
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
