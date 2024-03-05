// Code to be executed if favorite picture is present
document.querySelector(".favorite-picture") && document.addEventListener("DOMContentLoaded", function () {

    // Get the current URL
    var currentUrl = window.location.href;
    var currentEntity = null;

    // Check if the URL contains "album" or "edit"
    if (currentUrl.includes("album")) {
        currentEntity = "album";
    } else if (currentUrl.includes("category")) {
        currentEntity = "category";
    } else {
        console.log("Neither 'album' nor 'category' found in the URL");
        return;
    }



    const checkboxes = document.querySelectorAll(".favorite-picture");

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            parent_id = checkbox.dataset.parentId;
            photo_id = checkbox.dataset.photoId;

            checkedCheckboxes = Array.from(checkboxes).filter(function (cb) {
                return cb.checked;
            });
            checkedCheckboxes.forEach(function (otherCheckbox) {
                if (otherCheckbox !== checkbox) {
                    otherCheckbox.checked = false;
                    otherCheckbox.parentNode.classList.remove("favorite");
                }
            });
            // Determine the value to send in the AJAX request
            const dataToSend = {
                photoId: this.checked ? photo_id : null, // Send photo_id if checked, otherwise send null
            };

            // Send an AJAX request to update favorite picture
            $.ajax({
                url: "/admin/" + currentEntity + "/" + parent_id + "/update/favorite", // Replace with your actual route
                type: "POST",
                data: dataToSend,
                success: function (response) {
                    checkbox.parentNode.classList.add("favorite");
                },
                error: function (response) {
                    alert("Erreur! " + response.responseText);
                },
            });
        });
    });
});


// Code to be executed if favorite picture is present
document.querySelector(".photoToDelete") && document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.photoToDelete').forEach((checkbox) => { checkbox.checked = false })
    const photoToDeleteCheckboxes = document.querySelectorAll(".photoToDelete");
    let buttonClicked = false;

    // Add change event listener to each checkbox
    photoToDeleteCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            buttonClicked = true;
            const checkedCheckboxes = Array.from(photoToDeleteCheckboxes).filter(function (cb) {
                return cb.checked;
            });

            if (checkedCheckboxes.length > 0) {
                // Show all checkboxes containers
                document.querySelectorAll(".photoToDeleleContainer").forEach(function (label) {
                    label.classList.add("showAllCheckboxes");
                    label.parentElement.classList.add("cursor-pointer");
                });
                document.querySelector('.deleteSelection').classList.add("flex");
            }
        });
    });

    // Event delegation for click event on photo containers
    document.querySelector('.photoGallery').addEventListener('click', function (event) {
        if (buttonClicked) {
            const container = event.target.closest('.photoContainer');
            if (!container) return; // If clicked outside photo container, return

            const photoToDeleteCheckbox = container.querySelector(".photoToDelete");
            if (photoToDeleteCheckbox) {
                photoToDeleteCheckbox.checked = !photoToDeleteCheckbox.checked;
            }
        }
    });

    document.querySelector('.deleteSelection').addEventListener('click', function () {
        // Find all checkboxes with the name "photoToDelete[]"
        const checkboxes = document.querySelectorAll('.photoToDelete');
        // Check if any checkboxes exist
        if (checkboxes.length > 0) {
            let photoToDeleteValue = [];
            // Iterate over the checkboxes
            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) { // Check if checkbox is checked
                    photoToDeleteValue.push(parseInt(checkbox.getAttribute('data-photo-id'))); // Get data-photo-id attribute value
                }
            });
            // Display the values (you can replace this with your desired action)
            deletePhotos(photoToDeleteValue)
        } else {
            console.log("Associated checkboxes not found");
        }
    });
    function deletePhotos(photoIds) {
        // Effectuer une requête AJAX POST vers la route de suppression des photos
        fetch('/photos/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ photo_ids: photoIds })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
        })
        .then(data => {
            // Actualiser ou recharger la page, ou effectuer d'autres actions après la suppression
            window.location.reload(true);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }
});