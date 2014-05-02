<?php
require 'core/init.php';
$obj_general->logged_in_protect();

# if form is submitted
if (isset($_POST['submit'])) {

    if (empty($_POST['first_name']) || empty($_POST['email']) || empty($_POST['password'])) {
        $str_errors[] = 'All fields are required.';
    } else {

        #validating user's input with functions that we will create next
        if (strlen($_POST['password']) < 6) {
            $str_errors[] = 'Your password must be at least 6 characters';
        } else if (strlen($_POST['password']) > 18) {
            $str_errors[] = 'Your password cannot be more than 18 characters long';
        }
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $str_errors[] = 'Please enter a valid email address';
        } else if ($obj_users->email_exists($_POST['email']) === true) {
            $str_errors[] = 'That email already exists.';
        }
    }

    if (empty($str_errors) === true) {
        $str_first_name = htmlentities($_POST['first_name']);
        $str_last_name = htmlentities($_POST['last_name']);
        $str_password = $_POST['password'];
        $str_email = htmlentities($_POST['email']);

        $obj_users->register($str_first_name, $str_last_name, $str_password, $str_email);
        header('Location: sign_up.php?success');
        exit();
    }
}

if (isset($_GET['success']) && empty($_GET['success'])) {
    $str_notice = 'Thank you for registering. Please check your email.';
    header('Location: login.php');
    exit();
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
<section id="signup-container">
    <div class="section-overlay"></div>
    <div class="signup-panel">
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
                        <h4>Sign up</h4>
                    </div>
                    <div class="col-md-12">
                        <input type="text" name="first_name" placeholder="First Name"/>
                    </div>
                    <div class="col-md-12">
                        <input type="text" name="last_name" placeholder="Last Name"/>
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
                                <input type="checkbox" checked disabled> I agree to the Terms of Use and Privacy Policy.
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 text-left mt20">
                        <input type="submit" name="submit" class="btn btn-primary signup-btn" value="Sign up"/>
                    </div>
                </form>
                <div class="col-md-12 text-left mt10">
                    <a href="login.php"><h5>Login!</h5></a>
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
