# CollectionBundle

Use code from http://symfony.com/doc/2.8/cookbook/form/form_collections.html

## Steps:
 
 1. Clone this repository
 2. Install the dependencies `composer install --prefer-dist -vvv --profile`
 3. Open `/web/app_dev.php/task`
 4. Problem: how to get the form through `$crawler->filter('form')->form()` and add fields?

## Tests

If `phpunit` is installed:

    phpunit -c app/phpunit.xml.dist

Or by installing `phpunit` with Composer:

    php vendor/bin/phpunit -c app/phpunit.xml.dist

## Result

    $ php vendor/phpunit/phpunit/phpunit -c app/phpunit.xml.dist
    PHPUnit 4.8.9 by Sebastian Bergmann and contributors.
    
    ...E
    
    Time: 857 ms, Memory: 45.75Mb
    
    There was 1 error:
    
    1) AppBundle\Tests\Controller\DefaultControllerTest::testFormSetAndPost
    InvalidArgumentException: Unreachable field "missing_field"

    ./TestCollection/vendor/symfony/symfony/src/Symfony/Component/DomCrawler/FormFieldRegistry.php:89
    ./TestCollection/vendor/symfony/symfony/src/Symfony/Component/DomCrawler/FormFieldRegistry.php:126
    ./TestCollection/vendor/symfony/symfony/src/Symfony/Component/DomCrawler/Form.php:83
    ./TestCollection/vendor/symfony/symfony/src/Symfony/Component/BrowserKit/Client.php:269
    ./TestCollection/src/AppBundle/Tests/Controller/DefaultControllerTest.php:94
    
    FAILURES!
    Tests: 4, Assertions: 10, Errors: 1.
