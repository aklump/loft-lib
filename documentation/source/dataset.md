# Dataset

## Quick Start

1. First create a class that extends `Dataset`. It must implement these protected methods, which define the schema of the dataset.
    
    1. acceptKeys
    1. requireKeys
    5. describe
    3. defaults
    4. types
    2. match
    
3. Then implement an instance in your code like this:
    
        <?php
        $data = ['id' => 123];
        ...
        try {
            $timer = Timer::dataset($data)->validate()->throwFirstProblem();
          } catch (\Exception $exception) {
            // Do something if validation failed.
        }

## Accessing Data

1. Get the complete dataset as an array (sorted, with defaults, etc): `$array = $data->get()`
2. Get the JSON value of the dataset by casting to a string: `$json = strval($data)`.
3. Use a property directly: `$id = $data->id`
4. Use a property's alias directly: `$id = $data->userId`.  Read about aliases for more info.

## Accessing Defaults

5. Get the default for single key: `Timer::getDefault('id')`.
6. Get an array of defaults: `Timer::getDefaults()`

## Detecting Errors

1. Return an array of all: `$data->getProblems`.
1. Throw an _\InvalidArgumentException_ with the first problem: `$data->throwFirstError`

## Setting Data

* You cannot set data directly.
* You must do an new import, following a get.


## Aliases

@todo

## Custom Validation

1. If you have advanced validation beyond what comes for free, you may extend `validate()`, but read the docs there for what needs to happen.
2. Consider using `ignoreKey()` instead, if possible.

## How to Ignore a Key in Your Dataset (so as to not cause validation error)

    protected static function ignoreKey($key)
    {
        return $key === 'duration';
    }

    protected static function ignoreKey($key)
    {
        return strpos($key, '#') === 0;
    }

## Notes

* To ignore some keys use `static::ignoreKey()` in your class.

## Advanced Usage

### Auto-generate Values: Example 1

The time to do this is during `::import`. 

    <?php
    
    /**
     * Import extra data based on a default value.
     *
     * In this example, the defaults set the user id by global var.  During import
     * we check for a user_id, either by import $data or the default data.  Then we
     * make sure the the $original import data doesn't contain session_id, and if
     * so we pull that data from the user account object.
     */
    class Alpha extends Dataset {
    
      ... 
      
      /**
       * {@inheritdoc}
       */
      protected static function defaults() {
        global $user;
    
        return [
          'user_id' => $user->uid,
          'session_id' => -1,
        ];
      }
    
      /**
       * {@inheritdoc}
       */
      public function import($data) {
        $original = $data;
        $data += static::getDefaults();
    
        // Figure the session id based on the last time the user logged in.
        // https://amplitude.zendesk.com/hc/en-us/articles/115002323627-Sessions
        if ($data['user_id'] && empty($original['session_id'])) {
          $account = user_load($data['user_id']);
    
          // We will count our session based on last login.
          // https://drupal.stackexchange.com/questions/21864/whats-the-difference-between-user-login-and-access#21873
          $data['session_id'] = $account->login * 1000;
        }
    
        return parent::import($data);
      }
      
    }
