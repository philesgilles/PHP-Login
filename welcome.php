<?php
// Initialize the session
session_start();
$page_title = "Home Page";
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: auth/login.php");
    exit;
}
?>

<?php include 'components/header.php'?>

<body>
    <div class="container">
        <div class="page-header">
            <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
        </div>
        <p>
            <a href="auth/update_user.php" class="btn btn-success">Update your informations</a>
            <a href="auth/logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        </p>
    </div>
</body>

</html>