<?php

use PHPUnit\Framework\TestCase;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;


class ChangePasswordTests extends TestCase {
    private $driver = null ;
    
    protected function setUp():void{

        $this->driver = RemoteWebDriver::create('http://localhost:4444',DesiredCapabilities::chrome());
        $this->driver->manage()->window()->maximize();
        $this->driver->manage()->timeouts()->implicitlyWait(5);
        $this->driver->get("http://www.juliodelima.com.br/taskit");
        $this->driver->findElement(WebDriverBy::linkText('Sign in'))->click();
        $this->driver->findElement(WebDriverBy::cssSelector('#signinbox input[name="login"]'))->sendKeys('bruno.prado');
        $this->driver->findElement(WebDriverBy::cssSelector('#signinbox input[name="password"]'))->sendKeys('1234');
        $this->driver->findElement(WebDriverBy::cssSelector('#signinbox'))->findElement(WebDriverBy::linkText('SIGN IN'))->click();   
    }
    protected function tearDown():void{
        $this->driver->quit();
    }
    public function testChangePassword() {
        // Arrange
        $this->driver->findElement(WebDriverBy::className('me'))->click();
        $this->driver->findElement(WebDriverBy::cssSelector('a[href="#secret"]'))->click();
        $this->driver->findElement(WebDriverBy::cssSelector('input[name="password"]'))->sendKeys('123456789');
        $password = $this->driver->findElement(WebDriverBy::cssSelector('input[name="password"]'))->getAttribute('value');
        $passwordSize = strlen($password);

#moredata > div.row.center > button
        // Assert
        $this->assertThat(
            $passwordSize,
            $this->logicalAnd(
                $this->greaterThanOrEqual(8),
                $this->lessThanOrEqual(12)
            ),"Ola"
        );
    }
   }


//Cenário:



