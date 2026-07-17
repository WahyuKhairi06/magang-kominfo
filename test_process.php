<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$controller = new App\Http\Controllers\ChatbotController();

$request = Illuminate\Http\Request::create('/chat/send', 'POST', ['message' => 'halo']);
$response = $controller->send($request);

echo "HTTP STATUS: " . $response->getStatusCode() . "\n";
echo "RESPONSE:\n" . $response->getContent() . "\n";
