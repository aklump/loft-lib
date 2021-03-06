<?php
/**
 * @file
 * Defines the Bash class.
 *
 * @ingroup bash
 * @{
 */

namespace AKlump\LoftLib\Bash;

use AKlump\LoftLib\Storage\FilePath;

/**
 * Represents a class to help with connecting PHP to BASH scripts.
 *
 * @brief Integrates Php with BASH.
 *
 * For the scope of this class, the fallowing definitions are made.  Using the
 * following bash script call as an example:
 *
 *   twigphp . --save --to=theme -f
 *
 * The argumets are: .
 * The flags are: f
 * The parameters are: save, to
 *
 * Flags begin with a single - and do not contain a value, they are bool.
 * Params begin with -- and may contain a value (indicated by the = sign)
 *
 * THESE ELEMENTS CAN APPEAR IN ANY ORDER.
 */
class Bash {

  /**
   * Use this to cache expensive calculations in the object.
   *
   * Child classes must namespace like this:
   * $this->cache->{ChildClass}->{key}. And should declare the cache object
   * in the constructor like this:
   *
   * @code
   *   parent::__construct(...);
   *   $this->cache->{ChildClass} = new \StdClass;
   * @endcode
   *
   * @var object
   */
  protected $cache;

  /**
   * Constructor
   *
   * @param array $args By default you may omit this and $argv will be used.
   */
  public function __construct($args = NULL) {
    global $argv;
    if (!isset($args)) {
      $args = $argv;
      $args = array_slice($args, 1);
    }
    $csv = implode(',', array_values($args));
    $this->cache = new \stdClass;
    $this->cache->Bash = new \stdClass;
    $this->cache->Bash->args = array();
    $this->cache->Bash->flags = array();
    $this->cache->Bash->params = array();

    // Pull params
    if ($csv && preg_match_all("/\-\-([^=,]+)(?:=([^,]+))?/", $csv, $matches)) {
      foreach ($matches[0] as $key => $find) {
        $del = array_search($find, $args);
        unset($args[$del]);
        $this->cache->Bash->params[$matches[1][$key]] = $matches[2][$key];
      }
    }

    // Pull flags
    foreach ($args as $key => $value) {
      if (strpos($value, '-') === 0) {
        unset($args[$key]);
        $this->cache->Bash->flags[] = ltrim($value, '-');
      }
    }

    $this->cache->Bash->args = array_values($args);
  }

  /**
   * Locate a shell program file in the user's path.
   *
   * @param string $name
   *
   * @return null|string
   * @throws \AKlump\LoftLib\Component\Bash\FailedExecException
   */
  public static function which($name) {
    $path = static::exec("type $name >/dev/null &2>&1 && which $name");

    return $path ? $path : NULL;
  }

  /**
   * Use this for executing bash commands instead of exec().
   *
   * This handles redirecting the error and capturing it as an exception.
   *
   * @param string|array $command
   *   Arrays will be imploded with ' '.
   * @param array $args
   *   Only pass this if you have an array of arguments that you want to pass
   *   to $command.  They will be wrapped with double quotes.  If you don't
   *   want to wrap in double quotes, then just pass an array as $command.
   * @param bool $async
   *   Set to TRUE to run the command async.  You can review the result via the
   *   return object AsyncResult().
   *
   * @return string
   *   The output from the $command.
   *
   * @throws AKlump\LoftLib\Component\Bash\FailedExecException if the command
   * @throws \AKlump\LoftLib\Bash\FailedExecException
   *   returns a non 0 status.  The exception code holds the return status.
   */
  public static function exec($command, $args = [], $async = FALSE) {

    // Wrap all args in "".
    $args = array_map(function ($item) {
      return '"' . $item . '"';
    }, $args);
    if (is_string($command)) {
      $command = [$command];
    }
    $command = array_merge($command, $args);
    $command = implode(' ', $command);

    if ($async) {
      $output_file = FilePath::create(sys_get_temp_dir(), ['autoname' => '.output'])
        ->getPath();
      exec(sprintf("%s > %s 2>&1 &", $command, $output_file));

      return new AsyncResult($output_file);
    }
    else {
      if (!strpos($command, ' 2>&1')) {
        $command .= ' 2>&1';
      }
      exec($command, $result, $status);
      if ($status !== 0) {
        throw new FailedExecException(implode(PHP_EOL, $result), $status);
      }

      return implode(PHP_EOL, $result);
    }
  }

