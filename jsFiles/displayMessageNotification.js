function checkLowStock() {
    fetch('lowStockHandler.php')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                alert("Low stock alert for: \n" + data.join("\n"));
                // Or display in a div:
                // document.getElementById('lowStockNotice').textContent = "Low stock: " + data.join(", ");
            }
        });
}

document.addEventListener('DOMContentLoaded', checkLowStock);