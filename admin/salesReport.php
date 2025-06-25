
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