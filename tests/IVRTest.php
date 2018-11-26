<?php
use phpunit\framework\TestCase;

class IVRTest extends TestCase {

  private $app;

  protected function setUp() {
    $this->app = new DialOnce\Application('qpvao53b1x10z7u3906wvgzmvexuxwxj', '56g5jvhlciv9e0l4izccjqkf54okh21jbn4d4yj7');
  }

  /**
  * @expectedException PHPUnit_Framework_Error
  * @expectedExceptionMessage  Argument 1 passed to DialOnce\IVR::__construct() must be an instance of DialOnce\Application, null given
  */
  public function testConstructorException()
  {
      if (class_exists(TypeError::class)) {
        $this->expectException(TypeError::class);
      }
      new DialOnce\IVR(NULL, '+33601010101', '1010');
  }

  public function testIsMobile()
  {
      $ivr = new DialOnce\IVR($this->app, '+33601010101', '1010');
      $this->assertTrue($ivr->isMobile());
  }

  public function testIsNotMobile()
  {
      $ivr = new DialOnce\IVR($this->app, '+33101010101', '1010');
      $this->assertFalse($ivr->isMobile());
  }

  public function testIsEligible()
  {
      $ivr = new DialOnce\IVR($this->app, '+33601010101', '1010');
      $this->assertTrue($ivr->isEligible());
  }

  public function testLogDefault()
  {
      $ivr = new DialOnce\IVR($this->app, '+33601010101', '1010');
      $ivr->log();
  }

  public function testLog()
  {
      $ivr = new DialOnce\IVR($this->app, '+33601010101', '1010');
      $ivr->log('call-end');
  }

  public function testServiceRequest()
  {
      $ivr = new DialOnce\IVR($this->app, '+33601010101', '1010');
      $ivr->serviceRequest();
  }
}
