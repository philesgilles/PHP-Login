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

    <?php include 'components/navbar.php'?>
    <div class="container">
        <div class="page-header">
            <h1>Hi,
                <b><?php echo htmlspecialchars(!empty($_SESSION['firstname'])) ? ($_SESSION["firstname"]) : ($_SESSION["username"]); ?></b>.
                did you know that :</h1>
            </div>
            <div class="alert alert-info" role="alert">
                <p id="joke" class="lead">
                    </p>
                    <button id="newJoke" class="btn btn-sm aqua-gradient waves-effect">Learn something else</button>
                </div>
            <?php if (empty($_SESSION['firstname'])): ?>
                <div class="alert alert-warning mt-3" role="alert">
                    <p class="text-center">You havent completed your profile. please <a class="btn-link" href="/user_reg/auth/account.php">click here</a> to update your informations
                    </p>
                </div>
            <?php endif;?>
            </div>
            <script>
    getUserAsync = async (url) => {
        let response = await fetch(url);
        let data = await response.json()
        document.getElementById('joke').innerHTML = data.value;
        return data;
    }
    let joke = getUserAsync('https://api.chucknorris.io/jokes/random');

    document.getElementById('newJoke').addEventListener('click', () => {
        getUserAsync('https://api.chucknorris.io/jokes/random');

    })
    </script>
    <?php include 'components/footer.php'?>