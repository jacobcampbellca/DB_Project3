<?php 

session_start();

$host = $_SESSION["host"];
$user = $_SESSION["user"];
$password = $_SESSION["password"];

$recipeName = $_POST["recipeName"];

$connect = mysqli_connect($host, $user, $password, $user);
if (!$connect) {
    die("Could not connect: ".mysqli_connect_error());
}

$listRecipe = "SELECT Ingredient, Quantity FROM Recipes WHERE RecipeName = \"$recipeName\"";

$execute = mysqli_query($connect, $listRecipe);
if(!$execute) {
    echo "Error Executing Qurey: " . mysqli_error($connect)."<br>";
    echo "<a href = \"http://localhost/homepage.html\">Back To Homepage</a><br>";
    die();
}

echo "<table border=1>";
echo "<tr> <th>Ingredient</th> <th>Quantity</th> </tr>";

while($row = mysqli_fetch_assoc($execute)) {
    echo "<tr> <td>".$row["Ingredient"]."</td>".
         "<td>".$row["Quantity"]."</td> </tr>";
}

echo "</table><br>";
mysqli_close($connect);

?>

<a href = "http://localhost/homepage.html">Back To Homepage</a><br>
