const quantityInput = document.getElementById('quantitySold');
const availableStockInput = document.getElementById('availableStock');
const errorSpan = document.getElementById('stockError');
const addSaleBtn = document.getElementById('addNewSalesButton');
const productSelect = document.getElementById('productName');

// Set availableStock when product changes
productSelect.addEventListener('change', function() {
    var availableStock = productStockMap[this.value] || 0;
    availableStockInput.value = availableStock;
    console.log("Set availableStock to:", availableStock);
    checkStockAndToggleButton(); // Re-check when product changes
});

// Check on quantity input
quantityInput.addEventListener('input', checkStockAndToggleButton);

// Optionally, check on page load
window.addEventListener('DOMContentLoaded', function() {
    var availableStock = productStockMap[productSelect.value] || 0;
    availableStockInput.value = availableStock;
    console.log("Initial availableStock:", availableStock);
    checkStockAndToggleButton();
});

function checkStockAndToggleButton() {
    var availableStock = parseInt(availableStockInput.value, 10);
    var quantity = parseInt(quantityInput.value, 10);

    // If availableStock or quantity is NaN, treat as 0
    if (isNaN(availableStock)) availableStock = 0;
    if (isNaN(quantity)) quantity = 0;

    if (quantity > availableStock) {
        errorSpan.textContent = "Not enough stock available!";
        errorSpan.style.display = "inline";
        addSaleBtn.disabled = true;
    } else {
        errorSpan.textContent = "";
        errorSpan.style.display = "none";
        addSaleBtn.disabled = false;
    }
}