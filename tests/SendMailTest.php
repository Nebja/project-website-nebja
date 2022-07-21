<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SendMailTest extends  WebTestCase
{
    /** @test */
    public function  emails_are_sent_correctly(): void
    {
        //setup
        $client = static::createClient();
        // perform an action
        $client->request('GET', '/sendEmail');

        // Make assertions
        $sentMail= self::getMailerMessage();
        // 1 email sent
        self::assertEmailCount(1);
        //Sent to the correct person
        self::assertEmailHeaderNotSame($sentMail, 'to','nebwebsites@nebja.eu');
        // Has correct body content
        self::assertEmailTextBodyContains($sentMail, 'See Twig integration for better HTML integration!');
    }
}
