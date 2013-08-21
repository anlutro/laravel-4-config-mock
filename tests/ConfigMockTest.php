<?php
require_once __DIR__ . '/../vendor/autoload.php';

use anlutro\L4ConfigMock\ConfigMock;

class ConfigMockTest extends PHPUnit_Framework_TestCase
{
	public function testConstructWithItems()
	{
		$items = array('key' => 'val');
		$mock = new ConfigMock($items);

		$this->assertEquals('val', $mock->get('key'));
	}

	public function testSetValue()
	{
		$mock = new ConfigMock;
		$mock->set('key', 'val');

		$this->assertEquals('val', $mock->get('key'));
	}

	public function testLoad()
	{
		$items = array('key' => 'val');

		$mock = new ConfigMock;
		$mock->load($items, 'vendor/package');

		$this->assertEquals('val', $mock->get('vendor/package::key'));
	}

	public function testLoadFromFile()
	{
		$mock = new ConfigMock;
		$mock->load(__DIR__.'/testconfig.php', 'vendor/package');

		$this->assertEquals('val', $mock->get('vendor/package::key'));
	}
}
