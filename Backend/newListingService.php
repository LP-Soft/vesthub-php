<?php

    include "../../Database/databaseController.php";
    require_once "../../Frontend/Pages/newListingPage.php";

    function createListing($houseInfo)
    {

        // https://geocode.maps.co/search?q=CITY,DISTRICT,NEIGHBORHOOD,STREET&api_key=672e64f5dee6e743749773dwy569183
        //result[0].lat ve result[0].lon çekilecek
        if($houseInfo->ownerID != 0){ //sessionda birisi varsa 0dan farklı bir değer olacak

            if (createHouseListingToDb($houseInfo, $GLOBALS['conn'])) {  // Call the function

                $houseInfo -> id = getLastHouseIDFromDb($GLOBALS['conn']);
                // Check if form was submitted
                if (isset($_FILES['files'])) {

                    $upload_dir = '../../house-images/'; //path of house-images
                    $upload_dir .= $houseInfo->id . '/'; //create new directory inside of house-images with the id of the house
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true); //since there is no directory right now, create with mkdir()
                    }
                    // Initialize image number counter
                    $image_number = 1;
                    // Check if files were selected for upload
                    if (!empty(array_filter($_FILES['files']['name']))) {
                        foreach ($_FILES['files']['tmp_name'] as $key => $error) {
                            $file_tmpname = $_FILES['files']['tmp_name'][$key];
                            $file_name = $_FILES['files']['name'][$key];
                            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                            // Create a file name in the format "houseID-imageNumber.file_ext" (e.g., 1-1.jpg, 1-2.png)
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
            }
        }
    }
?>