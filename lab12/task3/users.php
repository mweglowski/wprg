<?php
$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "MyDatabase";

try {
    // CONNECT TO DB
    $pdo = new PDO("mysql:host=$serverName;dbname=$dbName", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // FETCH USERS
    $sql = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registered Users</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Registered Users</h1>
<table>
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone Number</th>
        <th>Email</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['firstName']); ?></td>
            <td><?php echo htmlspecialchars($user['lastName']); ?></td>
            <td><?php echo htmlspecialchars($user['phoneNumber']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<form action="register.php" method="post">
    <button type="submit">Back</button>
</form>

</body>
</html>
