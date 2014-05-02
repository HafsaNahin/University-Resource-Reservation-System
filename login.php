<?php
require 'core/init.php';
$obj_general->logged_in_protect();

if (empty($_POST) === false) {
    $str_email = trim($_POST['email']);
    $str_password = trim($_POST['password']);

    if (empty($str_email) === true || empty($str_password) === true) {
        $str_errors[] = 'Sorry, but we need your email and password.';
    } else if ($obj_users->email_exists($str_email) === false) {
        $str_errors[] = 'Sorry that email doesn\'t exists.';
    } else if ($obj_users->email_confirmed($str_email) === false) {
        $str_errors[] = 'Sorry, but you need to activate your account. Please check your email.';
    } else {

        $int_login = $obj_users->login($str_email, $str_password);
        if ($int_login === false) {
            $str_errors[] = 'Sorry, that email/password is invalid';
        } else {

            // email/password is correct and the login method of the $obj_users object returns the user's id, which is stored in $login.
            $_SESSION['id'] = $int_login;

            // The user's id is now set into the user's session in the form of $_SESSION['id']

            # Redirect the user to dashboard.php.
            header('Location: dashboard.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resource Reservation System</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<section id="login-container">
    <div class="section-overlay"></div>
    <div class="login-panel">
        <div class="panel panel-default center-block">
            <div class="panel-body">
                <?php
                # if there are errors, they would be displayed here.
                if (empty($str_errors) === false) {
                    echo '<div class="alert alert-danger">';
                    echo '<p>' . implode('</p><p>', $str_errors) . '</p>';
                    echo '</div>';
                }
                ?>
                <form action="" method="post">
                    <div class="col-md-12 text-left">
                        <h4>Log in</h4>
                    </div>
                    <div class="col-md-12">
                        <input type="text" name="email" placeholder="Email"/>
                    </div>
                    <div class="col-md-12">
                        <input type="password" name="password" placeholder="Password"/>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox text-left">
                            <label>
                                <input type="checkbox"> Remember me on this computer
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 text-left mt20">
                        <input name="submit" type="submit" class="btn btn-primary login-btn" value="Log in"/>
                    </div>
                </form>
                <div class="col-md-12 text-left mt20">
                    <a href="#"><h5>Forgot your password?</h5></a>
                    <a href="sign_up.php"><h5>Sign up!</h5></a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
