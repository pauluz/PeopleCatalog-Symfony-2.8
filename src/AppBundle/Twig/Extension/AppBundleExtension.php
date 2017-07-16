<?php
namespace AppBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class AppBundleExtension extends \Twig_Extension
{
    protected $container;

    /**
     *
     * @var \Twig_Environment
     */
    protected $environment;

    public function __construct(ContainerInterface $container)
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
     * pZ: getAge - Wiek osoby
     *
     * @param $birth \DateTime
     *
     * @return string
     */
    public function getAge($birth)
    {
        $age = date('Y') - $birth->format('Y');
        if ($age == 1) {
            $txt = 'rok';
        } elseif ($age > 1 && $age < 5) {
            $txt = 'lata';
        } elseif ($age > 21 && in_array(substr($age, -1), [2, 3, 4])) {
            $txt = 'lata';
        } else {
            $txt = 'lat';
        }

        return $age . ' ' . $txt;
    }

    public function getName()
    {
        return 'app_bundle_ext';
    }
}
