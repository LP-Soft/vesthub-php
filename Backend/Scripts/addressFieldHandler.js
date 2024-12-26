const urlParams = new URLSearchParams(window.location.search);
const editListingCity = urlParams.get('city');
const editListingDistrict = urlParams.get('district');
const editListingNeighborhood = urlParams.get('neighborhood');
const editListingStreet = urlParams.get('street');
const selectedSaleRent = urlParams.get('isSale');
const selectedSort = urlParams.get('sort');
const selectedAmenities = urlParams.getAll('amenities[]');
const selectedHouseType = urlParams.get('house_type');
function setSelectedAmenities() {
    const checkboxes = document.getElementsByName('amenities[]');
    if (selectedAmenities.length > 0) {
        console.log("Setting amenities...");
        console.log("Found checkboxes:", checkboxes.length);
        checkboxes.forEach(checkbox => {
            console.log("Checking", checkbox.value, "against", selectedAmenities);
            if (selectedAmenities.includes(checkbox.value)) {
                    checkbox.checked = true;
                    console.log("Checked", checkbox.value);
            }
        });
    }
}
function setSelectedHouseType() {
    const selectedHouse = document.getElementById('house_type');
    if (selectedHouse) {
        selectedHouse.value = selectedHouseType;
    }
} 
//document.addEventListener('DOMContentLoaded', setSelectedAmenities);
document.addEventListener('DOMContentLoaded', () => {
    setSelectedHouseType();
    setSelectedAmenities();
    updateCities();
    handleImage();  // Call it directly here for page load
    console.log("DOM fully loaded and parsed"); 
});
if (selectedSaleRent != null) {
    document.getElementById('isSale').value = selectedSaleRent;
}
console.log(editListingCity, ",", editListingDistrict , ",", editListingNeighborhood , ",", editListingStreet);
console.log(selectedAmenities);
if (selectedSort) {
    document.getElementById('sort').value = selectedSort;
}

function updateCities() {
    fetch("../../Backend/Utilities/getCities.php")
        .then(response => response.json())
        .then(data => {
            const citySelect = document.getElementById("city");
            citySelect.innerHTML = '<option value="" selected hidden>City</option>';
            data.forEach(city => {
                let option = document.createElement("option");
                option.value = city;
                option.text = city;
                citySelect.appendChild(option);
                
            });

            //editListingPage için
            if(editListingCity!= null){
                citySelect.value = editListingCity;  // Directly set the selected value
                updateDistricts();
            }
        })
        .catch(error => console.error('Error fetching cities:', error));

}

function updateDistricts() {
    const citySelect = document.getElementById("city");
    const districtSelect = document.getElementById("district");
    const selectedCity = citySelect.value;

    if (selectedCity) {
        fetch(`../../Backend/Utilities/getDistricts.php?city=${selectedCity}`)
            .then(response => response.json())
            .then(data => {
                districtSelect.innerHTML = '<option value="" selected hidden>District</option>';
                data.forEach(district => {
                    let option = document.createElement("option");
                    option.value = district;
                    option.text = district;
                    districtSelect.appendChild(option);
                    
                });
                if(editListingDistrict != null){
                    districtSelect.value = editListingDistrict;
                    updateNeighborhoods();
                }
            })
            .catch(error => console.error('Error fetching districts:', error));
    } else {
        districtSelect.innerHTML = '<option value="">District</option>';
    }
    // delete all neighborhoods
    document.getElementById("neighborhood").innerHTML = '<option value="" selected hidden>Neighborhood</option>';
    document.getElementById("street").innerHTML = '<option value="" selected hidden>Street</option>';

}

function updateNeighborhoods() {
    const citySelect = document.getElementById("city");
    const districtSelect = document.getElementById("district");
    const neighborhoodSelect = document.getElementById("neighborhood");
    const selectedDistrict = districtSelect.value;
    const selectedCity = citySelect.value;

    if (selectedDistrict) {
        fetch(`../../Backend/Utilities/getNeighborhoods.php?district=${selectedDistrict}&city=${selectedCity}`)
            .then(response => response.json())
            .then(data => {
                neighborhoodSelect.innerHTML = '<option value="" selected hidden>Neighborhood</option>';
                data.forEach(neighborhood => {
                    let option = document.createElement("option");
                    option.value = neighborhood;
                    option.text = neighborhood;
                    neighborhoodSelect.appendChild(option);
                });
                if(editListingNeighborhood != null){
                    neighborhoodSelect.value = editListingNeighborhood;
                    updateStreets();
                }
            })
            .catch(error => console.error('Error fetching neighborhoods:', error));
    } else {
        neighborhoodSelect.innerHTML = '<option value="">Neighborhood</option>';
    }

    document.getElementById("street").innerHTML = '<option value="" selected hidden>Street</option>';
}

