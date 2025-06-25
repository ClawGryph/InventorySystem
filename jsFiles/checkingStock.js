function initStockChecker() {
    const quantityInput = document.getElementById('quantitySold');
    const availableStockInput = document.getElementById('availableStock');
    const errorSpan = document.getElementById('stockError');
    const addSaleBtn = document.getElementById('addNewSalesButton');
    const productSelect = document.getElementById('productName');

    function checkStockAndToggleButton() {
        var availableStock = parseInt(availableStockInput.value, 10);
        var quantity = parseInt(quantityInput.value, 10);

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

    productSelect.addEventListener('change', function() {
        var availableStock = window.productStockMap[this.value] || 0;
        availableStockInput.value = availableStock;
        checkStockAndToggleButton();
    });

    quantityInput.addEventListener('input', checkStockAndToggleButton);

    // On page load
    var initialStock = window.productStockMap[productSelect.value] || 0;
    availableStockInput.value = initialStock;
    checkStockAndToggleButton();
}
