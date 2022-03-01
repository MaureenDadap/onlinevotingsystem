<?php
require_once 'connection.php';

$name = $_POST['party-name'];
$conn = Connect();

$query = 'INSERT INTO partylists(name) VALUES(?)';

$stmt = $conn->prepare($query);
$stmt->bind_param('s', $name);
$stmt->execute();
$conn->close();
header('location:../admin-partylist.php');
