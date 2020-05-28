<?php
/**
 * ZFrapid - Core classes for ZFrapid tools
 *
 * @link      https://github.com/ZFrapid/zfrapid-core
 * @copyright Copyright (c) 2014 - 2016 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */
namespace ZFrapidCore\Console;

use Traversable;
use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\ColorInterface as Color;
use Zend\I18n\Translator\Translator;
use ZF\Console\Application as ZFApplication;
use ZF\Console\Dispatcher;
use ZF\Console\RouteCollection;

/**
 * Class Application
 *
 * @package ZFrapidCore\Console
 */
class Application extends ZFApplication
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slogan;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * Overwritten constructor to simplify application instantiation
     *
     * @param array|Traversable $routes
     * @param ConsoleInterface  $console
     * @param Translator        $translator
     * @param Dispatcher        $dispatcher
     */
    public function __construct(
        $routes,
        ConsoleInterface $console,
        Translator $translator = null,
        Dispatcher $dispatcher = null
    ) {
        if ($translator) {
            $this->translator = $translator;

            $routes = $this->translateRoutes($routes);
        }

        // call parent constructor
        parent::__construct(
            $this->name . ' - ' . $this->slogan,
            $this->version,
            $routes,
            $console,
            $dispatcher
        );

        // initialize routes
        $routes = [];

        // get all routes except standard version route
        foreach ($this->routeCollection->getRouteNames() as $routeName) {
            if ($routeName == 'version') {
                continue;
            }

            $routes[$routeName] = $this->routeCollection->getRoute($routeName);
        }

        // create new RouteCollection instance and add routes to it
        $this->routeCollection = new RouteCollection();
        $this->setRoutes($routes);

        // change banner and footer
        $this->setBanner([$this, 'writeApplicationBanner']);
        $this->setFooter([$this, 'writeApplicationFooter']);
    }

    /**
     * Run the application
     *
     * Make sure that banner and footer are not shown for autoload command
     *
     * @param array $args
     *
     * @return int
     */
    public function run(array $args = null)
    {
        global $argv;

        if (isset($argv[1]) && $argv[1] == 'autocomplete' && !isset($argv[2])) {
            $this->setBanner(
                function () {
                    return 0;
                }
            );
            $this->setFooter(
                function () {
                    return 0;
                }
            );
        }

        return parent::run($args);
    }

    /**
     * Translate the route texts
     *
     * @param array $routes
     *
     * @return array
     */
    protected function translateRoutes(array $routes = [])
    {
        foreach ($routes as $routeKey => $routeParams) {
            if (isset($routeParams['description'])) {
                $routes[$routeKey]['description']
                    = $this->translator->translate(
                    $routeParams['description']
                );
            }
            if (isset($routeParams['short_description'])) {
                $routes[$routeKey]['short_description']
                    = $this->translator->translate(
                    $routeParams['short_description']
                );
            }
            if (isset($routeParams['options_descriptions'])) {
                foreach (
                    $routeParams['options_descriptions'] as
                    $optionKey => $optionText
                ) {
                    $routes[$routeKey]['options_descriptions'][$optionKey]
                        = $this->translator->translate(
                        $optionText
                    );
                }
            }
        }

        return $routes;
    }

    /**
     * Write application banner
     *
     * @param AdapterInterface $console
     */
    public function writeApplicationBanner(AdapterInterface $console)
    {
        $console->writeLine();

        $console->writeLine(
            str_pad('', $console->getWidth() - 1, '=', STR_PAD_RIGHT),
            Color::GREEN
        );

        $console->write('=', Color::GREEN);
        $console->write(
            str_pad(
                '' . $this->name . ' - ' . $this->slogan
                . ' (Version ' . $this->version . ')',
                $console->getWidth() - 3,
                ' ',
                STR_PAD_BOTH
            )
        );
        $console->writeLine('=', Color::GREEN);

        $console->writeLine(
            str_pad('', $console->getWidth() - 1, '=', STR_PAD_RIGHT),
            Color::GREEN
        );

        $console->writeLine();
    }

    /**
     * Write application footer
     *
     * @param AdapterInterface $console
     */
    public function writeApplicationFooter(AdapterInterface $console)
    {
        $console->writeLine(
            str_pad('', $console->getWidth() - 1, '=', STR_PAD_RIGHT),
            Color::GREEN
        );

        $console->writeLine();
    }
}
