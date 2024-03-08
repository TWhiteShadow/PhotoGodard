// Code for new photos in a new category
document.querySelector('#category_newPhotos') &&(() => {
    let newPhotosPrototype = document.querySelector('#category_newPhotos').dataset.prototype;
    // Remplacer __name__ par un nom unique
    let uniqueId = new Date().getTime(); // Utiliser un timestamp comme identifiant unique
    let newPhotosPrototypeModified = newPhotosPrototype.replace(/__name__/g, uniqueId);

    let tempDiv = document.createElement('div');
    tempDiv.innerHTML = newPhotosPrototypeModified;

    let newPhotoPrototypeElement = tempDiv.firstChild;

    document.querySelector(".newPhotosContainer").appendChild(newPhotoPrototypeElement);
 
})();

// Code for new photos in a new album
document.querySelector('#album_newPhotos') &&(() => {
    var newPhotosPrototype = document.querySelector('#album_newPhotos').dataset.prototype;
    // Remplacer __name__ par un nom unique
    var uniqueId = new Date().getTime(); // Utiliser un timestamp comme identifiant unique
    var newPhotosPrototypeModified = newPhotosPrototype.replace(/__name__/g, uniqueId);

    var tempDiv = document.createElement('div');
    tempDiv.innerHTML = newPhotosPrototypeModified;

    var newPhotoPrototypeElement = tempDiv.firstChild;

    document.querySelector(".newPhotosContainer").appendChild(newPhotoPrototypeElement);
})();