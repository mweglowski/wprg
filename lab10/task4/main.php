<?php
session_start();

$usersFile = 'users.txt';

function passwordOk($password) {
    $hasUppercase = false;
    $hasDigit = false;
    $hasSpecialChar = false;
    $specialChars = "!@#$%^&*()-_=+{};:,<.>";

    for ($i = 0; $i < strlen($password); $i++) {
        $char = $password[$i];

        if (ctype_upper($char)) {
            $hasUppercase = true;
        }
        if (ctype_digit($char)) {
            $hasDigit = true;
        }
        if (strpos($specialChars, $char) !== false) {
            $hasSpecialChar = true;
        }
    }

    return $hasUppercase && $hasDigit && $hasSpecialChar && strlen($password) >= 6;
}

function isEmailUnique($email) {
    global $usersFile;
    if (!file_exists($usersFile)) {
        return true;
    }

    $users = file($usersFile, FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        list(, , $storedEmail) = explode(';', $user);
        if ($storedEmail === $email) {
            return false;
        }
    }

    return true;
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: register.php");
    exit();
}

$stage = isset($_GET['action']) ? $_GET['action'] : 'signup';

if (isset($_POST['signup'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!passwordOk($password)) {
        $_SESSION['error'] = "Password should have at least 6 characters, include 1 upper case letter, at least 1 digit and at least 1 special character.";
        header("Location: register.php?action=signup");
        exit();
    }

    if (!isEmailUnique($email)) {
        $_SESSION['error'] = "Email is already registered.";
        header("Location: register.php?action=signup");
        exit();
    }

    $userData = "$firstName;$lastName;$email;$password\n";
    file_put_contents($usersFile, $userData, FILE_APPEND);

    $_SESSION['message'] = "Registration successful. Please log in.";
    header("Location: register.php?action=login");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!file_exists($usersFile)) {
        $_SESSION['error'] = "No users registered. Please sign up first.";
        header("Location: register.php?action=signup");
        exit();
    }

    $users = file($usersFile, FILE_IGNORE_NEW_LINES);
    $loginSuccessful = false;

    foreach ($users as $user) {
        list($storedFirstName, $storedLastName, $storedEmail, $storedPassword) = explode(';', $user);
        if ($storedEmail === $email && $storedPassword === $password) {
            $_SESSION['userLoggedIn'] = true;
            $_SESSION['userEmail'] = $storedEmail;
            header("Location: register.php?action=loggedin");
            exit();
        }
    }

    $_SESSION['error'] = "Wrong email or password.";
    header("Location: register.php?action=login");
    exit();
}

$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$_SESSION['error'] = '';
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$_SESSION['message'] = '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite Language Poll</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php if ($stage == "signup"): ?>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <h1>Sign Up</h1>

    <form method="post">
        <label for="firstName">First Name</label>
        <input type="text" id="firstName" name="firstName" required>

        <label for="lastName">Last Name</label>
        <input type="text" id="lastName" name="lastName" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="signup">Sign Up</button>
    </form>
    <a href="main.php?action=login">Already have an account? Log In</a>

<?php elseif ($stage == "login"): ?>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if (!empty($message)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <h1>Log In</h1>

    <form method="post">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="login">Log In</button>
    </form>
    <a href="main.php?action=signup">Don't have an account? Sign Up</a>

<?php elseif ($stage == "loggedin"): ?>

    <h1>You are logged in.</h1>
    <a href="main.php?action=logout">Log Out</a>

<?php endif; ?>

</body>
</html>
