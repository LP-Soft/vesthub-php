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
                echo $selectedFeature;
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

        createHouseListing($house, $GLOBALS['conn']);  // Call the function
    }
?>