function updateStreets(){
    const citySelect = document.getElementById("city");
    const districtSelect = document.getElementById("district");
    const neighborhoodSelect = document.getElementById("neighborhood");
    const streetSelect = document.getElementById("street");
    const selectedNeighborhood = neighborhoodSelect.value;
    const selectedDistrict = districtSelect.value;
    const selectedCity = citySelect.value;


    if (selectedNeighborhood) {
        fetch(`../../Backend/Utilities/getStreets.php?neighborhood=${selectedNeighborhood}&district=${selectedDistrict}&city=${selectedCity}`)
            .then(response => response.json())
            .then(data => {
                streetSelect.innerHTML = '<option value="" selected hidden>Street</option>';
                data.forEach(street => {
                    let option = document.createElement("option");
                    option.value = street;
                    option.text = street;
                    streetSelect.appendChild(option);
                });
                if(editListingStreet != null){
                    streetSelect.value = editListingStreet;
                }
            })
            .catch(error => console.error('Error fetching neighborhoods:', error));
    } else {
        streetSelect.innerHTML = '<option value="">Street</option>';
    }
}

function checkFields() {
    const city = document.getElementById("city").value;
    const district = document.getElementById("district").value;
    const neighborhood = document.getElementById("neighborhood").value;

    if (city === "") {
        alert("Please select city.");
        event.preventDefault();
    }
}

let selectedFiles = [];

// Function to handle new file uploads (preview selected files)
function previewFiles(event) {
    const fileInput = event.target;
    const filePreview = document.getElementById('filePreview');

    // Loop over newly selected files
    for (let i = 0; i < fileInput.files.length; i++) {
        const file = fileInput.files[i];
        if (file.type.startsWith('image/')) {
            selectedFiles.push(file);

            const imgSrc = URL.createObjectURL(file);

            const imageCard = document.createElement('div');
            imageCard.className = 'image-card';

            const img = document.createElement('img');
            img.src = imgSrc;
            img.className = 'image-preview';

            imageCard.appendChild(img);

            const closeButton = document.createElement('span');
            closeButton.textContent = '×';
            closeButton.className = 'close-button';
            closeButton.onclick = function () {
                removeImage(closeButton, file);
            };

            imageCard.appendChild(closeButton);
            filePreview.appendChild(imageCard);
        }
    }
}

// Function to remove the previewed file
function removeImage(button, file) {
    const imageCard = button.parentElement;
    imageCard.remove();

    if (file.isNew) {
        // Remove the new file from the selectedFiles array
        selectedFiles = selectedFiles.filter(f => f.file !== file);
    } else {
        // Handle the removal of the existing file
        selectedFiles = selectedFiles.filter(f => f.url !== file);
    }

}

// Function to load existing files from the server when the page is loaded
// Function to load existing files from the server when the page is loaded
function handleImage() {
    const filePreview = document.getElementById('filePreview');

    // Fetch the existing image URLs from the backend
    fetch(`../../Backend/Utilities/getImages.php?houseID=${houseID}`)
        .then(response => response.json())
        .then(existingFiles => {
            // Loop over the fetched file URLs and create image previews for them
            existingFiles.forEach(fileUrl => {
                const imageCard = document.createElement('div');
                imageCard.className = 'image-card';

                const img = document.createElement('img');
                img.src = fileUrl;
                img.className = 'image-preview';

                imageCard.appendChild(img);

                const closeButton = document.createElement('span');
                closeButton.textContent = '×';
                closeButton.className = 'close-button';
                closeButton.onclick = function () {
                    removeImage(closeButton, fileUrl);
                };

                imageCard.appendChild(closeButton);
                filePreview.appendChild(imageCard);

                // Add existing file to selectedFiles array (use file URL as a reference or use another identifier)
                selectedFiles.push({ url: fileUrl, isNew: false });  // Mark this as an existing image

            });
        })
        .catch(error => console.error('Error fetching existing files:', error));
}

