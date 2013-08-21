#Laravel 4 Config Mock
Extremely simple class for mocking Laravel's config abilities.

Meant for use in developing and testing packages. Set the items on the config instance, and inject it into your class(es).

## Example
Here's a simple example showing how you can create a library you want to use (how you use it is not included in the example), how to implement it in a service provider and how to write a test for it where you can load your package's config file and set any config values you need to test your class.

```php
class MyClass
{
	public function setConfig($config)
	{
		$this->config = $config;
	}

	public function hello()
	{
		return $this->config->get('myvendor/mypackage::hello');
	}
}

class MyClassServiceProvider
{
	protected $defer = true;

	public function register()
	{
		$this->app['myclass'] = $this->app->share(function($app) {
			$myclass = new MyClass;
			$myClass->setConfig($app['config']);
		});
	}
}

class MyClassTest extends PHPUnit_Framework_TestCase
{
	public function testHello()
	{
		$config = new anlutro\L4MockConfig\MockConfig;
		// our config file which includes 'hello' => 'my-hello'
		$config->load('/path/to/package/config.php', 'myvendor/mypackage');

		$obj = new MyClass;
		$obj->setConfig($config);

		$this->assertEquals('my-hello', $obj->hello());

		$this->config->set('myvendor/mypackage::hello', 'second-hello');
		$this->assertEquals('second-hello', $obj->hello());
	}
}
```