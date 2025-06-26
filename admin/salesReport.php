<div class="section">
    <div class="box-area">
        <div class="header">
            <h2>Sales Report</h2>
        </div>
        <div class="filterContainer">
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search by product name...">
                <button id="searchButton"><i class="fa-solid fa-magnifying-glass"></i>Search</button>
            </div>
            <input type="text" id="startDate" placeholder="From">
            <label>></label>
            <input type="text" id="endDate" placeholder="To">
            <button class="add-btn" id="downloadButton"><i class="fa-solid fa-download"></i></button>
        </div>
        <div class="table-container">
            <table class="content-table">
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
                <tbody class="table-body" id="salesReportBody">
                    <!-- AJAX will fill this -->
                </tbody>
            </table>
        </div>
    </div>
</div>