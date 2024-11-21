<?php
$houseID = 0;
if(isset($_GET['houseID'])){
    $houseID = $_GET['houseID'];
}
$directory = "../../house-images/".$houseID."/";
$images = [];
// Open the directory and get all files
if ($handle = opendir($directory)) {
    while (false !== ($entry = readdir($handle))) {
        // Only add files with image extensions
        if (in_array(pathinfo($entry, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
            $images[] = $directory . $entry;
        }
    }
    closedir($handle);
}
// Return the images as a JSON response
echo json_encode($images);
?>
