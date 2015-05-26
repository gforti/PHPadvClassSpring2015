<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>password_hash</h2>
        <?php
        
        $password = 'myPass';
        echo password_hash($password, PASSWORD_DEFAULT), '<br />';
        echo password_hash($password, PASSWORD_DEFAULT), '<br />';
        echo password_hash($password, PASSWORD_DEFAULT), '<br />';
        
        echo '<h2>sha1 hash</h2>';
        
        echo sha1($password), '<br />';
        echo sha1($password), '<br />';
        
        ?>
        
        
    </body>
</html>
