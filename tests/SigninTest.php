<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\WebDriverExpectedCondition;
class SignInTests extends TestCase {
    private $navegador;

    protected function setUp() : void {
        $this->navegador = RemoteWebDriver::create('http://localhost:4444', DesiredCapabilities::chrome());
        $this->navegador->get('http://www.juliodelima.com.br/taskit');
        $this->navegador->manage()->window()->maximize();
        $this->navegador->manage()->timeouts()->implicitlyWait(5);
        $this->login();
    }
    public function login()
    {
           // Clicar em .hide-on-med-and-down a[data-target="signinbox"]
           $this->navegador
           ->findElement(WebDriverBy::cssSelector('.hide-on-med-and-down a[data-target="signinbox"]'))
           ->click();
         // Digitar julio0001 em #signinbox input[name="login"]
         $this->navegador
             ->findElement(WebDriverBy::cssSelector('#signinbox input[name="login"]'))
             ->sendKeys('bruno.prado');
         // Digitar 123456 em #signinbox input[name="password"]
         $this->navegador
             ->findElement(WebDriverBy::cssSelector('#signinbox input[name="password"]'))
             ->sendKeys('1234');
         // Clicar em SIGN IN
         
         $this->navegador
             ->findElement(WebDriverBy::id('signinbox'))
             ->findElement(WebDriverBy::linkText('SIGN IN'))
             ->click();       
     
    }
    protected function tearDown() : void {
        $this->navegador->quit();
    }

    // public function testSignInOnTaskit() {
    //     // Validar que o elemento da class me tem o texto Hi, Julio
    //     $meuNome = $this->navegador->findElement(WebDriverBy::className('me'))->getText();
    //     $this->assertEquals("Hi, Bruno Cavalcanti Pra", $meuNome);
    // }

    // public function testSignChangePassword() {
    //     $this->navegador->findElement(WebDriverBy::className('me'))->click();

    //     $this->navegador->findElement(WebDriverBy::linkText('SECRET, SHHHH!'))->click();        

    //     $this->navegador->findElement(WebDriverBy::name('password'))->sendKeys('1234');

    //     $this->navegador->findElement(WebDriverBy::id('changeMyPassword'))->click();

    //     $mensagem = $this->navegador->findElement(WebDriverBy::id('toast-container'))->getText();

    //     $this->assertEquals('You have a new secret, please do not share it!', $mensagem);
    // }

    public function directMoreData(Type $var = null)
    {
        // CLICAR EM HI, BRUNO
        $this->navegador->findElement(WebDriverBy::className('me'))->click();

        //CLICAR EM More data about you
        $this->navegador->findElement(WebDriverBy::cssSelector('a[href="#moredata"]'))->click();
    }
    public function addAbount()
    {
        $this->directMoreData();

            // CLICLAR ADD MORE DATA
            $this->navegador->findElement(WebDriverBy::cssSelector('button[data-target="addmoredata"]'))->click();
    
            // ESCOLHER PHONE
            $fieldType = $this->navegador->findElement(WebDriverBy::name('type'));
            $comboType = new WebDriverSelect($fieldType);
            $comboType->selectByValue('phone');
    
            // DIGITAR PHONE
            $this->navegador->findElement(WebDriverBy::cssSelector('input[name="contact"]'))->sendKeys('123441654');
    
            // CLICAR EM SALVAR
            $this->navegador->findElement(WebDriverBy::linkText('SAVE'))->click();
            
            //VALIDAR MSG
            $wait = new WebDriverWait($this->navegador, 10, 50);
            $toast = WebDriverBy::className('toast');
            $element =WebDriverExpectedCondition::visibilityOfElementLocated($toast);
            $wait->until($element);
            $text = $this->navegador->findElement($toast)->getText();
            $this->assertEquals('Your contact has been added!', $text);
            
            //SUMIR MSG
            $wait->until((WebDriverExpectedCondition::invisibilityOfElementLocated($toast)));
    
            //FECHAR 
            $this->navegador->findElement(WebDriverBy::linkText('Logout'))->click();
    }
    public function testAddAbount(){
        $this->addAbount();

    }
    public function visibleToast()
    {
        $wait = new WebDriverWait($this->navegador, 10, 50);
        $toast = WebDriverBy::className('toast');
        $element =WebDriverExpectedCondition::visibilityOfElementLocated($toast);
        $wait->until($element);
        $text = $this->navegador->findElement($toast)->getText();
        return $text;
    }

    public function invisibilityToast()
    {
        $wait = new WebDriverWait($this->navegador, 10, 50);
        $toast = WebDriverBy::className('toast');
        $element =WebDriverExpectedCondition::invisibilityOfElementLocated($toast);
        $wait->until($element);
    }

    public function testRemoveAbount()
    {   $this->addAbount();
        $this->login();
        $this->directMoreData();  
        $item = $this->navegador->findElement(WebDriverBy::cssSelector('ul[class="collection"]>li[class="collection-item avatar"]:last-child>a[class="secondary-content button"]'));
        $item->click();
        $alerta = $this->navegador->switchTo()->alert();
        $alerta->getText();
        $alerta->accept();
        $text= $this->visibleToast();
        $this->navegador->takeScreenshot('evidencies/screenshot_removeu.jpg');
        $this->invisibilityToast();
        $this->navegador->findElement(WebDriverBy::linkText('Logout'))->click();

        $this->assertEquals('Rest in peace, dear phone!', $text);

    }

    
}