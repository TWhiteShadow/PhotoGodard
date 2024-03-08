document.querySelector(".visibleOption") && document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll(".visibleOption").forEach(element => {
        element.addEventListener("click", event => {
            event.preventDefault();
            const id = element.dataset.id;
            $.ajax({
                url: '/admin/footer/links/' + id + '/update/visible', 
                type: 'POST',
                success: response => {
                    const checkbox = element.querySelector("input[type='checkbox']");
                    checkbox.checked = !checkbox.checked; // Inverse l'état du checkbox
                },
                error: (xhr, textStatus, errorThrown) => { 
                    alert('Erreur! ' + xhr.responseText); 
                }
            });
        });
    });
});