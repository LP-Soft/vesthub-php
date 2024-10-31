<?php
    include "../Database/databaseController.php";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Initialize feature variables with default values of 0
        $fiberInternet = 0;
        $airConditioner = 0;
        $floorHeating = 0;
        $fireplace = 0;
        $terrace = 0;
        $satellite = 0;
        $parquet = 0;
        $steelDoor = 0;
        $furnished = 0;
        $insulation = 0;
        $isSale = 1;
        $status = 'Pending';


        // Check if any key features were selected
        if (isset($_POST['keyFeatures'])) {
            // Iterate through the selected features and set their variables to 1
            foreach ($_POST['keyFeatures'] as $selectedFeature) {
                switch ($selectedFeature) {
                    case 'Fiber Internet':
                        $fiberInternet = 1;
                        break;
                    case 'Air Conditioner':
                        $airConditioner = 1;
                        break;
                    case 'Floor Heating':
                        $floorHeating = 1;
                        break;
                    case 'Fireplace':
                        $fireplace = 1;
                        break;
                    case 'Terrace':
                        $terrace = 1;
                        break;
                    case 'Satellite':
                        $satellite = 1;
                        break;
                    case 'Parquet':
                        $parquet = 1;
                        break;
                    case 'Steel Door':
                        $steelDoor = 1;
                        break;
                    case 'Furnished':
                        $furnished = 1;
                        break;
                    case 'Insulation':
                        $insulation = 1;
                        break;
                }
            }
        }
        else {
            echo "No features selected.";
        }

        if (isset($_POST['isSale'])) {
            $isSale = 0; // Property is for rent
        }

        $house = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'numOfRooms' => $_POST['numOfRooms'], // Convert to integer
            'price' => (int) $_POST['price'],           // Convert to integer
            'city' => $_POST['city'],
            'district' => $_POST['district'],
            'neighborhood' => $_POST['neighborhood'],
            'street' => $_POST['street'],
            'houseType' => $_POST['houseType'],
            'floor' => (int) $_POST['floor'],           // Convert to integer
            'totalFloor' => (int) $_POST['totalFloor'], // Convert to integer
            'area' => (int) $_POST['area'],              // Convert to integer
            'fiberInternet' => $fiberInternet,
            'airConditioner' => $airConditioner,
            'floorHeating' => $floorHeating,
            'fireplace' => $fireplace,
            'terrace' => $terrace,
            'satellite' => $satellite,
            'parquet' => $parquet,
            'steelDoor' => $steelDoor,
            'furnished' => $furnished,
            'insulation' => $insulation,
            'isSale' => $isSale,
            'status' => $status
        ];

        if(createHouseListing($house, $GLOBALS['conn'])) {  // Call the function
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
    }
?>