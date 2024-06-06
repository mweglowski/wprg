<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Table Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "MyDatabase";

try {
    // ESTABLISH CONNECTION
    $pdo = new PDO("mysql:host=$serverName", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // CREATE DB IF NOT EXISTS
    $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
    $pdo->exec($sql);

    // CONNECT TO DB
    $pdo = new PDO("mysql:host=$serverName;dbname=$dbName", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // CREATE PERSON TABLE IF NOT EXISTS
    $sql = "CREATE TABLE IF NOT EXISTS Person (
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(255) NOT NULL,
        lastName VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL
    )";
    $pdo->exec($sql);

    // CREATE CARS TABLE IF NOT EXISTS
    $sql = "CREATE TABLE IF NOT EXISTS Cars (
        id INT AUTO_INCREMENT PRIMARY KEY,
        model VARCHAR(255) NOT NULL,
        price FLOAT NOT NULL,
        purchaseDate DATE NOT NULL,
        personID INT,
        FOREIGN KEY (personID) REFERENCES Person(id) ON DELETE CASCADE
    )";
    $pdo->exec($sql);

    // HANDLE ADD, EDIT, DELETE PERSON
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'add_person') {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];

            $sql = "INSERT INTO Person (firstName, lastName, email) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$firstname, $lastname, $email]);
        } elseif (isset($_POST['action']) && $_POST['action'] === 'delete_person') {
            $id = $_POST['id'];

            try {
                $sql = "DELETE FROM Person WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);
            } catch (PDOException $e) {
                echo "Error deleting data: " . $e->getMessage();
            }
        } elseif (isset($_POST['action']) && $_POST['action'] === 'edit_person') {
            $id = $_POST['id'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];

            try {
                $sql = "UPDATE Person SET firstName = ?, lastName = ?, email = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$firstname, $lastname, $email, $id]);
            } catch (PDOException $e) {
                echo "Error updating data: " . $e->getMessage();
            }
        }
    }

    // HANDLE ADD, EDIT, DELETE CAR
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'add_car') {
            $model = $_POST['model'];
            $price = $_POST['price'];
            $purchaseDate = $_POST['purchase_date'];
            $personID = $_POST['person_id'];

            $sql = "INSERT INTO Cars (model, price, purchaseDate, personID) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$model, $price, $purchaseDate, $personID]);
        } elseif (isset($_POST['action']) && $_POST['action'] === 'delete_car') {
            $id = $_POST['id'];

            try {
                $sql = "DELETE FROM Cars WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);
            } catch (PDOException $e) {
                echo "Error deleting data: " . $e->getMessage();
            }
        } elseif (isset($_POST['action']) && $_POST['action'] === 'edit_car') {
            $id = $_POST['id'];
            $model = $_POST['model'];
            $price = $_POST['price'];
            $purchaseDate = $_POST['purchase_date'];
            $personID = $_POST['person_id'];

            try {
                $sql = "UPDATE Cars SET model = ?, price = ?, purchaseDate = ?, personID = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$model, $price, $purchaseDate, $personID, $id]);
            } catch (PDOException $e) {
                echo "Error updating data: " . $e->getMessage();
            }
        }
    }

    // FETCH PERSONS WITH SORTING AND FILTERING
    $orderBy = isset($_POST['sort_field']) ? $_POST['sort_field'] : 'id';
    $sortOrder = isset($_POST['sort_order']) ? $_POST['sort_order'] : 'ASC';
    $filterField = isset($_POST['filter_field']) ? $_POST['filter_field'] : '';
    $filterValue = isset($_POST['filter_value']) ? $_POST['filter_value'] : '';

    $personQuery = "SELECT * FROM Person";
    if ($filterField && $filterValue) {
        $personQuery .= " WHERE $filterField LIKE :filter_value";
    }
    $personQuery .= " ORDER BY $orderBy $sortOrder";
    $stmt = $pdo->prepare($personQuery);
    if ($filterField && $filterValue) {
        $stmt->bindValue(':filter_value', '%' . $filterValue . '%');
    }
    $stmt->execute();
    $persons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // FETCH CARS WITH SORTING AND FILTERING
    $carOrderBy = isset($_POST['car_sort_field']) ? $_POST['car_sort_field'] : 'id';
    $carSortOrder = isset($_POST['car_sort_order']) ? $_POST['car_sort_order'] : 'ASC';
    $carFilterField = isset($_POST['car_filter_field']) ? $_POST['car_filter_field'] : '';
    $carFilterValue = isset($_POST['car_filter_value']) ? $_POST['car_filter_value'] : '';

    $carQuery = "SELECT * FROM Cars";
    if ($carFilterField && $carFilterValue) {
        $carQuery .= " WHERE $carFilterField LIKE :car_filter_value";
    }
    $carQuery .= " ORDER BY $carOrderBy $carSortOrder";
    $stmt = $pdo->prepare($carQuery);
    if ($carFilterField && $carFilterValue) {
        $stmt->bindValue(':car_filter_value', '%' . $carFilterValue . '%');
    }
    $stmt->execute();
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!-- Main title -->
<h1>Table Management</h1>

