<?php
// Initialize the session
session_start();
$page_title = "Update User";

$modified = false;

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "../config/db_config.php";
// Define variables and initialize with empty values
$firstname     = $lastname     = $email     = $linkedin     = $github     = $avatar     = "";
$firstname_err = $lastname_err = $email_err = $linkedin_err = $github_err = $avatar_err = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_SESSION["id"];

    $request = "SELECT * FROM students WHERE id = $id;";

    $result      = mysqli_query($link, $request);
    $resultCheck = mysqli_num_rows($result);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $firstname = $row['firstname'];
            $lastname  = $row['lastname'];
            $email     = $row['email'];
            $linkedin  = $row['linkedin'];
            $github    = $row['github'];
            $avatar    = $row['avatar'];

        }
    } else {
        echo "0 results";
    }
    mysqli_close($link);

}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];
    $email     = $_POST['email'];
    $linkedin  = $_POST['linkedin'];
    $github    = $_POST['github'];
    $avatar    = $_POST['avatar'];

    // Validate firstname
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = "Please enter a firstname.";
    } else {
        $firstname = htmlspecialchars($_POST["firstname"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
            $firstname_err = "Only letters and white space allowed";
        }
    }

// Validate lastname
    if (empty(trim($_POST["lastname"]))) {
        $lastname_err = "Please enter a lastname.";
    } else {
        $lastname = htmlspecialchars($_POST["lastname"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
            $lastname_err = "Only letters and white space allowed";
        }
    }

// Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter a email.";
    } else {
        $email = htmlspecialchars($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        }
    }

    // Check input errors before updating the database
    if (empty($new_password_err) && empty($confirm_password_err)) {
        // Prepare an update statement
        $sql = "UPDATE students SET firstname = ?, lastname = ?, email = ?, github = ?, linkedin = ?, avatar = ? WHERE id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_firstname, $param_lastname, $param_email, $param_github, $param_linkedin, $param_avatar, $param_id);

            // Set parameters
            $param_id        = $_SESSION["id"];
            $param_firstname = $_POST['firstname'];
            $param_lastname  = $_POST['lastname'];
            $param_email     = $_POST['email'];
            $param_github    = $_POST['github'];
            $param_linkedin  = $_POST['linkedin'];
            $param_avatar    = $_POST['avatar'];
            // Attempt to execute the prepared statement

            if (mysqli_stmt_execute($stmt)) {
                // Password updated successfully. Destroy the session, and redirect to login page
                // Close statement
                $modified              = true;
                $_SESSION['firstname'] = $_POST['firstname'];
                mysqli_stmt_close($stmt);

            } else {
                echo "Something's wrong with the query: " . mysqli_error($link);

            }
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<?php include '../components/header.php'?>

<body>
    <?php include '../components/navbar.php'?>

    <div class="container">
        <div class="row mt-4 p-3">
            <div class="col shadow p-3 mb-5 bg-white rounded">
                <h2>Change User informations</h2>
                <p>Please use this form to modify your user's informations</p>
                <?php if ($modified): ?>
                <p>Your informations have been modified. <a class="btn-link" href="../index.php">Return to home page</a>
                </p>
                <?php else: ?>
                <div class="d-flex justify-content-center">
                    <a href="reset-password.php" class="btn btn-lg btn-outline-warning mb-4">Reset Your Password</a>
                </div>
                <div class="d-flex justify-content-center">
                    <a href="delete_account.php" class="btn btn-sm btn-outline-danger mb-4">Delete your account</a>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                        <label>First Name :</label>
                        <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                        <span class="help-block"><?php echo $firstname_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                        <label>Last Name :</label>
                        <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                        <span class="help-block"><?php echo $lastname_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <label>Email :</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                        <span class="help-block"><?php echo $email_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($github_err)) ? 'has-error' : ''; ?>">
                        <label>Github url: </label>
                        <input type="text" name="github" class="form-control" value="<?php echo $github; ?>">
                        <span class="help-block"><?php echo $github_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($linkedin_err)) ? 'has-error' : ''; ?>">
                        <label>LinkedIn url: </label>
                        <input type="text" name="linkedin" class="form-control" value="<?php echo $linkedin; ?>">
                        <span class="help-block"><?php echo $linkedin_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($avatar_err)) ? 'has-error' : ''; ?>">
                        <label>Avatar :</label>
                        <input type="text" name="avatar" class="form-control" value="<?php echo $avatar; ?>">
                        <span class="help-block"><?php echo $avatar_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a class="btn btn-link" href="../index.php">Cancel</a>
                    </div>
                </form>
                <?php endif;?>
            </div>
        </div>
    </div>
    <?php include '../components/footer.php'?>