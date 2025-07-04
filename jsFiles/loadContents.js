document.addEventListener('DOMContentLoaded', function () {
    const titleMap = {
        'dashboard.php': 'Admin || Dashboard',
        'userManagement.php': 'Admin || User Management',
        'purchases.php': 'Admin || Purchases',
        'product.php': 'Admin || Product',
        'sales.php': 'Admin || Sales',
        'salesReport.php': 'Admin || Sales Report',
        'usersDashboard.php': 'User || Dashboard',
        'userSales.php': 'User || Sales'
    };

    const mainContent = document.getElementById('mainContent');

    function loadPage(contentUrl) {
        fetch(contentUrl)
            .then(response => response.text())
            .then(html => {
                mainContent.innerHTML = html;

                const normalizedUrl = contentUrl.split('/').pop();
                if (titleMap[normalizedUrl]) {
                    document.title = titleMap[normalizedUrl];
                }

                mainContent.querySelectorAll('script').forEach(script => {
                    if (script.textContent) eval(script.textContent);
                });

                if (normalizedUrl === 'dashboard.php' && typeof initAdminDashboard === 'function') {
                    initAdminDashboard();
                }
                if (normalizedUrl === 'userManagement.php' && typeof initUserManagement === 'function') {
                    initUserManagement();
                }
                if (normalizedUrl === 'purchases.php' && typeof initPurchases === 'function') {
                    initPurchases();
                }
                if (normalizedUrl === 'product.php' && typeof initProducts === 'function') {
                    initProducts();
                    setTimeout(initUpdatingTotalPrice, 0);
                }
                if (normalizedUrl === 'sales.php' && typeof initSales === 'function') {
                    initSales();
                    setTimeout(() => {
                        if (typeof initStockChecker === 'function') initStockChecker();
                        if (typeof checkLowStock === 'function') checkLowStock();
                    }, 0);
                }
                if (normalizedUrl === 'salesReport.php' && typeof initSalesReport === 'function') {
                    initSalesReport();
                }
                if(normalizedUrl === 'userSales.php' && typeof initUserSales === 'function'){
                    setTimeout(() => {
                        initUserSales();
                        if (typeof initStockChecker === 'function') initStockChecker();
                        if (typeof checkLowStock === 'function') checkLowStock();
                    }, 0);
                }
            });
    }

    // Auto-load only one dashboard based on what page you're in
    const isAdminPage = document.querySelector('a[data-content="dashboard.php"]');
    const isUserPage = document.querySelector('a[data-content="usersDashboard.php"]');

    if (isUserPage) {
        setTimeout(() => {
            loadPage(isUserPage.getAttribute('data-content'));
        },  0);
    } else if (isAdminPage) {
        loadPage("dashboard.php");
    }

    document.addEventListener('click', function (e) {
        const link = e.target.closest('a[data-content]');
        if (link) {
            e.preventDefault();
            const contentUrl = link.getAttribute('data-content');
            loadPage(contentUrl);
        }
    });
});