function updateTotalPrice() {
        var selects = document.querySelectorAll('#purchaseDropdowns select');
        var total = 0;
        selects.forEach(function(select) {
            var itemId = select.value;
            if (purchasePrices[itemId]) {
                total += parseFloat(purchasePrices[itemId]);
            }
        });
        document.getElementById('totalPrice').textContent = total.toFixed(2);
        document.getElementById('totalBuyingPriceInput').value = total.toFixed(2);
    }

    // Update total when dropdown changes
    document.getElementById('purchaseDropdowns').addEventListener('change', updateTotalPrice);

    // Update total when new dropdown is added
    document.getElementById('addDropdownBtn').addEventListener('click', function() {
        var dropdownsDiv = document.getElementById('purchaseDropdowns');
        var selects = dropdownsDiv.getElementsByTagName('select');
        if (selects.length > 0) {
            var newSelect = selects[0].cloneNode(true);
            dropdownsDiv.appendChild(document.createElement('br'));
            dropdownsDiv.appendChild(newSelect);
            newSelect.addEventListener('change', updateTotalPrice);
        }
        updateTotalPrice();
    });

    // Initial total
    updateTotalPrice();