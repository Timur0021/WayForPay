use Tima\WayForPay;

// Ініціалізація об'єкту WayForPay
$wayForPay = new WayForPay('your_merchant_login', 'your_secret_key', 'your_domain');

// Отримання URL для оплати
$orderNumber = 123456; // Номер замовлення
$amount = 100.00; // Сума оплати
$currencyCode = 'UAH'; // Валюта
$returnUrl = 'https://your-domain.com/return-url'; // URL для повернення після оплати
$webhookUrl = 'https://your-domain.com/webhook-url'; // URL для отримання повідомлень про платежі
$orderName = 'Замовлення'; // Назва замовлення
$response = $wayForPay->pay($orderNumber, $amount, $currencyCode, $returnUrl, $webhookUrl, $orderName);

echo ($responce);
