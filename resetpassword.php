<?php   
    session_start();

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
        header('location: login.php');
        exit;
    }

    require_once('./db/config.php');

    $new_password = $confirm_password = '';
    $new_password_err = $confirm_password_err = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(empty(trim($_POST['new_password']))){
            $new_password_err = 'Please enter a new password.';
        }elseif(strlen(trim($_POST['new_password'])) < 6){
            $new_password_err = 'Password must be atleast 6 characters long';
        }else{
            $new_password = trim($_POST['new_password']);
        }

        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Please confirm the password.";
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($new_password_err) && ($new_password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
        }

        if(empty($new_password_err) && empty($confirm_password_err)){
            $sql = 'UPDATE users SET password = :password WHERE id = :id';

            if($stmt = $pdo->prepare($sql)){
                $stmt->bindParam(':password',$param_password,PDO::PARAM_STR);
                $stmt->bindParam(':id',$param_id,PDO::PARAM_STR);
                $param_password = password_hash($new_password,PASSWORD_DEFAULT);
                $param_id = $_SESSION['id'];

                if($stmt->execute()){
                    session_destroy();
                    header('location: login.php');
                }else{
                    echo 'Oops! Something went wrong.';
                }
            }
            unset($stmt);
        }
        unset($pdo);
    }
require_once('./includes/header.inc.php');
?>
<div class="wrapper">
    <h1>Hello <?php echo htmlspecialchars($_SESSION['username']) ; ?></h1>
    <h2>Reset Password</h2>
    <p>Please fill out this form to reset your password.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
        <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
            <span class="help-block"><?php echo $new_password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <a class="btn btn-link" href="welcome.php">Cancel</a>
        </div>
    </form>
</div>    
<?php require_once('./includes/footer.inc.php') ;