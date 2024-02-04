<!-- Schritt 2: Lesen der JSON-Daten und Speichern in der Datenbank (PHP) -->
<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "bookstore";

// Verbindung zur Datenbank herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// JSON-Daten lesen
$json_data = file_get_contents('sales_data.json');
$data = json_decode($json_data, true);

// Daten in die Datenbank einfügen
foreach ($data as $sale) {
    $customer_name = $sale['customer_name'];
    $customer_mail = $sale['customer_mail'];
    $product_id = $sale['product_id'];
    $sale_date = $sale['sale_date'];

    $sql = "INSERT INTO sales (customer_name, customer_mail, product_id, sale_date)
            VALUES ('$customer_name', '$customer_mail', $product_id, '$sale_date')";

    if ($conn->query($sql) === FALSE) {
        echo "Fehler beim Einfügen: " . $conn->error;
    }
}

$conn->close();
?>

