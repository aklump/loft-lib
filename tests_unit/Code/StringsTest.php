<?php

namespace AKlump\LoftLib\Tests\Code;

use PHPUnit\Framework\TestCase;
use AKlump\LoftLib\Code\Strings;

/**
 * Test coverate for Strings class.
 *
 * @covers \AKlump\LoftLib\Code\Strings
 */
class StringsTest extends TestCase {

  /**
   * Provides data for testEndsWithSentenceWorksAsExpected.
   */
  public static function dataForTestEndsWithSentenceWorksAsExpectedProvider() {
    $tests = array();
    $tests[] = array(
      'lorem ipsum dolar sit',
      'lorem ipsum dolar sit',
    );
    $tests[] = array(
      'lorem ipsum. dolar sit',
      'lorem ipsum.',
    );
    $tests[] = array(
      'lorem ipsum." dolar sit',
      'lorem ipsum."',
    );
    $tests[] = array(
      'lorem ipsum! dolar sit',
      'lorem ipsum!',
    );
    $tests[] = array(
      'lorem ipsum!" dolar sit',
      'lorem ipsum!"',
    );
    $tests[] = array(
      'lorem ipsum? dolar sit',
      'lorem ipsum?',
    );
    $tests[] = array(
      'lorem ipsum?" dolar sit',
      'lorem ipsum?"',
    );

    return $tests;
  }

  /**
   * @dataProvider dataForTestEndsWithSentenceWorksAsExpectedProvider
   */
  public function testEndsWithSentenceWorksAsExpected($subject, $control) {
    $this->assertSame($control, Strings::endsWithSentence($subject));
  }

  /**
   * Provides data for testAcronymWorksAsExpected.
   */
  public static function dataForTestAcronymWorksAsExpectedProvider() {
    $tests = array();

    $tests[] = array(
      'AK',
      'AARON KLUMP',
    );
    $tests[] = array(
      'A',
      'aaron',
    );
    $tests[] = array(
      'BP',
      'big pipe',
    );
    $tests[] = array(
      'BP',
      'big_pipe',
    );
    $tests[] = array(
      'BP',
      'BigPipe',
    );

    return $tests;
  }

  /**
   * @dataProvider dataForTestAcronymWorksAsExpectedProvider
   */
  public function testAcronymWorksAsExpected($control, $subject) {
    $this->assertSame($control, Strings::acronym($subject));
  }

  /**
   * Provides data for testGetFirstNameVariantes.
   */
  public static function dataForTestGetFirstNameVariantesProvider() {
    $tests = array();
    $tests[] = array(
      'Aaron',
      'Smith Johnson, Aaron Eugene',
    );
    $tests[] = array(
      'Aaron',
      'Smith-Johnson, Aaron Eugene',
    );
    $tests[] = array(
      'Aaron',
      'Aaron',
    );
    $tests[] = array(
      'Aaron',
      'Aaron Klump',
    );
    $tests[] = array(
      'Aaron',
      'Mr. Aaron Klump',
    );
    $tests[] = array(
      'Hillary',
      'Mrs. Hillary Klump',
    );
    $tests[] = array(
      'Aaron',
      'Aaron E. Klump',
    );
    $tests[] = array(
      'Aaron',
      'Aaron Eugene Klump',
    );
    $tests[] = array(
      'Aaron',
      'Klump, Aaron',
    );

    return $tests;
  }

  /**
   * @dataProvider dataForTestGetFirstNameVariantesProvider
   */
  public function testGetFirstNameVariantes($control, $subject) {
    $this->assertSame($control, Strings::getFirstName($subject));
  }

  /**
   * Provides data for testSplitByWorksAsPlanned.
   */
  public static function dataForTestSplitByWorksAsPlannedProvider() {
    $tests = array();
    $tests[] = array(
      "In the Loft<br/>Studios",
      'In the Loft Studios',
      2,
      "<br/>",
    );

    $tests[] = array(
      "do\nre",
      'do re',
      2,
      "\n",
    );

    return $tests;
  }

  /**
   * @dataProvider dataForTestSplitByWorksAsPlannedProvider
   */
  public function testSplitByWorksAsPlanned($control, $text, $lineCount, $eol) {
    $this->assertSame($control, Strings::splitBy($text, $eol, $lineCount));
  }

