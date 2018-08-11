<?php

include 'dbConnection.php';

try {
    $conn = getDatabaseConnection();
    $id = $_POST['id'];
    $sql = "UPDATE records SET searchedTimes = searchedTimes+1 WHERE id = $id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}



$sql = "SELECT name, searchedTimes from records WHERE id = $id";
$stmt = $conn->prepare($sql);
$stmt->execute(array(":id"=>$_POST['id']));
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($result);


?>   

