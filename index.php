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
    <div class="background">
        <div class="water"></div>
    </div>
    <svg>
        <filter id="turbulence" x="0" y="0" width="100%" height="100%">
            <feTurbulence id="sea-filter" numOctaves="3" seed="2" baseFrequency="0.02 0.05"></feTurbulence>
            <feDisplacementMap scale="20" in="SourceGraphic"></feDisplacementMap>
            <animate xlink:href="#sea-filter" attributeName="baseFrequency" dur="60s" keyTimes="0;0.5;1"
                values="0.02 0.06;0.04 0.08;0.02 0.06" repeatCount="indefinite" />
        </filter>
    </svg>
    <div class="container fixbeach">
        <div class="alert alert-info shadow" role="alert">
            <h1>Hi,<b><?php echo htmlspecialchars(!empty($_SESSION['firstname'])) ? ($_SESSION["firstname"]) : ($_SESSION["username"]); ?></b>.
                did you know that :</h1>
            <p id="joke" class="lead">
            </p>
            <div class="d-flex justify-content-center">
                <button id="newJoke" class="btn aqua-gradient waves-effect">Learn something else</button>
            </div>
        </div>
        <?php if (empty($_SESSION['firstname'])): ?>
        <div class="alert alert-warning mt-3 shadow" role="alert">
            <p class="text-center">You havent completed your profile. please <a class="btn-link"
                    href="/user_reg/auth/account.php">click here</a> to update your informations
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