  /**
   * Provides data for testPhoneWorksOnDifferentFormats.
   */
  public static function dataForTestPhoneWorksOnDifferentFormatsProvider() {
    $tests = array();
    $tests[] = array(
      '(123) 555-1212',
      1235551212,
      NULL,
    );
    $tests[] = array(
      '123.555.1212',
      1235551212,
      '%d.%d.%d',
    );

    return $tests;
  }

  /**
   * @dataProvider dataForTestPhoneWorksOnDifferentFormatsProvider
   */
  public function testPhoneWorksOnDifferentFormats($control, $subject, $format = NULL) {
    $result = is_null($format) ? Strings::phone($subject) : Strings::phone($subject, $format);
    $this->assertSame($control, $result);
  }

  /**
   * Provides data for testNoSmartQuotes.
   */
  public static function dataForTestNoSmartQuotesProvider() {
    $tests = array();
    $tests[] = array(
      'That\'s cool!',
      'That‘s cool!',
    );
    $tests[] = array(
      'That\'s cool!',
      'That’s cool!',
    );
    $tests[] = array(
      '"Aaron"',
      '“Aaron”',
    );

    return $tests;
  }

  /**
   * @dataProvider dataForTestNoSmartQuotesProvider
   */
  public function testNoSmartQuotes($control, $subject) {
    $this->assertSame($control, Strings::noSmartQuotes($subject));
  }

  /**
   * @dataProvider dataForTestReplaceUrlsProvider
   */
  public function testReplaceUrlsReplaceWithProvidedString() {
    $this->assertSame('to re <url> and then <url> so that we.', Strings::replaceUrls('to re http://www.phpliveregex.com/ and then https://oscarotero.com/embed3/demo/index.php?url=https%3A%2F%2Ftwitter.com%2Fgoproject%2Fstatus%2F941051874282754048 so that we.', ' <url> '));
  }

  /**
   * Provides data for testReplaceUrls.
   */
  public static function dataForTestReplaceUrlsProvider() {
    $tests = array();

    $tests[] = array(
      'to re and then so that we.',
      'to re http://www.phpliveregex.com/ and then https://oscarotero.com/embed3/demo/index.php?url=https%3A%2F%2Ftwitter.com%2Fgoproject%2Fstatus%2F941051874282754048 so that we.',
    );

    $tests[] = array(
      '“Educational initiatives that include time in nature are shown to serve children\'s physical and mental health as well as boost academic performance:',
      '“Educational initiatives that include time in nature are shown to serve children\'s physical and mental health as well as boost academic performance: HTTP://t.co/RPwUa7fpks”',
    );
    $tests[] = array(
      '“Educational initiatives that include time in nature are shown to serve children\'s physical and mental health as well as boost academic performance:',
      '“Educational initiatives that include time in nature are shown to serve children\'s physical and mental health as well as boost academic performance: http://t.co/RPwUa7fpks”',
    );
    $tests[] = array(
      '“Educational initiatives that include time in nature are shown to serve children\'s physical and mental health as well as boost academic performance:',
      '“Educational initiatives that include time in nature are shown to serve children\'s physical and mental health as well as boost academic performance: https://t.co/RPwUa7fpks”',
    );

    return $tests;
  }

  /**
   * @dataProvider dataForTestReplaceUrlsProvider
   */
  public function testReplaceUrls($control, $subject) {
    $this->assertSame($control, Strings::replaceUrls($subject));
  }

  public function testTitleReturnsUpperCaseWords() {
    $this->assertSame('My Big Toe', Strings::title('my_big_toe'));
    $this->assertSame('My Big Toe', Strings::title('MyBigToe'));
    $this->assertSame('My Big Toe', Strings::title('my big toe'));
    $this->assertSame('My Big Toe', Strings::title('my-big-toe'));
  }

  /**
   * Provides data for testUpperUnderscore.
   */
  public static function dataForTestUpperUnderscoreProvider() {
    $tests = array();
    $tests[] = array('timeForBreakfast');
    $tests[] = array('TimeForBreakfast');
    $tests[] = array('time for breakfast');
    $tests[] = array('time_for_breakfast');
    $tests[] = array('time-for-breakfast');

    return $tests;
  }

