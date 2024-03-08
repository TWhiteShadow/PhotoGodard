
document.getElementById("downloadAlbum") && document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("downloadAlbum").addEventListener("click", ()=>{
        document.getElementById("downloadAlbum").classList.add("finished");
        document.getElementById("downloadAlbum").innerHTML = `<div class="loaderAlbumDownload">
        <p class="text">
        <span class="letter letter1">C</span>
        <span class="letter letter2">h</span>
        <span class="letter letter3">a</span>
        <span class="letter letter4">r</span>
        <span class="letter letter5">g</span>
        <span class="letter letter6">e</span>
        <span class="letter letter7">m</span>
        <span class="letter letter8">e</span>
        <span class="letter letter9">n</span>
        <span class="letter letter10">t</span>
        </p>
        </div>`; 




        const url = window.location.pathname + `/createzip`;
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Supposons que la réponse est en JSON contenant l'URL
            })
            .then(data => {
                // Utilisez window.location ou window.open pour déclencher le téléchargement
                window.location.href = data.url; // Assurez-vous que la clé est correcte
                document.getElementById("downloadAlbum").innerHTML = "Terminé!";
                setTimeout(() => { document.getElementById("downloadAlbum").innerHTML = "Re-télécharger";document.getElementById("downloadAlbum").classList.remove("finished")}, 5000);

            })
            .catch(error => {
                document.getElementById("downloadAlbum").classList.add("error");
                console.error('Error downloading photos:', error);
                setTimeout(() => { document.getElementById("downloadAlbum").innerHTML = "Error Téléchargement";document.getElementById("downloadAlbum").classList.remove("error");}, 5000);
            });
    });
});