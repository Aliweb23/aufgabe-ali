<!-- Schritt 4: Ausgabe der gefilterten Ergebnisse in einer Tabelle -->
<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "bookstore";

// Verbindung zur Datenbank herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// SQL-Abfrage vorbereiten
$sql = "SELECT sales.id, sales.customer_name, products.name AS product_name, products.price AS product_price
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
    echo "<table>";
    echo "<tr><th>ID</th><th>Customer</th><th>Product</th><th>Price</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['customer_name'] . "</td>";
        echo "<td>" . $row['product_name'] . "</td>";
        echo "<td>$" . $row['product_price'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Keine Ergebnisse gefunden.";
}

$conn->close();
?>
