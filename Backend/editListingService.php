<?php
include "../../Database/databaseController.php";
require_once "../../Frontend/Pages/editListingPage.php";

function editListing($houseInfo, $keptFiles){
    if(editListingInDb($GLOBALS['conn'],$houseInfo)){
        $numberOfFilesInFolder = deleteOldImages($houseInfo->houseID, json_decode($keptFiles));
        addNewImages($houseInfo->houseID, $numberOfFilesInFolder);
    }
}

function deleteOldImages($houseID, $keptFiles){
    $numberOfFilesInFolder = 0;
    $directory = "../../house-images/".$houseID;

    $files = array_diff(scandir($directory), array('.', '..'));  // Get all files excluding '.' and '..'

    foreach ($files as $file) {
        $numberOfFilesInFolder++;

        $filePath = "{$directory}/{$file}";
        if (is_file($filePath)) {
            if(!in_array($filePath, $keptFiles)){
                unlink($filePath);  // Delete the file
                $numberOfFilesInFolder--;
            }

        }
    }
    $newFiles = array_diff(scandir($directory), array('.', '..'));
    renameFiles($directory, $newFiles);
    return $numberOfFilesInFolder;
}

function renameFiles($directory, $newFiles){
    $image_number = 1;
    foreach ($newFiles as $file) {
        $idOfFile = substr($file, 0, strpos($file, '.'));
        $extension = substr($file, strpos($file, '.'));
        $filePath = "{$directory}/{$file}";
        if (is_file($filePath)) {
            rename($filePath, $directory."/".$image_number.$extension);
            $image_number++;
        }
    }
}

function addNewImages($houseID, $numberOfFilesInFolder){
    $upload_dir = "../../house-images/".$houseID."/";
    $image_number = $numberOfFilesInFolder+1;
    if (isset($_FILES['files']) && !empty(array_filter($_FILES['files']['name']))) {
        foreach ($_FILES['files']['tmp_name'] as $key => $error) {
            $file_tmpname = $_FILES['files']['tmp_name'][$key];
            $file_name = $_FILES['files']['name'][$key];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

            // Create a file name in the format "image_number.png"
            $new_filename = $image_number . '.' . $file_ext;
            $filepath = $upload_dir . $new_filename;  // Full path for the new file
            $targetFilePath = $upload_dir . $new_filename;
            // Check if file already exists
            if (!file_exists($filepath)) {
                // Move the uploaded file to the desired folder
                if (move_uploaded_file($file_tmpname, $filepath)) {
                    $image_number++;
                }
            }
        }
    }
}
?>