<?php

namespace JD\FormBundle\Tests\DependencyInjection;

use JD\FormBundle\DependencyInjection\JDFormExtension;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

/**
 *
 */
final class JDFormExtensionTest extends PHPUnit_Framework_TestCase
{
    private static $servicesShortName = [
        'array_hidden' => 'jd_form.form_type.array_hidden',
        'array_text'   => 'jd_form.form_type.array_text',
        'date'         => 'jd_form.form_type.jd_date',
        'date_between' => 'jd_form.form_type.date_between',
    ];

    /**
     * @var ContainerBuilder
     */
    private $container;
    /**
     * @var JDFormExtension
     */
    private $extension;

    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new JDFormExtension();
    }

    protected function tearDown()
    {
        $this->container = null;
        $this->extension = null;
    }

    public function testDisableBundle()
    {
        // setup
        $config = ['enabled' => false];

        // call method under test
        $this->extension->load([$config], $this->container);

        // tests
        foreach (self::$servicesShortName as $serviceName) {
            $this->assertHasNotDefinition($serviceName);
        }
    }

    public function testDisableFormType()
    {
        // setup
        $config                         = [];
        $config['form']['enabled']      = false;

        // call method under test
        $this->extension->load([$config], $this->container);

        // tests
        foreach (self::$servicesShortName as $serviceName) {
            $this->assertHasNotDefinition($serviceName);
        }
    }

    public function testDisableArray()
    {
        // setup
        $config                                       = [];
        $config['form']['array']['enabled']           = false;

        // call method under test
        $this->extension->load([$config], $this->container);

        // tests
        $this->assertHasNotDefinition(self::$servicesShortName['array_hidden']);
        $this->assertHasNotDefinition(self::$servicesShortName['array_text']);
    }

    public function testArrayWithCustomDelimiter()
    {
        // setup
        $config = $this->getFullConfig();

        // call method under test
        $this->extension->load([$config], $this->container);

        // tests
        foreach (['array_hidden', 'array_text'] as $configName) {
            $definition = $this->getDefinition(self::$servicesShortName[$configName]);
            $this->assertTrue($definition->hasTag('form.type'));
            $this->assertEquals('|', $definition->getArgument(1), 'The delimiter should have change.');
        }
    }

    public function testDisableDate()
    {
        // setup
        $config                                      = [];
        $config['form']['date']['enabled']           = false;

        // call method under test
        $this->extension->load([$config], $this->container);

        // tests
        $this->assertHasNotDefinition(self::$servicesShortName['date']);
    }

    public function testDateWithDefaults()
    {
        // setup
        $config = [
            'form' => [
                'date' => [
                    'widget' => 'choice',
                ],
            ],
        ];

        // call method under test
        $this->extension->load([$config], $this->container);

        // tests
        $definition = $this->getDefinition(self::$servicesShortName['date']);
        $this->assertTrue($definition->hasTag('form.type'));
        $this->assertEquals('choice', $definition->getArgument(0), 'The widget should be set to the user defined one.');
    }

    public function testDateWithCustomOptions()
    {
        // setup
        $config = $this->getFullConfig();

        // call method under test
        $this->extension->load([$config], $this->container);

        // tests
        $definition = $this->getDefinition(self::$servicesShortName['date']);
        $this->assertTrue($definition->hasTag('form.type'));
        $this->assertEquals('choice', $definition->getArgument(0), 'The widget default value.');
    }

    public function testDisableDateBetween()
    {
        // setup
        $config                                              = [];
        $config['form']['date_between']['enabled']           = false;

        // call method under test
        $this->extension->load([$config], $this->container);

        // tests
        $this->assertHasNotDefinition(self::$servicesShortName['date_between']);
    }

    public function testDateBetweenWithDefaults()
    {
        // setup
        $config = [];

        // call method under test
        $this->extension->load([$config], $this->container);

        // tests
        $definition = $this->getDefinition(self::$servicesShortName['date_between']);
        $this->assertTrue($definition->hasTag('form.type'));
        $this->assertEquals('jd_date', $definition->getArgument(0), 'from default type.');
        $this->assertEquals('jd_date', $definition->getArgument(1), 'to default type.');
    }

    public function testDateBetweenWithCustomOptions()
    {
        // setup
        $config = $this->getFullConfig();

        // call method under test
        $this->extension->load([$config], $this->container);

        // tests
        $definition = $this->getDefinition(self::$servicesShortName['date_between']);
        $this->assertTrue($definition->hasTag('form.type'));
        $this->assertEquals('date', $definition->getArgument(0), 'from default type.');
        $this->assertEquals('date', $definition->getArgument(1), 'to default type.');
    }

    /**
     * @return mixed
     */
    private function getFullConfig()
    {
        $yaml   = <<<EOF
form:
    array:
        delimiter: "|"
    date:
        widget: "choice"
    date_between:
        from: "date"
        to: "date"
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * @param string $serviceId
     */
    private function assertHasNotDefinition($serviceId)
    {
        $this->assertFalse($this->container->hasDefinition($serviceId) || $this->container->hasAlias($serviceId));
    }

    /**
     * @param string $serviceId
     */
    private function assertHasDefinition($serviceId)
    {
        $this->assertTrue($this->container->hasDefinition($serviceId) || $this->container->hasAlias($serviceId));
    }

    /**
     * @param string $serviceId
     *
     * @return \Symfony\Component\DependencyInjection\Definition
     */
    private function getDefinition($serviceId)
    {
        $this->assertHasDefinition($serviceId);

        return $this->container->findDefinition($serviceId);
    }
}
