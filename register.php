<?php
    require_once('./db/config.php');
    require_once('./includes/header.inc.php') ; 

    $username = $password = $confirm_password = '';
    $username_err = $password_err = $confirm_password_err = '';

    if($_SERVER["REQUEST_METHOD"] == 'POST'){
        if(empty(trim($_POST['username']))){
            $username_err = 'Please enter a username';
        }else{
            $sql = 'SELECT id FROM users WHERE username = :username';
            if($stmt = $pdo->prepare($sql)){
                $stmt->bindParam(':username',$param_username,PDO::PARAM_STR);
                $param_username = trim($POST['username']);

                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                        $username_err = 'This username is already taken';
                    }else{
                        $username = trim($_POST['username']);
                    }
                }else{
                    echo 'Oops! Something went wrong. please try again.';
                }
            }

            unset($stmt);
        }

        if(empty(trim($_POST['password']))){
            $password_err = 'Please enter a password';
        }elseif(strlen(trim($_POST['password'])) < 6){
            $password_err = 'Password must have atleast 6 characters';
        }else{
            $password = trim($_POST['password']);
        }
    }
?>
Register Form

<?php require_once('./includes/footer.inc.php') ;