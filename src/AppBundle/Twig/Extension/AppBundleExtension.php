<?php
namespace AppBundle\Twig\Extension;


class AppBundleExtension extends \Twig_Extension
{
    protected $container;

    /**
     *
     * @var \Twig_Environment
     */
    protected $environment;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('plec', array($this, 'getSex')),
            new \Twig_SimpleFunction('wiek', array($this, 'getAge')),
        );
    }

    /**
     * Płeć
     */
    public function getSex(string $firstname)
    {
        $name = trim(strtolower($firstname));

        if (substr($name, -1) == 'a') {
            // wyjątki dla mężczyzn:
            if (($name == "kuba") || ($name == "bonawentura") || ($name == "kosma") || ($name == "jarema") || ($name == "barnaba") || ($name == "zawisza")) {
                $sex = 'Mężczyzna';
            } else {
                $sex = 'Kobieta';
            }
        } else {
            $sex = 'Mężczyzna';
        }

        return $sex;
    }

    /**
     * Wiek
     */
    public function getAge($birth)
    {
        return $birth;
    }

    public function getName()
    {
        return 'app_bundle_ext';
    }
}
