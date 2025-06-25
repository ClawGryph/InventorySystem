<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin || Dashboard</title>
    <link rel="stylesheet" href="../cssFiles/normalize.css">
    <link rel="stylesheet" href="../cssFiles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="#" data-content="dashboard.php"><i class="fa-solid fa-bars"></i>Dashboard</a></li>
            <li><a href="#" data-content="userManagement.php"><i class="fa-solid fa-users"></i>User Management</a></li>
            <li><a href="#" data-content="purchases.php"><i class="fa-solid fa-money-bill"></i>Purchases</a></li>
            <li><a href="#" data-content="product.php"><i class="fa-solid fa-boxes-stacked"></i>Product</a></li>
            <li><a href="#" data-content="sales.php"><i class="fa-solid fa-money-bill-trend-up"></i>Sales</a></li>
            <li><a href="#" data-content="salesReport.php"><i class="fa-solid fa-rectangle-list"></i>Sales Report</a></li>
        </ul>
    </nav>
    <!-- Main Content -->
    <main class="wrapper" >
         <div class="section">
            <div class="box-area" id="mainContent">
                
                
            </div>
         </div>
    </main>
    <script src="../jsFiles/loadDashboardOnStart.js"></script>
    <script src="../jsFiles/loadContents.js"></script>
    <script src="../jsFiles/fetchingDashboardTotals.js"></script>
    <script src="../jsFiles/editUser.js"></script>
    <script src="../jsFiles/editPurchases.js"></script>
    <script src="../jsFiles/editProducts.js"></script>
    <script src="../jsFiles/updatingTotalPrice.js"></script>
    <script src="../jsFiles/editSales.js"></script>
    <script src="../jsFiles/checkingStock.js"></script>
    <script src="../jsFiles/displayMessageNotification.js"></script>
    <script src="../jsFiles/fetchSalesReport.js"></script>
</body>
</html>