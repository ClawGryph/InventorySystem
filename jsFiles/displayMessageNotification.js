function checkLowStock() {
    fetch('../admin/lowStockHandler.php')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                alert("Low stock alert for: \n" + data.join("\n"));
            }
        });
}

document.addEventListener('DOMContentLoaded', checkLowStock);