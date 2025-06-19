document.addEventListener('DOMContentLoaded', function() {
//user management
document.getElementById('addUserPage').addEventListener('click', function() {
    document.getElementById('addUserModal').style.opacity = '1';
    document.getElementById('userManagementTable').style.opacity = '0';
    document.getElementById('addUserPage').style.opacity = '0';
});
document.getElementById('addUserButton').addEventListener('click', function() {
    document.getElementById('addUserModal').style.opacity = '1';
    document.getElementById('userManagementTable').style.opacity = '0';
});
});


document.addEventListener('DOMContentLoaded', function() {
// Sales management
document.getElementById('addNewSales').addEventListener('click', function() {
        document.getElementById('addSalesModal').style.opacity = '1';
        document.getElementById('salesTable').style.opacity = '0';
        document.getElementById('addNewSales').style.opacity = '0';
});
    document.getElementById('addNewSalesButton').addEventListener('click', function() {
        document.getElementById('addSalesModal').style.opacity = '0';
        document.getElementById('salesTable').style.opacity = '1';
    }); 
});

document.addEventListener('DOMContentLoaded', function() {
    // Purchase management
    document.getElementById('addPurchasePage').addEventListener('click', function() {
        document.getElementById('purchaseModal').style.opacity = 1;
        document.getElementById('purchaseTable').style.opacity = 0;
        document.getElementById('addPurchasePage').style.opacity = 0;
    });

    document.getElementById('addNewPurchase').addEventListener('click', function(event) {
        document.getElementById('purchaseModal').style.opacity = 0;
        document.getElementById('purchaseTable').style.opacity = 1;
    });
});