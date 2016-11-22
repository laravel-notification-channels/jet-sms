<?php
/**
 * Author: Hilmi Erdem KEREN
 * Date: 22/11/2016
 * Time: 13:37
 */

namespace NotificationChannels\JetSMS\Test;

use NotificationChannels\JetSMS\Clients\Http\JetSMSHttpApiResponse;

class JetSMSHttpApiResponseTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function error_message_return_null_when_the_status_code_is_zero()
    {
        $httpApiResponse = new JetSMSHttpApiResponse("Status=0\r\nMessageIDs=151103141334228\r\nType=Fake\r\n");

        $this->assertNull($httpApiResponse->errorMessage());
    }
}
