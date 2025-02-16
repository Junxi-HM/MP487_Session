<?php
session_start();
if (!isset($_SESSION['array'])) {
    $_SESSION['array'] = [10,20,30];
}
$average = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $position = intval($_POST['position']);
    $value = intval($_POST['value']);
    $action = $_POST['action'];

    if ($action == 'Modify') {
        $_SESSION['array'][$position] = $value;
    }

    if ($action == 'Average' ) {
        $average = array_sum($_SESSION['array']) / count($_SESSION['array']);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Array Session</title>
</head>
<body>
    <h1>Modify array saved in session</h1>
    
    <form method="post">
        Position to modify:
        <select name="position" required>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
        </select><br><br>
        <label for="value">New value:</label>
        <input type="number" id="value" name="value">
        <br><br>
        <input type="submit" name="action" value="Modify">
        <input type="submit" name="action" value="Average">
        <input type="reset" name="action" value="Reset">
    </form><br>

    <?php 
    echo "Current array: " . implode(', ', $_SESSION['array']);
    echo "<br> <br>";
    if ($average !== null){
        echo "Average:" . number_format($average, 2);
    }
    ?>

</body>
</html>