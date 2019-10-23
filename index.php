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
            <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. did you know that :</h1>
        </div>
        <h3 id="joke">
        </h3>
    </div>
    <script>
    async function getUserAsync(url) {
        let response = await fetch(url);
        let data = await response.json()
        document . getElementById('joke').innerHTML = data.value;
        console.log(data.value);
        return data;
    }
    let joke = getUserAsync('https://api.chucknorris.io/jokes/random')
    </script>
    <?php include 'components/footer.php'?>