<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityTest extends WebTestCase
{
    public function register($client)
    {
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton('Register')->form();
        $form['registration_form[email]'] = 'test@test.com';
        $form['registration_form[plainPassword]'] = '12345678';
        $client->submit($form);
        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function login($client)
    {

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Sign in')->form();
        $form['email'] = 'test@test.com';
        $form['password'] = '12345678';
        $client->submit($form);

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }



    public function logout($client)
    {
        $crawler = $client->request('GET', '/');

        $link = $crawler
            ->filter('#disconect')
            ->eq(0)
            ->link()
        ;

        $client->click($link);
        $client->request('GET', '/');

        $this->assertNotEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testSecurity()
    {
        $client = static::createClient();

        $this->register($client);
        $this->logout($client);
        $this->login($client);
    }
}
?>