  public function getArgs() {
    return $this->cache->Bash->args;
  }

  /**
   * Returns an argument by index.
   *
   * @param int $index Be aware that a zero index here may point to
   *                         $argv[1].
   * @param string $default The default ot return if not found.
   *
   * @return string|NULL
   */
  public function getArg($index, $default = NULL) {
    return isset($this->cache->Bash->args[$index])
      ? (is_numeric($this->cache->Bash->args[$index]) ? $this->cache->Bash->args[$index] * 1 : $this->cache->Bash->args[$index])
      : $default;
  }

  public function hasFlag($flag) {
    return in_array($flag, $this->getFlags());
  }

  public function getFlags() {
    return $this->cache->Bash->flags;
  }

  public function hasParam($param) {
    return array_key_exists($param, $this->getParams());
  }

  public function getParams() {
    return $this->cache->Bash->params;
  }

  /**
   * Return the value of a single parameter.
   *
   * @param string $param The param name
   * @param string $default The default ot return if not found.
   *
   * @return mixed|NULL
   */
  public function getParam($param, $default = NULL) {
    return ($p = $this->getParams()) && isset($p[$param])
      ? (is_numeric($p[$param]) ? $p[$param] * 1 : $p[$param])
      : $default;
  }

  /**
   * Searches parent directories for a file
   *
   * @param $dir    The starting directory, it and then it's parents will be
   *                searched for $needle.
   * @param $needle The filename to search for.
   *
   * @return bool|string
   */
  public function upfind($dir, $needle) {
    $path = rtrim($dir, '/') . '/' . $needle;
    if (file_exists($path)) {
      return $path;
    }
    elseif (($dir = dirname($dir))) {
      return $this->upfind($dir, $needle);
    }

    return FALSE;
  }

  /**
   * Prompt user to confirm one of several options.
   *
   * @param string $label
   *   The label to use for the prompt.  This may include the token OPTIONS
   *   which will be replaced with a CSV string of the $valid_input, e.g. 'Are
   *   you sure? OPTIONS'.
   * @param array|string[] $options
   *   An array of valid answers, the prompt will only allow one of these
   *   answers.
   * @param string $invalid_message
   *   The message to print if an invalid input is received.
   * @param bool $ignore_case
   *   Set this to false for case checking on the response.
   *
   * @return mixed|string
   *   The accepted user response; one of $options.
   */
  public static function confirm(string $label, array $options = [
    'y',
    'n',
  ], string $invalid_message = ' 👈 is not one of OPTIONS', bool $ignore_case = TRUE
  ) {
    $command = ['read'];
    $max_chars = 0;
    foreach ($options as $input) {
      $max_chars = max($max_chars, strlen($input));
    }
    $command[] = "-n $max_chars";
    $detoken = function ($string) use ($options) {
      return str_replace('OPTIONS', sprintf('(%s)', implode('/', $options)), $string);
    };
    if ($label) {
      $label = $detoken($label);
      $command[] = "-p \"$label \"";
    }
    $command = implode(' ', $command);
    if ($ignore_case) {
      $options = array_map('strtolower', $options);
    }
    while (!in_array($user_input, $options)) {
      if ($user_input) {
        echo Color::wrap('red', $detoken($invalid_message));
        echo PHP_EOL;
      }
      $command_response = [];
      exec($command . ' input && echo $input', $command_response);
      $user_input = $command_response[0];
      if ($ignore_case) {
        $user_input = strtolower($user_input);
      }
    }
    echo PHP_EOL;

    return $user_input;
  }

}
