<?php include './bootstrap.php'; ?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $util = new Util();
            if ( !$util->isLoggedin() ) {
                // redirect to login page
                echo '<h2>Not logged in</h2>';
            } else {
                echo '<h2>Logged in</h2>';
            }
        
        ?>
        
        <p><a href="?logout">Logout</a></p>
    </body>
</html>