<!-- ADD PERSON FORM -->
<h2>Person</h2>
<form action="index.php" method="post" class="input-form">
    <input type="text" name="firstname" placeholder="First Name" required>
    <input type="text" name="lastname" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit" name="action" value="add_person">Add Person</button>
</form>

<!-- ADD CAR FORM -->
<h2>Car</h2>
<form action="index.php" method="post" class="input-form">
    <input type="text" name="model" placeholder="Model" required>
    <input type="number" name="price" placeholder="Price" required step="0.01">
    <input type="datetime-local" name="purchase_date" placeholder="Purchase Date" required>
    <select name="person_id" required>
        <option value="">Select Person</option>
        <?php foreach ($persons as $person): ?>
            <option value="<?php echo $person['id'] ?>">
                <?php echo htmlspecialchars($person['firstName'] . ' ' . $person['lastName']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit" name="action" value="add_car">Add Car</button>
</form>

<h2>Persons</h2>
<!-- PERSONS SORTING AND FILTERING -->
<div class="sorting-container">
    <form action="index.php" method="post">
        <h3>Sorting</h3>
        <div>
            <h4>Field</h4>
            <select name="sort_field">
                <option value="id">ID</option>
                <option value="firstName">First Name</option>
                <option value="lastName">Last Name</option>
                <option value="email">Email</option>
            </select>
        </div>
        <div>
            <h4>Order</h4>
            <div class="radio-inputs">
                <label>
                    <input type="radio" name="sort_order" value="ASC" class="radio-input" checked>
                    Ascending
                </label>
                <label>
                    <input type="radio" name="sort_order" value="DESC" class="radio-input">
                    Descending
                </label>
            </div>
        </div>
        <div>
            <button type="submit">Sort</button>
        </div>
    </form>

    <form action="index.php" method="post">
        <h3>Filtering</h3>
        <div>
            <h4>Field</h4>
            <select name="filter_field">
                <option value="id">ID</option>
                <option value="firstName">First Name</option>
                <option value="lastName">Last Name</option>
                <option value="email">Email</option>
            </select>
        </div>
        <input type="text" placeholder="Value" name="filter_value"/>
        <div>
            <button type="submit">Filter</button>
        </div>
    </form>
</div>

<!-- PERSONS TABLE PREVIEW -->
<table class="card">
    <thead>
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (isset($persons) && count($persons) > 0): ?>
        <?php foreach ($persons as $person): ?>
            <tr>
                <td><?php echo htmlspecialchars($person['id']); ?></td>
                <td><?php echo htmlspecialchars($person['firstName']); ?></td>
                <td><?php echo htmlspecialchars($person['lastName']); ?></td>
                <td><?php echo htmlspecialchars($person['email']); ?></td>
                <td>
                    <form action="index.php" method="post" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $person['id']; ?>">
                        <input type="hidden" name="firstname" value="<?php echo $person['firstName']; ?>">
                        <input type="hidden" name="lastname" value="<?php echo $person['lastName']; ?>">
                        <input type="hidden" name="email" value="<?php echo $person['email']; ?>">
                        <button type="submit" name="action" value="show_edit_person_form">Edit</button>
                    </form>
                    <form action="index.php" method="post" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $person['id']; ?>">
                        <button type="submit" name="action" value="delete_person">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No persons found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<!-- CARS TABLE PREVIEW -->
<h2>Cars</h2>
<div class="sorting-container">
    <form action="index.php" method="post">
        <h3>Sorting</h3>
        <div>
            <h4>Field</h4>
            <select name="car_sort_field">
                <option value="id">ID</option>
                <option value="model">Model</option>
                <option value="price">Price</option>
                <option value="purchaseDate">Purchase Date</option>
                <option value="personID">Person ID</option>
            </select>
        </div>
        <div>
            <h4>Order</h4>
            <div class="radio-inputs">
                <label>
                    <input type="radio" name="car_sort_order" value="ASC" class="radio-input" checked>
                    Ascending
                </label>
                <label>
                    <input type="radio" name="car_sort_order" value="DESC" class="radio-input">
                    Descending
                </label>
            </div>
        </div>
        <div>
            <button type="submit">Sort</button>
        </div>
    </form>

    <form action="index.php" method="post">
        <h3>Filtering</h3>
        <div>
            <h4>Field</h4>
            <select name="car_filter_field">
                <option value="id">ID</option>
                <option value="model">Model</option>
                <option value="price">Price</option>
                <option value="purchaseDate">Purchase Date</option>
                <option value="personID">Person ID</option>
            </select>
        </div>
        <input type="text" placeholder="Value" name="car_filter_value"/>
        <div>
            <button type="submit">Filter</button>
        </div>
    </form>
</div>

<table class="card">
    <thead>
    <tr>
        <th>ID</th>
        <th>Model</th>
        <th>Price</th>
        <th>Purchase Date</th>
        <th>Person ID</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (isset($cars) && count($cars) > 0): ?>
        <?php foreach ($cars as $car): ?>
            <tr>
                <td><?php echo htmlspecialchars($car['id']); ?></td>
                <td><?php echo htmlspecialchars($car['model']); ?></td>
                <td><?php echo htmlspecialchars($car['price']); ?></td>
                <td><?php echo htmlspecialchars($car['purchaseDate']); ?></td>
                <td><?php echo htmlspecialchars($car['personID']); ?></td>
                <td>
                    <form action="index.php" method="post" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $car['id']; ?>">
                        <input type="hidden" name="model" value="<?php echo $car['model']; ?>">
                        <input type="hidden" name="price" value="<?php echo $car['price']; ?>">
                        <input type="hidden" name="purchase_date" value="<?php echo $car['purchaseDate']; ?>">
                        <input type="hidden" name="person_id" value="<?php echo $car['personID']; ?>">
                        <button type="submit" name="action" value="show_edit_car_form">Edit</button>
                    </form>
                    <form action="index.php" method="post" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $car['id']; ?>">
                        <button type="submit" name="action" value="delete_car">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No cars found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<!-- EDIT PERSON FORM -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'show_edit_person_form') {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    ?>
    <h2>Edit Person</h2>
    <form action="index.php" method="post" class="input-form">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="text" name="firstname" placeholder="First Name" value="<?php echo $firstname; ?>" required>
        <input type="text" name="lastname" placeholder="Last Name" value="<?php echo $lastname; ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
        <button type="submit" class="btn btn-primary" name="action" value="edit_person">Update Person</button>
    </form>
<?php } ?>

<!-- EDIT CAR FORM -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'show_edit_car_form') {
    $id = $_POST['id'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $purchaseDate = $_POST['purchase_date'];
    $personID = $_POST['person_id'];
    ?>
    <h2>Edit Car</h2>
    <form action="index.php" method="post" class="input-form">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="text" name="model" placeholder="Model" value="<?php echo $model; ?>" required>
        <input type="number" name="price" placeholder="Price" value="<?php echo $price; ?>" required step="0.01">
        <input type="datetime-local" name="purchase_date" placeholder="Purchase Date" value="<?php echo $purchaseDate; ?>" required>
        <select name="person_id" required>
            <option value="">Select Person</option>
            <?php foreach ($persons as $person): ?>
                <option value="<?php echo $person['id']; ?>" <?php echo $person['id'] == $personID ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($person['firstName'] . ' ' . $person['lastName']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary" name="action" value="edit_car">Update Car</button>
    </form>
<?php } ?>

</body>
</html>
