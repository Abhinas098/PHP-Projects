<?php

session_start();

$status = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {

    $server = 'localhost';
    $user = "root";
    $pass = "";
    $database = "applications"; 

    $db = new mysqli($server, $user, $pass, $database);

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $name = $_POST['name'];
    $age = $_POST['age'];
    $number = $_POST['number'];
    $mail = $_POST['mail'];
    $jobs = $_POST['jobs'];

    $sql = "INSERT INTO `candidates` (`name`, `age`, `number`, `mail`, `jobs`, `dt`) VALUES ('$name', '$age', '$number', '$mail', '$jobs', current_timestamp())";

    if ($db->query($sql) === true) {
        $status = true;

        $_SESSION['success'] = true;

        header("Location: index.php");
        exit();
    } else {
        $status = false;
        echo "err: $sql <br>" . $db->error;
    }
    session_unset();
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h2>
            <center>Application form</center>
        </h2>
        <br />
        <form action="index.php" method="post">
            <input type="text" name="name" id="name" placeholder="Enter Your name" required/>
            <input type="number" name="age" id="age" placeholder="Enter Age" required/>
            <input type="number" name="number" id="number" placeholder="Enter Mobile No." required/>
            <input type="email" name="mail" id="email" placeholder="Enter your Email" required/>
            <select name="jobs" >
                <option>Junior Frontend Developer</option>
                <option>Senior Frontend Developer</option>
                <option>Full-Stack Developer</option>
                <option>Senior Full-Stack Developer</option>
            </select>
            <input type="submit" id="btn" value="Apply" />
            <?php
            // Check if the session variable is set and true
            if (isset($_SESSION['success']) && $_SESSION['success']) {
                echo '<p id="success-message">Applied Contact You soon !</p>';
                unset($_SESSION['success']);
            }
            ?>
        </form>
    </div>

    <script>

        var success = document.getElementById('success-message');

        if (success) {
            document.addEventListener('input', function () {
                success.style.display = 'none'
            })

            setTimeout(() => {
                success.style.display = 'none'
            }, 2000)
        }

    </script>
    </div>
</body>

</html>