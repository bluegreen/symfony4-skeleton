<?php

declare(strict_types=1);

namespace App\Tests;

use App\Service\DetectingDisposableEmailAddressesService;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class DetectingDisposableEmailAddressTest extends TestCase
{
    public function testDisposableEmail(): void
    {
        $detectDisposableEmailService = new DetectingDisposableEmailAddressesService(new Client([]));
        $result = $detectDisposableEmailService->isDisposableEmail('radoslaw.skrzypczak@pearfly.pl');

        $this->assertEquals('false', $result);
    }

}