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
            
            if ( $util->isPostRequest() ) {
                $db = new DB($dbConfig); 
                $model = new SignupModel();
                $signupDao = new SignupDAO($db->getDB(), $model);            

                $model->map(filter_input_array(INPUT_POST));
                                
                if ( $signupDao->login($model) ) {
                    echo '<h2>Login Sucess</h2>';
                    $util->setLoggedin(true);
                    $util->redirect('is-logged-in.php');
                } else {
                    echo '<h2>Login Failed</h2>';
                }
            }
        ?>
        
         <h1>Login</h1>
        <form action="#" method="POST">
            
            Email : <input type="email" name="email" value="" /> <br />
            Password : <input type="password" name="password" value="" /> <br /> 
            <br />
            <input type="submit" value="Signup" />
            
        </form>
    </body>
</html>
