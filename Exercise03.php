<?php
session_start();

if (!isset($_SESSION['list'])) {
    $_SESSION['list'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = '';
    $quantity = 0;
    $price = 0;
    $cost = $price * $quantity;
    $totalValue = 0;

    if (isset($_POST['add'])) {
        $name = trim($_POST['name']);
        $quantity = intval($_POST['quantity']);
        $price = floatval($_POST['price']);
        $cost = $price * $quantity;
       if (empty($name)) {
            echo "<p style='color: red;'>Error: Item name cannot be empty</p>";
        } elseif (isset($_SESSION['list'][$name])) {
            echo "<p style='color: red;'>Error: Item already exists</p>";
        } else {
            $_SESSION['list'][$name] = ['quantity' => $quantity, 'price' => $price, 'cost' => $cost];
            echo "<p style='color: green;'>Item added successfully</p>";
            $totalValue = array_sum(array_column($_SESSION['list'], 'cost'));
        }
    }

    if (isset($_POST['update'])) {
        $name = trim($_POST['name']);
        $quantity = intval($_POST['quantity']);
        $price = floatval($_POST['price']);
        $cost = $price * $quantity;
        if(isset($_SESSION['list'][$name])){
            $_SESSION['list'][$name] = ['quantity' => $quantity, 'price' => $price, 'cost' => $cost];
            echo "<p style='color: green;'> Item update properly </p>";
        }else{
            echo "<p style='color: red;'>Error: Item doesn't exists</p>";
        }
    }

    if (isset($_POST['edit'])) {
        $name = trim($_POST['name']);
        $quantity = intval($_POST['quantity']);
        $price = floatval($_POST['price']);

        $editName = $_POST['name'];
        $editQuantity = $_SESSION['list'][$editName]['quantity'];
        $editPrice = $_SESSION['list'][$editName]['price'];
    }

    if (isset($_POST['delete'])) {
        $itemName = $_POST['name'];
        if (isset($_SESSION['list'][$itemName])) {
            unset($_SESSION['list'][$itemName]);
            echo "<p style='color: green;'> Item delete properly </p>";
        }
    }
    
    if (isset($_POST['total'])) {
        $totalValue = array_sum(array_column($_SESSION['list'], 'cost'));
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping List</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
        }
        input[type=submit] {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Shopping List</h1>
    <form method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>">
        <br>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
        <br>
        <label for="price">Price:</label>
        <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($price); ?>">
        <br>
        <input type="submit" name="add" value="Add">
        <input type="submit" name="update" value="Update">
        <input type="submit" name="reset" value="Reset">
    </form>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Cost</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['list'] as $name => $item) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($name); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($item['price']); ?></td>
                    <td><?php echo htmlspecialchars($item['cost']); ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars($name); ?>">
                            <input type="hidden" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>">
                            <input type="hidden" name="price" value="<?php echo htmlspecialchars($item['price']); ?>">
                            <input type="submit" name="edit" value="Edit">
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td><?php echo htmlspecialchars($totalValue); ?></td>
                <td>
                    <form method="post">
                        <input type="submit" name="total" value="Calculate Total">
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>