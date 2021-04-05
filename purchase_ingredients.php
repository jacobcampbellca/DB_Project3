<?php 

session_start();

$host = $_SESSION["host"];
$user = $_SESSION["user"];
$password = $_SESSION["password"];

$recipeName = $_POST["recipeName"];

$connect = mysqli_connect($host, $user, $password, $user);
if(!$connect) {
    die("Error Connecting: " . mysqli_connect_error());
}

$getRecipeIngredients = "SELECT Ingredient, Quantity FROM Recipes WHERE RecipeName = \"$recipeName\"";

$executeGetIngredients = mysqli_query($connect, $getRecipeIngredients);
if(!$executeGetIngredients) {
    die("Error executing query: " . mysqli_error($connect));
}

mysqli_query($connect, "START TRANSACTION");

$executeTransaction = true;
while($recipeRow = mysqli_fetch_assoc($executeGetIngredients)) {
    
    $getInventory = "SELECT Ingredient, Quantity FROM Inventory WHERE Ingredient = \"".$recipeRow["Ingredient"]."\"";
    
    $executeGetInventory = mysqli_query($connect, $getInventory);
    if(!$executeGetInventory) {
        die("Error executing query: " . mysqli_error($connect));
    }
    
    $inventoryRow = mysqli_fetch_assoc($executeGetInventory);
    
    if($inventoryRow["Quantity"] >= $recipeRow["Quantity"]) {
        $updateInventory = "UPDATE Inventory SET Quantity = Quantity - ".$recipeRow["Quantity"]." WHERE Ingredient = \"".$recipeRow["Ingredient"]."\"";
        
        $executeUpdate = mysqli_query($connect, $updateInventory);
        if(!$executeUpdate) {
            die("Error Executing Update: " . mysql_error($connect));
        }
    }   
    else {
        $executeTransaction = false;
        break;
    }
}
if(!$executeTransaction) {
    echo "COULD NOT COMPLETE TRANSACTION: one or more items are out of stock<br>";
    mysqli_query($connect, "ROLLBACK");
}
else {
    echo "SUCCESSFUL TRANSACTION!<br>";
    mysqli_query($connect, "COMMIT");
}

?>

<a href = "http://localhost/homepage.html">Back To Homepage</a><br>