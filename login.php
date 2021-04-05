<?php

session_start();

$_SESSION["host"] = $_POST["host"];
$_SESSION["user"] = $_POST["user"];
$_SESSION["password"] = $_POST["password"];

$host = $_SESSION["host"];
$user = $_SESSION["user"];
$password = $_SESSION["password"];

$conn = mysqli_connect($host, $user, $password, $user);
if (!$conn) {
    echo "Could not connect: ".mysqli_connect_error()."<br>";
    echo "<a href = \"http://localhost/login.html\">Back To Login</a><br>";
    die();
}
    
    
$createRecipes = "CREATE TABLE IF NOT EXISTS Recipes (".
                 " RecipeName varchar(40) NOT NULL,".
                 " Ingredient varchar(40) NOT NULL,".
                 " Quantity int,".
                 " PRIMARY KEY (RecipeName, Ingredient)".
                 " )";
$executeRecipesCreation = mysqli_query($conn, $createRecipes);

$createInventory = "CREATE TABLE IF NOT EXISTS Inventory (".
                   " Ingredient varchar(40) NOT NULL,".
                   " Quantity int,".
                   " PRIMARY KEY (Ingredient)".
                   " )";
$executeInventoryCreation = mysqli_query($conn, $createInventory);

mysqli_close($conn);

echo "<head>
           <meta http-equiv='refresh' content='0; URL=http://localhost/homepage.html'>
      </head>"


?>









