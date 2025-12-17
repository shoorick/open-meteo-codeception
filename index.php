<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\Weather\WeatherClient;
use GuzzleHttp\Client;

$latitude = isset($_GET['latitude']) ? (string)$_GET['latitude'] : '';
$longitude = isset($_GET['longitude']) ? (string)$_GET['longitude'] : '';

$client = new WeatherClient(new Client());

$error = null;
$result = null;

if (isset($_GET['submit'])) {
    if (!$client->validateInput($latitude, $longitude)) {
        $error = 'Invalid input. Latitude and longitude must be within -180...180.';
    } else {
        try {
            $result = $client->sendRequest((float)$latitude, (float)$longitude);
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="/icon-16.png">
    <title>Open-Meteo Weather</title>
</head>
<body>
<div class="container py-4">
    <h1 class="mb-4">Current weather</h1>

    <form method="get" class="row g-3">
        <div class="col-md-4">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" class="form-control" id="latitude" name="latitude" value="<?= htmlspecialchars($latitude, ENT_QUOTES) ?>" placeholder="e.g. 44">
        </div>
        <div class="col-md-4">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" class="form-control" id="longitude" name="longitude" value="<?= htmlspecialchars($longitude, ENT_QUOTES) ?>" placeholder="e.g. 20">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" name="submit" value="1" class="btn btn-primary w-100">Get weather</button>
        </div>
    </form>

    <?php if ($error !== null): ?>
        <div class="alert alert-danger mt-4" role="alert">
            <?= htmlspecialchars($error, ENT_QUOTES) ?>
        </div>
    <?php endif; ?>

    <?php if ($result !== null): ?>
        <h2 class="mt-4">Response</h2>
        <pre class="bg-light border rounded p-3 mb-0"><?= htmlspecialchars(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), ENT_QUOTES) ?></pre>
    <?php endif; ?>
</div>
<script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
