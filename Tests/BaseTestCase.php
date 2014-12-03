<?php
namespace Talan\Bundle\DynamicFormBundle\Tests;

require_once(__DIR__ . "/../../../../../app/AppKernel.php");

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
  protected $_container;
  protected $_application;

  public function __construct()
  {
    $kernel = new \AppKernel("test", true);
    $kernel->boot();
    $this->_container = $kernel->getContainer();
    $this->setUp();
    parent::__construct();
  }

  protected function get($service)
  {
      return $this->_container->get($service);
  }

  protected function setUp()
  {
    $kernel = new \AppKernel("test", true);
    $kernel->boot();
    $this->_application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
    $this->_application->setAutoExit(false);
    $this->runConsole("doctrine:schema:drop", array("--force" => true));
    $this->runConsole("doctrine:schema:update", array("--force" => true));
    $this->runConsole("doctrine:fixture:load", array("--fixtures" => __DIR__ . "/../DataFixtures/ORM", "--append" => true));
  }

  protected function runConsole($command, Array $options = array())
  {
    $options["-e"] = "test";
    $options["-q"] = null;
    $options = array_merge($options, array('command' => $command));
    return $this->_application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
  }
}