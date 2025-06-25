document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('nav ul').addEventListener('click', function(e) {
        const link = e.target.closest('a[data-content]');
        if (link) {
            e.preventDefault();
            const contentUrl = link.getAttribute('data-content');
            fetch(contentUrl)
                .then(response => response.text())
                .then(html => {
                    const mainContent = document.getElementById('mainContent');
                    mainContent.innerHTML = html;

                    // Execute any <script> tags in the loaded HTML
                    mainContent.querySelectorAll('script').forEach(script => {
                        if (script.textContent) {
                            eval(script.textContent);
                        }
                    });

                    // Call the right init function based on the page
                    if (contentUrl === 'dashboard.php' && typeof initAdminDashboard === 'function') {
                        initAdminDashboard();
                    }
                    if (contentUrl === 'userManagement.php' && typeof initUserManagement === 'function') {
                        initUserManagement();
                    }
                    if (contentUrl === 'purchases.php' && typeof initPurchases === 'function') {
                        initPurchases();
                    }
                    if (contentUrl === 'product.php' && typeof initProducts === 'function' && typeof initUpdatingTotalPrice === 'function') {
                        initProducts();
                        setTimeout(initUpdatingTotalPrice, 0); // <-- Ensures purchasePrices is available
                    }
                    if (contentUrl === 'sales.php' && typeof initSales === 'function') {
                        initSales();
                        setTimeout(() => {
                            if (typeof initStockChecker === 'function') {
                                initStockChecker();
                            }
                            if (typeof checkLowStock === 'function') {
                                checkLowStock();
                            }
                        }, 0);
                    }
                    if (contentUrl === 'salesReport.php' && typeof initSalesReport === 'function') {
                        initSalesReport();
                    }
                });
        }
    });
});