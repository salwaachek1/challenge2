<?php

require('..\src\file-operations\upload.php');
include('form.html');

//echo phpinfo();
if (isset($_POST["submit"])) {
    $targetFile = "../files/" . time() . '_' . $_FILES['fileToUpload']['name'];
    if (!isset($_FILES['fileToUpload'])) {
        echo '<div class="error"> Please select a file ! :( </div>';
    } else {
        if (strtolower(pathinfo($targetFile, PATHINFO_EXTENSION) == 'xml')) {
            $result = uploadXmlFile($_FILES['fileToUpload']);
            if ($result->isSuccess()) {
                echo '<div id="msg">File uploaded successfully ! yay :) </div> <a href="javascript: void(0)" id="show" class="" onclick="getData()">show results</a><input id="offset" hidden="hidden" value="0"/>';
            } else {
                saveLog($result->getMessage());
                echo '<div class="error" id="error" > Upload failed :( </div>';
            }
        } else {
            echo '<div class="error" id="error"> File format is not supported ! :( </div>';
        }
    }
}
