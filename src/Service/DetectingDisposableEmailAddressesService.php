<?php

declare(strict_types=1);

namespace App\Service;

use App\Util\Response as MessageResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DetectingDisposableEmailAddressesService.
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
final class DetectingDisposableEmailAddressesService
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws \Exception
     */
    public function isDisposableEmail(string $email): string
    {
        $url = sprintf('%s%s', 'https://disposable.debounce.io/?email=', $email);

        try {
            $response = $this->client->request('GET', $url);
        } catch (GuzzleException $exception) {
            throw new \Exception($exception->getMessage().' ('.$exception->getCode().')');
        }

        $result = new MessageResponse($response);

        if (Response::HTTP_OK === $result->getStatusCode()) {
            return $result->getData()['disposable'];
        }

        throw new \Exception('Error');
    }
}
