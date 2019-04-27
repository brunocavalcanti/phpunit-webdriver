<?php

use PHPUnit\Framework\TestCase;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;


class ChangePasswordTests extends TestCase {
    public function testChangePassword() {
    // Arrange
    $driver = RemoteWebDriver::create('http://localhost:4444',DesiredCapabilities::chrome());
    $driver->manage()->window()->maximize();
    $driver->manage()->timeouts()->implicitlyWait(5);
    $driver->get("http://www.juliodelima.com.br/taskit");

    // Act
    $driver->findElement(WebDriverBy::linkText('Sign in'))->click();
    $driver->findElement(WebDriverBy::cssSelector('#signinbox input[name="login"]'))->sendKeys('bruno.prado');
    $driver->findElement(WebDriverBy::cssSelector('#signinbox input[name="password"]'))->sendKeys('1234');
    $driver->findElement(WebDriverBy::cssSelector('#signinbox'))->findElement(WebDriverBy::linkText('SIGN IN'))->click();
    $driver->findElement(WebDriverBy::className('me'))->click();
    $driver->findElement(WebDriverBy::cssSelector('a[href="#secret"]'))->click();
    $driver->findElement(WebDriverBy::cssSelector('input[name="password"]'))->sendKeys('123456789');
    $password = $driver->findElement(WebDriverBy::cssSelector('input[name="password"]'))->getAttribute('value');
    $passwordSize = strlen($password);


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



