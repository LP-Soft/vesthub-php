document.addEventListener('DOMContentLoaded', () => {fetch("../../Backend/Utilities/getCities.php")
    .then(response => response.json())
    .then(data => {
        const citySelect = document.getElementById("city");
        citySelect.innerHTML = '<option value="">City</option>';
        data.forEach(city => {
            let option = document.createElement("option");
            option.value = city;
            option.text = city;
            citySelect.appendChild(option);
        });
    })
    .catch(error => console.error('Error fetching cities:', error));
});

function updateDistricts() {
    const citySelect = document.getElementById("city");
    const districtSelect = document.getElementById("district");
    const selectedCity = citySelect.value;

    if (selectedCity) {
        fetch(`../../Backend/Utilities/getDistricts.php?city=${selectedCity}`)
            .then(response => response.json())
            .then(data => {
                districtSelect.innerHTML = '<option value="">District</option>';
                data.forEach(district => {
                    let option = document.createElement("option");
                    option.value = district;
                    option.text = district;
                    districtSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching districts:', error));
    } else {
        districtSelect.innerHTML = '<option value="">District</option>';
    }
    // delete all neighborhoods
    document.getElementById("neighborhood").innerHTML = '<option value="">Neighborhood</option>';
}

function updateNeighborhoods() {
    const districtSelect = document.getElementById("district");
    const neighborhoodSelect = document.getElementById("neighborhood");
    const selectedDistrict = districtSelect.value;

    if (selectedDistrict) {
        fetch(`../../Backend/Utilities/getNeighborhoods.php?district=${selectedDistrict}`)
            .then(response => response.json())
            .then(data => {
                neighborhoodSelect.innerHTML = '<option value="">Neighborhood</option>';
                data.forEach(neighborhood => {
                    let option = document.createElement("option");
                    option.value = neighborhood;
                    option.text = neighborhood;
                    neighborhoodSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching neighborhoods:', error));
    } else {
        neighborhoodSelect.innerHTML = '<option value="">Neighborhood</option>';
    }
}

function checkFields() {
    const city = document.getElementById("city").value;
    const district = document.getElementById("district").value;
    const neighborhood = document.getElementById("neighborhood").value;

    if (city === "" || district === "" || neighborhood === "") {
        alert("Please fill all fields.");
        event.preventDefault();
    }
}