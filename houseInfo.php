<?php

class HouseInfo {
    public $title;
    public $description;
    public $numOfRooms;
    public $price;
    public $city;
    public $district;
    public $neighborhood;
    public $street;
    public $houseType;
    public $floor;
    public $totalFloor;
    public $area;
    public $fiberInternet = 0;
    public $airConditioner = 0;
    public $floorHeating = 0;
    public $fireplace = 0;
    public $terrace = 0;
    public $satellite = 0;
    public $parquet = 0;
    public $steelDoor = 0;
    public $furnished = 0;
    public $insulation = 0;
    public $isSale = 1;
    public $status = 'Pending';
    public $id = 0; // not existing at the beginning

    public function __construct($postData) {
        // Initialize basic details from POST data
        $this->id = 0;
        $this->title = $postData['title'];
        $this->description = $postData['description'];
        $this->numOfRooms = (int)$postData['numOfRooms'];
        $this->price = (int)$postData['price'];
        $this->city = $postData['city'];
        $this->district = $postData['district'];
        $this->neighborhood = $postData['neighborhood'];
        $this->street = $postData['street'];
        $this->houseType = $postData['houseType'];
        $this->floor = (int)$postData['floor'];
        $this->totalFloor = (int)$postData['totalFloor'];
        $this->area = (int)$postData['area'];

        // Initialize key features
        if (isset($postData['keyFeatures'])) {
            foreach ($postData['keyFeatures'] as $selectedFeature) {
                switch ($selectedFeature) {
                    case 'Fiber Internet':
                        $this->fiberInternet = 1;
                        break;
                    case 'Air Conditioner':
                        $this->airConditioner = 1;
                        break;
                    case 'Floor Heating':
                        $this->floorHeating = 1;
                        break;
                    case 'Fireplace':
                        $this->fireplace = 1;
                        break;
                    case 'Terrace':
                        $this->terrace = 1;
                        break;
                    case 'Satellite':
                        $this->satellite = 1;
                        break;
                    case 'Parquet':
                        $this->parquet = 1;
                        break;
                    case 'Steel Door':
                        $this->steelDoor = 1;
                        break;
                    case 'Furnished':
                        $this->furnished = 1;
                        break;
                    case 'Insulation':
                        $this->insulation = 1;
                        break;
                }
            }
        }

        // Check if the property is for sale or rent
        if (isset($postData['isSale'])) {
            $this->isSale = 0; // Set to 0 for rent
        }
    }
}

?>