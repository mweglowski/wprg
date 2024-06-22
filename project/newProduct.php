<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();

if ($role !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $authors = $_POST['authors'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image'];

    $target_dir = "images/";
    $target_file = $target_dir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        $error = "File is not an image.";
        $uploadOk = 0;
    }

    if ($image["size"] > 5000000) {
        $error = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $error = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            $sql = "INSERT INTO products (title, authors, description, price, image) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssds", $title, $authors, $description, $price, $target_file);

            if ($stmt->execute()) {
                $success = "New product created successfully!";
            } else {
                $error = "Error creating product: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Product</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<?php include "navbar.php"; ?>

<img src="./images/sections/create_product.png" alt="New Product Page Image" class="section-image"/>

<?php if (isset($success)) { ?>
    <p style="color: green; text-align: center;"><?php echo $success; ?></p>
<?php } ?>
<?php if (isset($error)) { ?>
    <p style="color: red; text-align: center;"><?php echo $error; ?></p>
<?php } ?>

<!-- New Product Form -->
<div style="text-align: center; margin: 20px;">
    <form method="POST" action="products.php" enctype="multipart/form-data" class="login-form">
        <input class="input" type="text" name="title" placeholder="Title" required />
        <input class="input" type="text" name="authors" placeholder="Authors" required />
        <textarea class="input" name="description" placeholder="Description" required></textarea>
        <input class="input" type="number" name="price" placeholder="Price" step="0.01" required />
        <input class="input" type="file" name="image" placeholder="Image" required />
        <button type="submit" class="button" style="margin: auto; margin-top: 20px;">Create Product</button>
    </form>
</div>

</body>
</html>
