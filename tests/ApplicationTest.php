<?php
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase {

  public function testConstructorApiKey()
  {
      $a = new DialOnce\Application('qpvao53b1x10z7u3906wvgzmvexuxwxj', '56g5jvhlciv9e0l4izccjqkf54okh21jbn4d4yj7');
      $this->assertFalse(empty($a->getAccessToken()));
      $this->assertTrue(strlen($a->getAccessToken()) > 8);
  }

  public function testConstructorException()
  {
      $this->expectException(Exception::class);
      $a = new DialOnce\Application('qpvao53b1x10z7u3', '56g5jvhlciv9e0l');
  }

  public function testConstructorToken()
  {
      $a = new DialOnce\Application('qpvao53b1x10z7u3906wvgzmvexuxwxj');
      $this->assertTrue($a->getAccessToken() === 'qpvao53b1x10z7u3906wvgzmvexuxwxj');
  }
}
