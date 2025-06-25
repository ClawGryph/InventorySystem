function initSalesReport() {
    // Optional: Add flatpickr CSS
    const flatpickrStyle = document.createElement('link');
    flatpickrStyle.rel = "stylesheet";
    flatpickrStyle.href = "https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css";
    document.head.appendChild(flatpickrStyle);

    // Load flatpickr script
    const flatpickrScript = document.createElement('script');
    flatpickrScript.src = "https://cdn.jsdelivr.net/npm/flatpickr";
    flatpickrScript.onload = function () {
        flatpickr("#startDate", { dateFormat: "Y-m-d" });
        flatpickr("#endDate", { dateFormat: "Y-m-d" });
    };
    document.head.appendChild(flatpickrScript);

    // Function to fetch sales report
    function fetchSalesReport() {
        var search = document.getElementById('searchInput').value;
        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "salesReportHandler.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('salesReportBody').innerHTML = xhr.responseText;
            } else {
                alert("Failed to load sales report.");
            }
        };
        xhr.send(
            "search=" + encodeURIComponent(search) +
            "&startDate=" + encodeURIComponent(startDate) +
            "&endDate=" + encodeURIComponent(endDate)
        );
    }

    // Set event listeners (no need for DOMContentLoaded here)
    document.getElementById('searchButton').addEventListener('click', fetchSalesReport);
    document.getElementById('downloadButton').addEventListener('click', function () {
        const search = encodeURIComponent(document.getElementById('searchInput').value);
        const startDate = encodeURIComponent(document.getElementById('startDate').value);
        const endDate = encodeURIComponent(document.getElementById('endDate').value);

        const url = `downloadSalesReportHandler.php?search=${search}&startDate=${startDate}&endDate=${endDate}`;
        window.location.href = url;
    });

    // Fetch data on first load
    fetchSalesReport();
}