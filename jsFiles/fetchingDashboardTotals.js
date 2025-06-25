function initAdminDashboard() {
    function loadDashboardTotals() {
        fetch('dashboardTotals.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalSales').textContent = "₱" + Number(data.totalSales).toLocaleString(undefined, {minimumFractionDigits: 2});
                document.getElementById('totalPurchases').textContent = "₱" + Number(data.totalPurchases).toLocaleString(undefined, {minimumFractionDigits: 2});
                document.getElementById('totalProfit').textContent = "₱" + Number(data.totalProfit).toLocaleString(undefined, {minimumFractionDigits: 2});
                document.getElementById('totalProducts').textContent = Number(data.totalProducts).toLocaleString();
            });
    }

    // ✅ Directly call the function, not inside DOMContentLoaded
    loadDashboardTotals();
}
