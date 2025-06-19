<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        table, th, td { border: 1px solid #333; border-collapse: collapse; }
        th, td { padding: 8px; }
    </style>
</head>
<body>
    <div>
        <input type="text" id="searchInput" placeholder="Search by product name...">
        <button id="searchButton">Search</button>
        <input type="text" id="startDate" placeholder="From">
        <label>></label>
        <input type="text" id="endDate" placeholder="To">
        <button id="downloadButton">Download Sales</button>
    </div>
    <h2>Sales Report</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Product Name</th>
                <th>Buying Price</th>
                <th>Selling Price</th>
                <th>Total Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody id="salesReportBody">
            <!-- AJAX will fill this -->
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="../jsFiles/fetchSalesReport.js"></script>
    <script>
        flatpickr("#startDate", { dateFormat: "Y-m-d" });
        flatpickr("#endDate", { dateFormat: "Y-m-d" });
    </script>
</body>
</html>