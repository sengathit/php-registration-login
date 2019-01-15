<?php
    session_start();

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
        header('location: login.php');
        exit;
    }

    require_once('./includes/header.inc.php');
?>
<div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    </div>
    <p>
        <a href="resetpassword.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
<?php require_once('./includes/footer.inc.php');