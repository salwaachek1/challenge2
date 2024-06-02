<?php

require_once __DIR__ . '\database.php';

$connection = database::OpenConnection();  // connection to database
$result_array = array();
$query_string = " ";
$limit = 25;
$offset = isset($_POST['offset']) ? $_POST['offset'] : null;
$sql = 'SELECT entity_id,category_name,name,price,image FROM item limit ' . $limit . ' offset ' . $offset;

$stmt = $connection->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result_array[] = array("entity_id" => $row['entity_id'], "category_name" =>  $row['category_name'], "name" => $row['name'], "image" => $row['image'], "price" => $row['price']);
}
$offset = $offset + 25;
$result_array[] = array("offset" => $offset);
echo json_encode($result_array);
