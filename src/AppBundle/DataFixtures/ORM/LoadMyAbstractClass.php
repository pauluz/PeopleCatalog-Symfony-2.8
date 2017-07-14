<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

abstract class LoadMyAbstractClass extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use MyLoggerTrait;

    private const FIXTURE_FILE_DIR = '/data/';
    private const FIXTURE_SUFFIX = '-localhost';

    private const ENTITY_NAMESPACE = '\AppBundle\Entity\\'; // podwójny backslash w tych apostrofach

    protected $fixture_table = '';
    protected $reference_fields = [];
    protected $add_reference = true;

    /**
     * @var ContainerInterface
     */
    public $container;

    protected $data;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        if (property_exists($this, 'logger')) {
            $this->setLogger();
        }

        try {

            $this->requireFixtureFile();
            $this->loadArrayToDb($manager);

        } catch (FileNotFoundException $e) {
            if (property_exists($this, 'logger')) {
                $this->log('FILE NOT FOUND: ' . basename($e->getMessage()));
            }
        }
    }

    protected function setAddReference($state = true) {
        $this->add_reference = $state;
    }

    protected function requireFixtureFile()
    {
        $name = __DIR__ . self::FIXTURE_FILE_DIR . $this->fixture_table . self::FIXTURE_SUFFIX . '.php';

        if (file_exists($name)) {

            include $name;
            $this->data = & ${$this->fixture_table};

        } else {
            throw new FileNotFoundException($name);
        }
    }

    protected function loadArrayToDb(ObjectManager & $manager)
    {
        $name = $this->container->camelize($this->fixture_table);

        $entity_name = self::ENTITY_NAMESPACE . $name;

        foreach ($this->data as $record) {

            $object = new $entity_name;

            foreach ($record as $property => $value) {

                if (strtolower($value) == 'null') {
                    $value = null;
                }

                if ($property == 'id') {
                    if ($this->add_reference) {
                        $this->addReference($this->fixture_table . $value, $object);
                    }
                    continue;
                } elseif (substr($property, -3) === '_id') {
                    $property = substr($property, 0, -3);
                    if (in_array($property, $this->reference_fields)) {
                        $value = $this->getReference($property . $value);
                    }
                } elseif ($property == 'birth') {
                    if (! empty($value)) {
                        $value = new \DateTime($value);
                    }
                }

                $setter = 'set' . $this->container->camelize($property);
                $object->$setter($value);
            }

            $manager->persist($object);
        }

        $manager->flush();

//        $_all_references = array_keys($this->referenceRepository->getReferences());
//        echo '<pre>'; print_r($_all_references); echo '</pre>';
//        die(' -LoadMyAbstractClass.php-105');
    }

    /**
     * pZ: getOrder
     *
     * @return int
     */
    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}