  /**
   * @dataProvider dataForTestUpperUnderscoreProvider
   */
  public function testUpperUnderscore($subject) {
    $this->assertSame('TIME_FOR_BREAKFAST', Strings::upperUnderscore($subject));
  }

  /**
   * Provides data for testLowerUnderscore.
   */
  public static function dataForTestLowerUnderscoreProvider() {
    $tests = array();
    $tests[] = array('timeForBreakfast');
    $tests[] = array('TimeForBreakfast');
    $tests[] = array('time for breakfast');
    $tests[] = array('time_for_breakfast');
    $tests[] = array('time-for-breakfast');

    return $tests;
  }

  /**
   * @dataProvider dataForTestLowerUnderscoreProvider
   */
  public function testLowerUnderscore($subject) {
    $this->assertSame('time_for_breakfast', Strings::lowerUnderscore($subject));
  }

  /**
   * Provides data for testLowerHyphen.
   */
  public static function dataForTestLowerHyphenProvider() {
    $tests = array();
    $tests[] = array('timeForBreakfast');
    $tests[] = array('TimeForBreakfast');
    $tests[] = array('time for breakfast');
    $tests[] = array('time_for_breakfast');
    $tests[] = array('time-for-breakfast');

    return $tests;
  }

  /**
   * @dataProvider dataForTestLowerHyphenProvider
   */
  public function testLowerHyphen($subject) {
    $this->assertSame('time-for-breakfast', Strings::lowerHyphen($subject));
  }

  /**
   * Provides data for testNoWhitespace.
   *
   * @return
   *   - 0:
   */
  public static function noWhitespaceProvider() {
    return array(
      array('here we go', 'herewego'),
      array("here\twe\tgo", 'herewego'),
      array("here\nwe\ngo", 'herewego'),
      array("here\rwe\rgo", 'herewego'),
      array("here\t\t\twe\tgo\t\r\n", 'herewego'),
    );
  }

  /**
   * @dataProvider noWhitespaceProvider
   */
  public function testNoWhitespace($in, $out) {
    $this->assertSame($out, Strings::noWhitespace($in));
  }

  /**
   * Provides data for camelCaseTests.
   *
   * @return
   *   - 0:
   */
  public static function transformProvider() {
    return array(
      array(
        'hasUuid',
        'hasUuid',
        'HasUuid',
        'has_Uuid',
        'has Uuid',
        'has-Uuid',
      ),
      array(
        'HasUuid',
        'hasUuid',
        'HasUuid',
        'Has_Uuid',
        'Has Uuid',
        'Has-Uuid',
      ),
      array(
        'has-Uuid',
        'hasUuid',
        'HasUuid',
        'has_Uuid',
        'has Uuid',
        'has-Uuid',
      ),
      array(
        'has_Uuid',
        'hasUuid',
        'HasUuid',
        'has_Uuid',
        'has Uuid',
        'has-Uuid',
      ),
      array(
        'has Uuid',
        'hasUuid',
        'HasUuid',
        'has_Uuid',
        'has Uuid',
        'has-Uuid',
      ),
      array(
        ' has Uuid',
        'hasUuid',
        'HasUuid',
        'has_Uuid',
        'has Uuid',
        'has-Uuid',
      ),
      array(
        'has Uuid ',
        'hasUuid',
        'HasUuid',
        'has_Uuid',
        'has Uuid',
        'has-Uuid',
      ),
      array(
        'has  Uuid',
        'hasUuid',
        'HasUuid',
        'has_Uuid',
        'has Uuid',
        'has-Uuid',
      ),
      array(
        "has\tUuid",
        'hasUuid',
        'HasUuid',
        'has_Uuid',
        'has Uuid',
        'has-Uuid',
      ),
      array(
        "has\nUuid",
        'hasUuid',
        'HasUuid',
        'has_Uuid',
        'has Uuid',
        'has-Uuid',
      ),
    );
  }

  /**
   * @dataProvider transformProvider
   */
  public function testWords($input, $lcc, $ucc, $underscore, $words, $hyphen) {
    $this->assertSame($words, Strings::words($input));
    $this->assertSame($underscore, Strings::underscore($input));
    $this->assertSame($lcc, Strings::lowerCamel($input));
    $this->assertSame($ucc, Strings::upperCamel($input));
    $this->assertSame($hyphen, Strings::hyphen($input));
  }

}
