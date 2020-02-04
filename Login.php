<?php
require_once("includes/globalphp.php");
// Connects to your Database
$mysql_connection = db_open($DATABASE) or die(mysqli_error($mysql_connection));
//Checks if there is a login cookie
if(isset($_COOKIE['ID_my_site']))
//if there is, it logs you in and directes you to the members page
{
    $username = $_COOKIE['ID_my_site'];
    $pass = $_COOKIE['Key_my_site'];
    $check = mysqli_query($mysql_connection,"SELECT * FROM tblusers WHERE username = '$username'")or die(mysqli_error($mysql_connection));
    while($info = mysqli_fetch_array( $check ))
    {
        if ($pass != $info['password'])
        {
            header("Location: Login.php");
        }
        else
        {
            header("Location: Dashboard.php");
        }
    }
}
//if the login form is submitted
if (isset($_POST['submit'])) { // if form has been submitted
// makes sure they filled it in
    if(!$_POST['username'] | !$_POST['pass']) {
        die('You did not fill in a required field.');
    }
// checks it against the database
    if (!get_magic_quotes_gpc()) {
        $_POST['username'] = addslashes($_POST['username']);
    }
    $check = mysqli_query($mysql_connection,"SELECT * FROM tblusers WHERE username = '".$_POST['username']."'")or die(mysqli_error($mysql_connection));
//Gives error if user dosen't exist
    $check2 = mysqli_num_rows($check);
    if ($check2 == 0) {
        die('That user does not exist in our database. <a href=add.php>Click Here to Register</a>');
    }
    while($info = mysqli_fetch_array( $check ))
    {
        $_POST['pass'] = stripslashes($_POST['pass']);
        $info['password'] = stripslashes($info['password']);
        $_POST['pass'] = md5($_POST['pass']);
//gives error if the password is wrong
        if ($_POST['pass'] != $info['password']) {
            die('Incorrect password, please try again.');
        }
        else
        {
// if login is ok then we add a cookie
            $_POST['username'] = stripslashes($_POST['username']);
            $hour = time() + 3600;
            setcookie(ID_my_site, $_POST['username'], $hour);
            setcookie(Key_my_site, $_POST['pass'], $hour);
//then redirect them to the members area
            header("Location: Dashboard.php");
        }
    }
}
else
{
// if they are not logged in
    ?>
</br>
<div class="container-fluid">
    <div class="row">
        <div class="col-4">
        </div>
        <div class="col-4">
            <div class="card text-center">
                <div class="card-header">
                    <h5 class="card-title">Login Page</h5>
                    <p class="card-text">Put the info down below then you will be good to go.</p>
                </div>
                <div class="card-body">
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Username</label>
                                <input type="text" class="form-control" id="exampleInputUsername" placeholder="Username" name="username" maxlength="40">
                            </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1"  name = "pass" placeholder="Password">
                                </div>
                                        <input type="submit" name="submit" class="btn btn-primary" value="Login">

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-4">
        </div>
    </div>
    <?php
}
?>
