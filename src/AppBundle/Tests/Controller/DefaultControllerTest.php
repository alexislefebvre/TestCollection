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

        $crawler = $client->request('GET', '/task');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $formTag = $crawler->filter('form');

        $this->assertEquals(
            2,
            $formTag->filter('ul > li')->count()
        );

        ///// Get the form and set values
        $form = $crawler->selectButton('Save')->form();

        // set some values
        $form['task[description]'] = 'Lucas';

        // submit the form
//        $crawler = $client->submit(
//            $form,
//            array('missing_field' => 1)
//        );

        $values = array_merge_recursive(
            $form->getPhpValues(),
            array(
                'task' => array(
                    'tags' => array(
                        // Key will be added automatically.
                        array('name' => 'tag3'),
                    )
                )
            )
        );

        $crawler = $client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());

        $this->assertEquals(
            1,
            $crawler->filter('div.flash-notice')->count()
        );
        $this->assertContains(
            'Your changes were saved!',
            $crawler->filter('div.flash-notice')->text()
        );

        $this->assertEquals(
            3,
            $crawler->filter('ul > li')->count()
        );

        // One value (Tag) has been added.
        $inputs = $crawler->filter('ul > li input[type="text"]');
        $this->assertEquals(
            3,
            $inputs->count()
        );
        $this->assertEquals(
            'tag1',
            $inputs->eq(0)->attr('value')
        );
        $this->assertEquals(
            'tag2',
            $inputs->eq(1)->attr('value')
        );
        $this->assertEquals(
            'tag3',
            $inputs->eq(2)->attr('value')
        );
    }
}
