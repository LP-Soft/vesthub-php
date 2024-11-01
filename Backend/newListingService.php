<?php
    include "../Database/databaseController.php";
    include "../Frontend/Pages/newListingPage.php";

        function denemeee($houseInfo)
        {
            echo $houseInfo->price;
        }

        //Data'lar buraya geliyor $houseInfo içinde ama alt kısım hata verdi. Ona bakabilir misin?

        /*
         if (createHouseListing($house, $GLOBALS['conn'])) {  // Call the function
                $houseID = getLastHouseID($GLOBALS['conn']);
                // Check if form was submitted
                if (isset($_FILES['files'])) {
                    $upload_dir = '../house-images/'; //path of house-images
                    $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
                    $upload_dir .= $houseID . '/'; //create new directory inside of house-images with the id of the house
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true); //since there is no directory right now, create with mkdir()
                    }
                    // Initialize image number counter
                    $image_number = 1;

                    // Check if files were selected for upload
                    if (!empty(array_filter($_FILES['files']['name']))) {
                        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
                            $file_tmpname = $_FILES['files']['tmp_name'][$key];
                            $file_name = $_FILES['files']['name'][$key];
                            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                            // Create a file name in the format "houseID-imageNumber.file_ext" (e.g., 1-1.jpg, 1-2.png)
                            $new_filename = $houseID . '-' . $image_number . '.' . $file_ext;
                            $filepath = $upload_dir . $new_filename;  // Full path for the new file

                            // Check file type is allowed
                            if (in_array(strtolower($file_ext), $allowed_types)) {
                                // Check if file already exists
                                if (file_exists($filepath)) {
                                    echo "{$new_filename} already exists.<br>";
                                } else {
                                    // Move the uploaded file to the desired folder
                                    if (move_uploaded_file($file_tmpname, $filepath)) {
                                        echo "{$new_filename} successfully uploaded.<br>";
                                        $image_number++; // Increment image number for the next file
                                    } else {
                                        echo "Error uploading {$new_filename}.<br>";
                                    }
                                }
                            } else {
                                echo "{$file_name} has an invalid file type ({$file_ext}).<br>";
                            }
                        }
                    } else {
                        echo "No files selected.<br>";
                    }
                }
            }
         */
?>