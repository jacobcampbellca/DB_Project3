<?php 

session_start();

$host = $_SESSION["host"];
$user = $_SESSION["user"];
$password = $_SESSION["password"];

$ingredient = $_POST["ingredient"];
$quantity = $_POST["quantity"];

$connect = mysqli_connect($host, $user, $password, $user);
if (!$connect) {
    die("Could not connect: ".mysqli_connect_error());
}

$existsQuery = "SELECT Ingredient FROM Inventory";

$execute = mysqli_query($connect, $existsQuery);
if(!$execute) {
    echo "Error Executing Query: " . mysqli_error($connect)."<br>";
    echo "<a href = \"http://localhost/homepage.html\">Back To Homepage</a><br>";
    die();
}

$exists = false;
while($row = mysqli_fetch_assoc($execute)) {
    if($row["Ingredient"] === $ingredient) {
        $exists = true;
        break;
    }
}

if(!$exists) {
    $insertIntoInventory = "INSERT INTO Inventory VALUES (\"$ingredient\", $quantity)";
    
    $execute = mysqli_query($connect, $insertIntoInventory);
    if(!$execute) {
        echo "Error Executing Insert: " . mysqli_error($connect)."<br>";
        echo "<a href = \"http://localhost/homepage.html\">Back To Homepage</a><br>";
        die();
    }
}
else {
    $updateInventory = "UPDATE Inventory SET Quantity = Quantity + $quantity WHERE Ingredient = \"$ingredient\"";
    
    $execute = mysqli_query($connect, $updateInventory);
    if(!$execute) {
        echo "Error Executing Update: " . mysqli_error($connect)."<br>";
        echo "<a href = \"http://localhost/homepage.html\">Back To Homepage</a><br>";
        die();
    }
}

echo "SUCCESS!<br>";

?>

<a href = "http://localhost/homepage.html">Back To Homepage</a><br>