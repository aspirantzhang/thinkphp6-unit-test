# ThinkPHP6 Unit Test

A simple tool for unit testing with PHPUnit and ThinkPHP 6

## Requirements

[Thinkphp v6.0+](https://github.com/top-think/framework)

[PHPUnit v9.x+](https://github.com/sebastianbergmann/phpunit)

## Install

```
composer require aspirantzhang/thinkphp6-unit-test --dev
```

## Usage

First, use the `UnitTestTrait` in your class

```
use aspirantzhang\thinkphp6UnitTest\UnitTestTrait;
```

When testing a class (such as a controller), use it before your statement, and set `$this->app` as the parameter of the controller, like this

```
$this->startRequest();
$yourController = new YourController($this->app);
```

or simply a function test

```
$this->startApp();
```

A full method test might be

```
public function testAdminHome()
{
    $this->startRequest();
    $adminController = new AdminController($this->app);
    $response = $adminController->home();

    $this->assertEquals(200, $response->getCode());
}
```

More supported usage

```
// get with no param
$this->endRequest();
// get with param
$this->startRequest('GET', ['trash' => 'onlyTrashed']);
// post with data
$this->startRequest('POST', ['type' => 'delete', 'ids' => [1]]);
// put with data
$this->startRequest('PUT', ['display_name' => 'Admin']);
```

Finally, close the request.

```
$this->endRequest();
```

You can refer to the project using this package
[https://github.com/aspirantzhang/octopus](https://github.com/aspirantzhang/octopus)

## License

MIT
