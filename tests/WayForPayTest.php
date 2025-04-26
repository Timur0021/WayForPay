<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Venom\WayForPay;

class WayForPayTest extends TestCase
{
    public function testPaySuccess()
    {
        $account = 'your_account';
        $secretKey = 'your_secret_key';
        $domainMerchant = 'your_domain_merchant';

        $wayForPay = new WayForPay($account, $secretKey, $domainMerchant);

        $orderNum = rand(100000, 999999);;
        $amount = 100.00;
        $currencyCode = 'UAH';
        $returnUrl = 'https://example.com/return';
        $webhookUrl = 'https://example.com/webhook';
        $orderName = 'Test Order';

        $response = $wayForPay->pay($orderNum, $amount, $currencyCode, $returnUrl, $webhookUrl, $orderName);

        $this->assertIsArray($response);

        if ($response['transactionStatus'] === 'Declined') {
            $this->assertArrayHasKey('reason', $response);
            $this->assertContains($response['reason'], ['Merchant Restriction', 'Duplicate Order ID']);
        } else {
            $this->assertArrayHasKey('url', $response);
        }
    }

    public function testPayWithError()
    {
        $account = 'your_account';
        $secretKey = 'invalid_secret_key';
        $domainMerchant = 'your_domain_merchant';

        $wayForPay = new WayForPay($account, $secretKey, $domainMerchant);

        $orderNum = 123456;
        $amount = 100.00;
        $currencyCode = 'USD';
        $returnUrl = 'https://example.com/return';
        $webhookUrl = 'https://example.com/webhook';
        $orderName = 'Test Order';

        $response = $wayForPay->pay($orderNum, $amount, $currencyCode, $returnUrl, $webhookUrl, $orderName);

        $this->assertIsArray($response);

        $this->assertArrayHasKey('reason', $response);

        $this->assertNotNull($response['reason']);
        $this->assertStringContainsString('Merchant Restriction', $response['reason']);
    }
}