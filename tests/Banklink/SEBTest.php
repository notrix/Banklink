<?php

namespace Banklink;

use Banklink\SEB;
use Banklink\Protocol\iPizza;

/**
 * @author Roman Marintsenko <inoryy@gmail.com>
 * @since  31.10.2012
 */
class SEBTest extends \PHPUnit_Framework_TestCase
{
    private $seb;

    public function setUp()
    {
        $protocol = new iPizza(
            'uid258629',
            'Test Testov',
            '119933113300',
            __DIR__.'/data/iPizza/private_key.pem',
            __DIR__.'/data/iPizza/public_key.pem',
            'http://www.google.com'
        );

        $this->seb = new SEB($protocol);
    }

    public function testPreparePaymentRequest()
    {
        $expectedRequestData = array(
          'VK_SERVICE'  => '1002',
          'VK_VERSION'  => '008',
          'VK_SND_ID'   => 'uid258629',
          'VK_STAMP'    => '1',
          'VK_AMOUNT'   => '100',
          'VK_CURR'     => 'EUR',
          'VK_ACC'      => '119933113300',
          'VK_NAME'     => 'Test Testov',
          'VK_REF'      => '13',
          'VK_MSG'      => 'Test payment',
          'VK_RETURN'   => 'http://www.google.com',
          'VK_CANCEL'   => 'http://www.google.com',
          'VK_LANG'     => 'ENG',
          'VK_CHARSET'  => 'UTF-8',
          'VK_MAC'      => 'SRXrsL3ek9dulUyDRHmg/2Wxc2GkvzXGl7/yJ2M6liRfTBN1pQ3KWYixiNqWGGQWTXo3uAVhqdIDf7Fxf/UT6nJpkq4LcstkSH14Y6T87mtMFaCvLuy9tJzS81197sm0qScAEkmxciWXbYy5hurSdikjQDtdN3W3L750t42ps8i9+EP15wOUq3yBDgal8Z7p2IGaGitsZkzCGlIeOOeD2xGotIXRYvpzsKbUcFj67YgOJSLKU1sy7DpVf09iuhx34g7IZZ2xwbyKYdf3VKvAoy6p2iYvlU3JRPTPpxP/s+1tYpAcXvMZKOye9BJNi9bKRgusN9AFAaKs0hPMtjOJnA=='
        );

        $request = $this->seb->preparePaymentRequest(1, 100, 'Test payment', 'ENG', 'EUR');

        $this->assertEquals($expectedRequestData, $request->getRequestData());
        $this->assertEquals('https://www.seb.ee/cgi-bin/unet3.sh/un3min.r', $request->getRequestUrl());
    }
}
