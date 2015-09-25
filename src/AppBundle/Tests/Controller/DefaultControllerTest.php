<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }
    
    public function testForm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/form');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Symfony', $crawler->filter('#container h1')->text());
        
        ///// Get the form and set values
        $form = $crawler->selectButton('Submit')->form();

        // set some values
        $form['form[name]'] = 'Lucas';

        // submit the form
        $crawler = $client->submit($form);
        
        $this->assertContains(
            'Lucas',
            $crawler->filter('p')->text()
        );
    }
    
    public function testFormPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/form');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Symfony', $crawler->filter('#container h1')->text());
        
        // Get token
        $token = $crawler
            ->filter('form input[type=hidden][name*="_token"]')
            ->attr('value');
        
        ///// Send values directly
        $crawler = $client->request(
            'POST',
            '/form',
            array(
                'form' => array(
                    'name' => 'Fabien',
                    '_token' => $token,
                )
            )
        );
        
        $this->assertContains(
            'Fabien',
            $crawler->filter('p')->text()
        );
    }
    
    public function testFormSetAndPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/form');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Symfony', $crawler->filter('#container h1')->text());
        
        ///// Get the form and set values
        $form = $crawler->selectButton('Submit')->form();

        // set some values
        $form['form[name]'] = 'Lucas';

        // submit the form
        $crawler = $client->submit(
            $form,
            array('missing_field' => 1)
        );
        
        $this->assertContains(
            'Lucas',
            $crawler->filter('p')->text()
        );
    }
}
