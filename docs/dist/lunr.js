var lunrIndex = [{"id":"changelog","title":"Changelog","body":"All notable changes to this project will be documented in this file.\n\nThe format is based on [Keep a Changelog](https:\/\/keepachangelog.com\/en\/1.0.0\/), and this project adheres to [Semantic Versioning](https:\/\/semver.org\/spec\/v2.0.0.html).\n\n## [Unreleased]\n\n## [2.1.6] - 2024-07-03\n\n### Fixed\n\n- Bash configuration values with ` are now quoted to fix a recursion bug.\n\n## [2.1.0] - 2023-10-08\n\n### Changed\n\n- `\\AKlump\\LoftLib\\Code\\Dates::setTime` was made public.\n\n### Removed\n\n- Passing a `\\AKlump\\Data` instance to `\\AKlump\\LoftLib\\Code\\PersistentSequence::next()` was removed.\n- Passing a `\\AKlump\\Data` instance to `\\AKlump\\LoftLib\\Code\\InfiniteSubset::__construct()` was removed.\n\n## [2.0.0] - 2023-06-28\n\n### Deprecated\n\n- The following files are too complicated to use and there are other options out there, so they have been deprecated and will be removed. Replace all implementations immediately.\n\n- `\\AKlump\\LoftLib\\Storage\\FilePath`\n- `\\AKlump\\LoftLib\\Storage\\FilePathCollection`\n- `\\AKlump\\LoftLib\\Storage\\PersistentInterface`\n\n### Added\n\n- Support for PHP ^8.0\n\n### Changed\n\n- The return value of `\\AKlump\\LoftLib\\Code\\LoftXmlElement::addAttribute` is now `void`, so you can no longer chain this method, if you had done so.  **Search your codebase for chaining and fix!**\n- Minimum PHP increased to ^7.3\n\n## [1.5.0] - 2021-12-23\n\n### Added\n\n- New interface `\\AKlump\\LoftLib\\Code\\ShortCodesInterface`\n- New method `Arrays::getClosestValueTo()`\n\n## [1.4.0] - 2021-07-17\n\n### Added\n\n- Bash::confirm() for user input collection.\n\n## [1.3.0] - 2021-06-27\n\n### Added\n\n- Shortcodes with `&nbsp;` work as if ` `, i.e., `[foo&nbsp;id=\"5\"]lorem[\/foo]` is the same as `[foo id=\"5\"]lorem[\/foo]`. In earlier versions `&nbsp;` was not supported.\n\n## [1.2] - 2021-06-05\n\n### Changed\n\n- Minimum PHP is now 7.1\n\n## [1.1.0] - 2019-12-16\n\n### Changed\n\n- Due to a design flaw in the _Bash\\Configuration_ a new class has replaced the old that hashes the variable names. This should be used moving forward but requires code refactoring. If you do not want to refactor code then use the new deprecated new class _Bash\\LegacyConfiguration_. Otherwise refactor your code to take advantage of the design correction.\n\n### Fixed\n\n- Problem with Bash variable names and special chars by rewriting \\AKlump\\LoftLib\\Bash\\Configuration.\n\n## [1.0.21] - 2019-06-07\n\n### Changed\n\n- Updated tests to work with PHPUnit 6.x, 7.x"},{"id":"dataset","title":"Dataset","body":"An PHP class to use for data objects, using JSON schema as a validation structure.\n\n## Quick Start\n\n1. Create a class that extends `Dataset`.\n1. Now define the json schema.  A simple method is to supply a class constant `JSON_SCHEMA` with the schema value:\n\n        class SimpleExample extends Dataset {\n\n          const JSON_SCHEMA = '{\"type\": \"object\",\"required\":[\"id\"],\"id\":{\"type\":\"integer\"},\"version\":{\"type\":\"string\",\"default\":\"1.2.5\"}}';\n\n        }\n\n1. Most times however, your schema will live in a separate file.  Therefore you will not define the class constant `JSON_SCHEMA`, rather provide the path to the json schema as the return value of the public static method `pathToJsonSchema`.  You may follow the convention of appending `.schema.json` to the classname, if you wish, as shown here:\n\n        \/**\n         * {@inheritdoc}\n         *\/\n        protected static function pathToJsonSchema() {\n          return __DIR__ . '\/DatasetAlpha.schema.json';\n        }\n\n1. Now create a [json schema file](https:\/\/json-schema.org\/latest\/json-schema-validation.html#rfc.section.10) to define your dataset at the path defined above.\n    1. Be aware that when you use the `pattern` keyword to define a regex expression that you do NOT include the delimiters like you do in PHP's `preg_match`.  This is corrent JSON: `\"pattern\": \"\\\\?[^#]+\"`, notice there are no delimiters.\n3. Then implement an instance in your code like this:"},{"id":"developers","title":"Developing This Package","body":"## Testing\n\n1. To run tests: `.\/bin\/run_unit_tests.sh`.\n\n## Build\n\n1. `bump build` will compile files. Do this for every new release."},{"id":"readme","title":"In the Loft Studios PHP Library","body":"A collection of open source code provided by [In the Loft Studios, LLC](http:\/\/intheloftstudios.com\/)."}]