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

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchButton').addEventListener('click', fetchSalesReport);
    fetchSalesReport(); // Load on page load
});

document.getElementById('downloadButton').addEventListener('click', function () {
        const search = encodeURIComponent(document.getElementById('searchInput').value);
        const startDate = encodeURIComponent(document.getElementById('startDate').value);
        const endDate = encodeURIComponent(document.getElementById('endDate').value);

        const url = `downloadSalesReportHandler.php?search=${search}&startDate=${startDate}&endDate=${endDate}`;
        window.location.href = url;
    });