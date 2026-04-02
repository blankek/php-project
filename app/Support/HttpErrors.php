<?php

namespace App\Support;

class HttpErrors
{
    private static array $map = [
        400 => [
            'title'       => 'Bad Request',
            'description' => 'Сервер не может обработать запрос из-за некорректного синтаксиса.',
            'headers'     => ['X-Error-Type' => 'client-error', 'X-Error-Category' => 'request-syntax'],
        ],
        401 => [
            'title'       => 'Unauthorized',
            'description' => 'Требуется аутентификация для доступа к ресурсу.',
            'headers'     => ['X-Error-Type' => 'client-error', 'X-Error-Category' => 'authentication', 'WWW-Authenticate' => 'Bearer realm="app"'],
        ],
        403 => [
            'title'       => 'Forbidden',
            'description' => 'Сервер понял запрос, но отказывает в его выполнении.',
            'headers'     => ['X-Error-Type' => 'client-error', 'X-Error-Category' => 'authorization'],
        ],
        404 => [
            'title'       => 'Not Found',
            'description' => 'Запрошенный ресурс не найден на сервере.',
            'headers'     => ['X-Error-Type' => 'client-error', 'X-Error-Category' => 'not-found'],
        ],
        405 => [
            'title'       => 'Method Not Allowed',
            'description' => 'HTTP-метод не поддерживается для данного ресурса.',
            'headers'     => ['X-Error-Type' => 'client-error', 'X-Error-Category' => 'method', 'Allow' => 'GET, POST'],
        ],
        408 => [
            'title'       => 'Request Timeout',
            'description' => 'Сервер ожидал запрос слишком долго.',
            'headers'     => ['X-Error-Type' => 'client-error', 'X-Error-Category' => 'timeout', 'Connection' => 'close'],
        ],
        429 => [
            'title'       => 'Too Many Requests',
            'description' => 'Пользователь отправил слишком много запросов за короткий промежуток времени.',
            'headers'     => ['X-Error-Type' => 'client-error', 'X-Error-Category' => 'rate-limit', 'Retry-After' => '60'],
        ],
        500 => [
            'title'       => 'Internal Server Error',
            'description' => 'Внутренняя ошибка сервера. Сервер столкнулся с непредвиденной ситуацией.',
            'headers'     => ['X-Error-Type' => 'server-error', 'X-Error-Category' => 'internal'],
        ],
        502 => [
            'title'       => 'Bad Gateway',
            'description' => 'Сервер, действуя как шлюз, получил недопустимый ответ от вышестоящего сервера.',
            'headers'     => ['X-Error-Type' => 'server-error', 'X-Error-Category' => 'gateway'],
        ],
        503 => [
            'title'       => 'Service Unavailable',
            'description' => 'Сервер временно недоступен (перегрузка или техническое обслуживание).',
            'headers'     => ['X-Error-Type' => 'server-error', 'X-Error-Category' => 'availability', 'Retry-After' => '120'],
        ],
        504 => [
            'title'       => 'Gateway Timeout',
            'description' => 'Сервер-шлюз не получил своевременного ответа от вышестоящего сервера.',
            'headers'     => ['X-Error-Type' => 'server-error', 'X-Error-Category' => 'gateway-timeout', 'Connection' => 'close'],
        ],
    ];

    public static function all(): array
    {
        return self::$map;
    }

    public static function get(int $code): ?array
    {
        return self::$map[$code] ?? null;
    }

    public static function responseHeaders(int $code, array $extra = []): array
    {
        $base = self::$map[$code]['headers'] ?? [];

        return array_merge($base, [
            'X-Error-Code'  => (string) $code,
            'Cache-Control' => 'no-store, no-cache',
        ], $extra);
    }
}
