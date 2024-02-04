<!-- Schritt 5: Hinzufügen einer letzten Zeile für den Gesamtpreis aller gefilterten Einträge -->
<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "bookstore";

// Verbindung zur Datenbank herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// SQL-Abfrage vorbereiten
$sql = "SELECT SUM(products.price) AS total_price
        FROM sales
        INNER JOIN products ON sales.product_id = products.id";

// Filter anwenden, falls vorhanden
if (isset($_GET['customer-filter'])) {
    $customer_filter = $_GET['customer-filter'];
    $sql .= " WHERE sales.customer_name LIKE '%$customer_filter%'";
}

if (isset($_GET['product-filter'])) {
    $product_filter = $_GET['product-filter'];
    if (isset($_GET['customer-filter'])) {
        $sql .= " AND products.name LIKE '%$product_filter%'";
    } else {
        $sql .= " WHERE products.name LIKE '%$product_filter%'";
    }
}

if (isset($_GET['price-filter'])) {
    $price_filter = $_GET['price-filter'];
    if (isset($_GET['customer-filter']) || isset($_GET['product-filter'])) {
        $sql .= " AND products.price <= $price_filter";
    } else {
        $sql .= " WHERE products.price <= $price_filter";
    }
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_price = $row['total_price'];
    echo "<p>Total Price of Filtered Sales: $" . number_format($total_price, 2) . "</p>";
} else {
    echo "<p>Total Price of Filtered Sales: $0.00</p>";
}

$conn->close();
?>

