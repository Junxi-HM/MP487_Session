<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $_SESSION['name'] = $_POST['name'];
    $name = $_SESSION['name'];
}

if (!isset($_POST['name'])) {
    $_SESSION['name'] = '';
}

if (!isset($_SESSION['inventary'])) {
    $_SESSION['inventary'] = ['milk' => 0, 'soft drink' => 0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $product = $_POST['product'];
    $quantity = intval($_POST['quantity']);
    $action = $_POST['action'];

    if ($action == 'Add' && $quantity > 0) {
        $_SESSION['inventary'][$product] += $quantity;
    }

    if ($action == 'Remove' && $quantity >0 ) {
        if ($_SESSION['inventary'][$product] >= $quantity) {
            $_SESSION['inventary'][$product] -= $quantity;
        } else {
            echo "Error: Not enough units available";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Management</title>
</head>
<body>
    <h1>Supermarket management</h1>
    
    <form method="post">
        <label for="name">Worker name:</label>
        <input type="text" id="name" name="name" required><br>
        <h2>Choose product:</h2>
        <select name="product" required>
                <option value="milk">Milk</option>
                <option value="soft drink">Soft_drink</option>
        </select><br>

        <h3>Product quality:</h3>
        <input type="number" name="quantity" min="1"><br>

        <input type="submit" name="action" value="Add">
        <input type="submit" name="action" value="Remove">
        <input type="reset" name="action" value="Reset">
    </form>

    <h4>Inventary:</h4>
    <?php 
    echo "worker: " . $_SESSION['name'] . "<br>";
    foreach ($_SESSION['inventary'] as $key => $value) {
        echo $key . ": " . $value . "<br>";
    } 
    ?>


</body>
</html>