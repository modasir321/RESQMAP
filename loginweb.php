<?php header('Content-Type: text/html; charset=utf-8'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        // Registration logic
        $reg_username = $_POST['username'];
        $reg_password = $_POST['password'];
        $reg_first_name = $_POST['first_name'];
        $reg_last_name = $_POST['username'];
        $reg_email = $_POST['email'];
        $conn = new mysqli("localhost", "root", "", "user");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT * FROM users1 WHERE username = '$reg_username'";
        $result = $conn->query($query);

        if ($result->num_rows < 1) {
            $insertQuery = "INSERT INTO users1 (username, password, first_name, last_name, email) VALUES (?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);

            if (!$insertStmt) {
                die("Error: " . $conn->error);
            }

            $insertStmt->bind_param("sssss", $reg_username, $reg_password, $reg_first_name, $reg_last_name, $reg_email);

            if ($insertStmt->execute()) {
                echo "Registration successful. Welcome!$username";
                header("Location: HOME.html?username=$username"); // Redirect to welcome page
                exit();
            } else {
                echo "Error: " . $insertStmt->error;
            }
        } else {
            echo "Account with this username already exists.";
        }

        $conn->close();
    } elseif (isset($_POST['login'])) {
        // Login logic
        $username = $_POST['username'];
        $password = $_POST['password'];
        $conn = new mysqli("localhost", "root", "", "user");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT * FROM users1 WHERE username = '$username'";
        $login_result = $conn->query($query);

        if ($login_result->num_rows < 1) {
            echo "Incorrect username and password.";
        } else {
            header("Location: HOME.html?username=$username");
            exit();
        }

        $conn->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="loginweb.css">
    <title>RESQMAP Login & Registration</title>
</head>

<body>
    <script>
        $(document).ready(function() {

            var controller = new ScrollMagic.Controller();


            var fadeInUpTimeline = gsap.timeline();
            fadeInUpTimeline.from(".login-container", {
                opacity: 0,
                y: 50,
                duration: 1
            });


            var scene = new ScrollMagic.Scene({
                    triggerElement: ".login-container",
                    triggerHook: 0.8,
                    reverse: false,
                    offset: 0,
                    duration: 0
                })
                .setTween(fadeInUpTimeline)
                .addTo(controller);
        });
    </script>



    <div class="hero">
        <div class="navbar">

            <img src="MAIN.png" class="logo" style="height: 100px;width: 150px;">
        </div>
        <ul class="navbar">
            <li><a href="HOME.html"> HOME </a></li>
            <li><a href="AREA FIELD CALCULATOR.html"> AREA FIELD CALCULATOR </a></li>
            <li><a href="nearest.html"> EMERGENCY SERVICE </a></li>
            <li><a href="loginweb.php"> CONTACT US </a></li>
        </ul>
        <div class="wrapper">
            <div class="form-box">
                <div class="login-container" id="login">

                    <form id="loginForm" method="post" action="">
                        <div class="top">
                            <span style="color: aliceblue;">Don't have an account? <a href="#" onclick="register()">Sign Up</a></span>
                            <header>Login</header>
                        </div>
                        <div class="input-box">
                            <input type="text" class="input-field" name="loginUsername" placeholder="Username or Email">
                            <i class="bx bx-user"></i>
                        </div>
                        <div class="input-box">
                            <input type="password" class="input-field" name="loginPassword" placeholder="Password">
                            <i class="bx bx-lock-alt"></i>
                        </div>
                        <div class="input-box">
                            <input type="submit" class="submit" name="login" value="Sign In">
                        </div>
                        <div class="two-col">
                            <div class="one">
                                <input type="checkbox" id="login-check">
                                <label for="login-check"> Remember Me</label>
                            </div>
                            <div class="two">
                                <label><a href="#">Forgot password?</a></label>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="register-container" id="register">

                    <form id="registerForm" method="post" action="">
                        <div class="top">
                            <span style="color: aliceblue;">Have an account? <a href="#" onclick="login()">Login</a></span>
                            <header>Sign Up</header>
                        </div>
                        <div class="two-forms">
                            <div class="input-box">
                                <input type="text" class="input-field" name="registerName" placeholder="Name">
                                <i class="bx bx-user"></i>
                            </div>
                            <div class="input-box">
                                <input type="text" class="input-field" name="registerUsername" placeholder="Username">
                                <i class="bx bx-user"></i>
                            </div>
                        </div>
                        <div class="input-box">
                            <input type="text" class="input-field" name="registerEmail" placeholder="Email">
                            <i class="bx bx-envelope"></i>
                        </div>
                        <div class="input-box">
                            <input type="password" class="input-field" name="registerPassword" placeholder="Password">
                            <i class="bx bx-lock-alt"></i>
                        </div>
                        <div class="input-box">
                            <input type="submit" class="submit" name="register" value="Register">
                        </div>
                        <div class="two-col">
                            <div class="one">
                                <input type="checkbox" id="register-check">
                                <label for="register-check"> Remember Me</label>
                            </div>
                            <div class="two">
                                <label><a href="#">Terms & conditions</a></label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</body>
<script>
    var a = document.getElementById("loginBtn");
    var b = document.getElementById("registerBtn");
    var x = document.getElementById("login");
    var y = document.getElementById("register");

    function login() {
        x.style.left = "4px";
        y.style.right = "-520px";
        a.className += " white-btn";
        b.className = "btn";
        x.style.opacity = 1;
        y.style.opacity = 0;
    }

    function register() {
        x.style.left = "-510px";
        y.style.right = "5px";
        a.className = "btn";
        b.className += " white-btn";
        x.style.opacity = 0;
        y.style.opacity = 1;
    }
</script>


</html>