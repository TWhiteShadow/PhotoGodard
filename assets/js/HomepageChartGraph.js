document.getElementById("myChart") && document.addEventListener("DOMContentLoaded", function () {
    var usedDiskSpaceGB = parseFloat(document.getElementById("usedDiskSpace").textContent);
    var availableDiskSpaceGB = parseFloat(document.getElementById("availableDiskSpace").textContent);
    
    // Assuming totalDiskSpace is 100 GB, you can adjust this accordingly
    var totalDiskSpaceGB = availableDiskSpaceGB;

    var usedDiskSpacePercentage = (usedDiskSpaceGB / totalDiskSpaceGB) * 100;
    var availableDiskSpacePercentage = 100 - usedDiskSpacePercentage;

    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [
                {
                    label: 'utilisation : %',
                    data: [
                        usedDiskSpacePercentage,
                        availableDiskSpacePercentage
                    ],
                    borderWidth: 1,
                    backgroundColor: ["lightblue", "lightgray"]
                }
            ],
            labels: [
                'Espace Disque utilisé', 'Espace Disque disponible',
            ],
        },
        options: {
            plugins: {
                legend: true,
                tooltip: true
            },
            scales: {
                x: {
                    display: false
                },
                y: {
                    display: false
                }
            }
        }
    });
});
