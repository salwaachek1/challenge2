<?php

function loadXmlIntoDatabase(string $dataSource): ResultDto
{

    ini_set('memory_limit', '1536M'); // 1.5 GB
    ini_set('max_execution_time', 18000); // 5 hours

    $result = new ResultDto();
    $result->setSuccess(false);
    try {
        $connection = Database::OpenConnection();
    } catch (PDOException $e) {
        //saveLog($e->getMessage());
        $result->setMessage($e->getMessage());
        return $result;
    }
    try {
        $xml = simplexml_load_file($dataSource);
        $insertedCount = 0;
        foreach ($xml->children() as $row) {
            $values = [];
            foreach ($row->children() as  $key => $child) {
                $childNameStr = '(' . $child->getName() . ')';
                $childValue = implode(' ', $row->xpath($childNameStr));
                // convert string Yes/No to boolean
                if (in_array($child->getName(), ['Flavored', 'Seasonal', 'Instock'])) {
                    $childValue = $childValue == 'No' ? 0 : 1;
                }
                // check if element value is int
                if (in_array($child->getName(), ['entity_id', 'Rating', 'Count', 'Facebook', 'IsKcup'])) {
                    if (!ctype_digit($childValue) && !empty($childValue)) {
                        throw new Exception('Invalid type for child element');
                    }
                }
                $values[] = $childValue;
            }
            $isQueryOk = true;
            $sql = 'INSERT INTO item(entity_id,category_name,sku,name,description,short_desc,price,link,image,brand,rating,caffeine_type,count,flavored,seasonal,in_stock,facebook,is_k_cup) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
            $stmt = $connection->prepare($sql);
            $stmt->execute($values) ? null : $isQueryOk = false;
            if (!$isQueryOk) {
                throw new Exception("An element was not inserted !");
            } else {
                $insertedCount++;
            }
        }
        $result->setSuccess(true);
        $result->setCode(200);
        $result->setMessage('Success !' . $insertedCount . ' rows inserted successfully');
        return $result;
    } catch (Throwable $e) {
        $result->setMessage($e->getMessage());
        return $result;
    }
}
