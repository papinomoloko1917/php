<?php

declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

define('APP_DIR', dirname(__DIR__));

require APP_DIR . '/vendor/autoload.php';

function jsonResponse(array $data, int $statusCode = 200): void {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

function logEvent(string $status, array $payload, string $eventKey): void {
    $logFile = APP_DIR . '/var/events.log';

    $logLine = sprintf(
        "[%s] %s camera=%s event_type=%s object_type=%s event_key=%s\n",
        (new DateTimeImmutable('now', new DateTimeZone('Europe/Moscow')))->format(DateTimeInterface::ATOM),
        $status,
        $payload['camera'],
        $payload['event_type'],
        $payload['object_type'],
        $eventKey
    );

    file_put_contents($logFile, $logLine, FILE_APPEND);
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

if ($path === '/') {
    if ($method === 'GET') {
        jsonResponse([
            'app' => 'MaxNotify',
            'status' => 'ok',
        ]);

        return;
    }
}

if ($path === '/test-event') {
    if ($method !== 'POST') {
        header('Allow: POST');

        jsonResponse([
            'error' => 'Method not allowed',
            'allowed_methods' => ['POST'],
        ], 405);

        return;
    }

    $rawBody = file_get_contents('php://input');

    $payload = json_decode($rawBody, true);
    if (!is_array($payload)) {
        jsonResponse([
            'error' => 'Invalid JSON body',
        ], 400);

        return;
    }

    $requiredFields = ['camera', 'event_type', 'object_type', 'time'];

    $allowedCameras = ['front-door', 'yard'];

    $allowedObjectTypes = ['human', 'vehicle'];

    $allowedEventTypes = ['motion', 'smart_motion'];

    foreach ($requiredFields as $field) {
        if (!isset($payload[$field]) || $payload[$field] === '') {
            jsonResponse([
                'error' => 'Missing required field',
                'field' => $field,
            ], 422);

            return;
        }
        if (!is_string($payload[$field])) {
            jsonResponse([
                'error' => 'Field must be a string',
                'field' => $field,
            ], 422);

            return;
        }
    }

    try {
        $eventTime = new DateTimeImmutable($payload['time']);
    } catch (Exception) {
        jsonResponse([
            'error' => 'Invalid time format',
            'field' => 'time',
        ], 422);

        return;
    }

    $moscowTime = $eventTime->setTimezone(new DateTimeZone('Europe/Moscow'));
    $hour = (int) $moscowTime->format('H');

    $isNightTime = $hour >= 21 || $hour < 6;

    if (!$isNightTime) {
        jsonResponse([
            'message' => 'Event ignored by time filter',
            'event_time' => $moscowTime->format(DateTimeInterface::ATOM),
            'hour' => $hour,
        ], 202);

        return;
    }

    if (!in_array($payload['camera'], $allowedCameras, true)) {
        jsonResponse([
            'message' => 'Event ignored by camera filter',
            'camera' => $payload['camera'],
        ], 202);

        return;
    }

    if (!in_array($payload['object_type'], $allowedObjectTypes, true)) {
        jsonResponse([
            'message' => 'Event ignored by object type filter',
            'object_type' => $payload['object_type'],
        ], 202);

        return;
    }

    if (!in_array($payload['event_type'], $allowedEventTypes, true)) {
        jsonResponse([
            'message' => 'Event ignored by event type filter',
            'event_type' => $payload['event_type'],
        ], 202);

        return;
    }

    $eventKey = implode('|', [
        $payload['camera'],
        $payload['event_type'],
        $payload['object_type'],
        $moscowTime->format('Y-m-d H:i'),
    ]);

    $lastEventFile = APP_DIR . '/var/last_event_key.txt';

    $lastEventKey = file_exists($lastEventFile)
        ? trim(file_get_contents($lastEventFile))
        : null;

    if ($lastEventKey === $eventKey) {
        logEvent('duplicate', $payload, $eventKey);

        jsonResponse([
            'message' => 'Event ignored as duplicate',
            'event_key' => $eventKey,
        ], 202);

        return;
    }

    file_put_contents($lastEventFile, $eventKey);

    logEvent('accepted', $payload, $eventKey);

    jsonResponse([
        'message' => 'Event accepted',
        'camera' => $payload['camera'],
        'event_type' => $payload['event_type'],
        'object_type' => $payload['object_type'],
        'event_time' => $moscowTime->format(DateTimeInterface::ATOM),
        'event_key' => $eventKey,
    ]);

    return;
}

jsonResponse([
    'error' => 'Not found',
], 404);

return;
