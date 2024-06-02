<?php

require_once __DIR__ . '\database.php';
require __DIR__ . '\log.php';
require __DIR__ . '\dto\resultDto.php';
require '..\src\file-operations\upload.php';

function uploadXmlFile($file): ResultDto
{
    $result = new ResultDto();
    $result->setSuccess(false);
    $targetDirectory = "../files/";
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }
    $fileName = $file['name'];
    $targetFile = $targetDirectory . time() . '_' . $fileName;
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        $result = loadXmlIntoDatabase($targetFile);
        return $result;
    }
    $result->setMessage('something went wrong about the file to upload');
    return $result;
}
