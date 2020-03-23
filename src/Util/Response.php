<?php

declare(strict_types=1);

namespace App\Util;

use Psr\Http\Message\ResponseInterface;

/**
 * Class Response.
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
final class Response
{
    /**
     * @var array
     */
    private array $data;

    /**
     * @var int
     */
    private int $statusCode;

    public function __construct(ResponseInterface $response)
    {
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        if ('No error' !== json_last_error_msg()) {
            throw new \Exception(json_last_error_msg().': '.$content);
        }
        $this->statusCode = $response->getStatusCode();
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
