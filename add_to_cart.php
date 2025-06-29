<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$id = $_POST['id'] ?? '';
$name = $_POST['name'] ?? '';
$price = $_POST['price'] ?? 0;
$image = $_POST['image'] ?? '';
$quantity = intval($_POST['quantity'] ?? 1);

if (!$id || !$name || !$price) {
    echo json_encode(['success' => false, 'message' => 'Missing product data']);
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity'] += $quantity;
} else {
    $_SESSION['cart'][$id] = [
        'id' => $id,
        'name' => $name,
        'price' => floatval($price),
        'image' => $image,
        'quantity' => $quantity
    ];
}

$cartCount = 0;
foreach ($_SESSION['cart'] as $item) {
    $cartCount += $item['quantity'];
}

echo json_encode([
    'success' => true,
    'cartCount' => $cartCount
]);
exit;
