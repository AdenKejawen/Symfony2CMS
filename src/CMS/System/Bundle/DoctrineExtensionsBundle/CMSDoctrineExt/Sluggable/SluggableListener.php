<?php

namespace CMSDoctrineExt\Sluggable;

use Doctrine\Common\EventArgs;
use Gedmo\Mapping\MappedEventSubscriber;
use CMSDoctrineExt\Sluggable\Mapping\Event\SluggableAdapter;

/**
 * The Timestampable listener handles the update of
 * dates on creation and update.
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @package Gedmo.Demo
 * @subpackage DemoListener
 * @link http://www.gediminasm.org
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class SluggableListener extends MappedEventSubscriber
{
    
    /**
     * The power exponent to jump
     * the slug unique number by tens.
     *
     * @var integer
     */
    private $exponent = 0;
    
    /**
     * List of inserted slugs for each object class.
     * This is needed in case there are identical slug
     * composition in number of persisted objects
     *
     * @var array
     */
    private $persistedSlugs = array();
    
    /**
     * Specifies the list of events to listen
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'onFlush',
            'loadClassMetadata'
        );
    }
    

    /**
     * Mapps additional metadata for the Entity
     *
     * @param EventArgs $eventArgs
     * @return void
     */
    public function loadClassMetadata(EventArgs $eventArgs)
    {
        $ea = $this->getEventAdapter($eventArgs);
        $this->loadMetadataForObjectClass($ea->getObjectManager(), $eventArgs->getClassMetadata());
    }

    /**
     * Generate slug on objects being updated during flush
     * if they require changing
     *
     * @param EventArgs $args
     * @return void
     */
    public function onFlush(EventArgs $args)
    {

        $ea = $this->getEventAdapter($args);
        $om = $ea->getObjectManager();
        $uow = $om->getUnitOfWork();

        // process all objects being inserted, using scheduled insertions instead
        // of prePersist in case if record will be changed before flushing this will
        // ensure correct result. No additional overhead is encoutered
        foreach ($ea->getScheduledObjectInsertions($uow) as $object) {
            $meta = $om->getClassMetadata(get_class($object));
            if ($config = $this->getConfiguration($om, $meta->name)) {
                // generate first to exclude this object from similar persisted slugs result
                $this->generateSlug($ea, $object);
                $slug = $meta->getReflectionProperty($config['slug'])->getValue($object);
                $this->persistedSlugs[$meta->name][] = $slug;
            }
        }
        // we use onFlush and not preUpdate event to let other
        // event listeners be nested together
        foreach ($ea->getScheduledObjectUpdates($uow) as $object) {
            $meta = $om->getClassMetadata(get_class($object));
            if ($config = $this->getConfiguration($om, $meta->name)) {
                if ($config['updatable']) {
                    $this->generateSlug($ea, $object);
                }
            }
        }
    }

    /**
     * Creates the slug for object being flushed
     *
     * @param SluggableAdapter $ea
     * @param object $object
     * @throws UnexpectedValueException - if parameters are missing
     *      or invalid
     * @return void
     */
    private function generateSlug(SluggableAdapter $ea, $object)
    {
        $om = $ea->getObjectManager();
        $meta = $om->getClassMetadata(get_class($object));
        $uow = $om->getUnitOfWork();
        $changeSet = $ea->getObjectChangeSet($uow, $object);
        $config = $this->getConfiguration($om, $meta->name);

        // sort sluggable fields by position
        $fields = $config['fields'];
        usort($fields, function($a, $b) {
            if ($a['position'] == $b['position']) {
                return 1;
            }
            return ($a['position'] < $b['position']) ? -1 : 1;
        });

        // collect the slug from fields
        $slug = '';
        $needToChangeSlug = false;
        $sluggable_field = array();
        $prefix = '';
        $i=0;
        foreach ($fields as $sluggableField) {
            if (isset($changeSet[$sluggableField['field']])) {
                $needToChangeSlug = true;
            }
            if($i > 0) $prefix = $config['separator'];
            $slug .= $prefix.trim($meta->getReflectionProperty($sluggableField['field'])->getValue($object));
            $i++;
        }
        // if slug is not changed, no need further processing
        if (!$needToChangeSlug) {
            return; // nothing to do
        }

        if (!strlen(trim($slug))) {
            throw new \Gedmo\Exception\UnexpectedValueException('Unable to find any non empty sluggable fields, make sure they have something at least.');
        }

        // build the slug
        $slug = strtolower($this->translitIt($slug));


        // cut slug if exceeded in length
        $mapping = $meta->getFieldMapping($config['slug']);
        if (isset($mapping['length']) && strlen($slug) > $mapping['length']) {
            $slug = substr($slug, 0, $mapping['length']);
        }

        // make unique slug if requested
        if ($config['unique']) {
            $this->exponent = 0;
            $slug = $this->makeUniqueSlug($ea, $object, $slug);
        }
        
        // set the final slug
        $meta->getReflectionProperty($config['slug'])->setValue($object, $slug);
        // recompute changeset
        $ea->recomputeSingleObjectChangeSet($uow, $meta, $object);
    }

    protected function translitIt($str)
    {
          $tr = array(
              "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
              "Д"=>"d","Е"=>"e",'Ё'=>'yo',"Ж"=>"zh","З"=>"z","И"=>"i",
              "Й"=>"j","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
              "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
              "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"c","Ч"=>"ch",
              "Ш"=>"sh","Щ"=>"shh","Ъ"=>"","Ы"=>"y","Ь"=>"",
              "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
              "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"yo","ж"=>"zh",
              "з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
              "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
              "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
              "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shh","ъ"=>"",
              "ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
              " "=> "-"
          );
          
          $str = strtr($str, $tr);
          
          //$str = preg_replace('/\W/', '', $str);
    
          $str = preg_replace('/[^0-9a-zA-Z-]/', '',$str);
    
          return $str;
    }

    /**
     * Generates the unique slug
     *
     * @param SluggableAdapter $ea
     * @param object $object
     * @param string $preferedSlug
     * @return string - unique slug
     */
    private function makeUniqueSlug(SluggableAdapter $ea, $object, $preferedSlug, $recursing = false)
    {
        $om = $ea->getObjectManager();
        $meta = $om->getClassMetadata(get_class($object));
        $config = $this->getConfiguration($om, $meta->name);

        // search for similar slug
        $result = $ea->getSimilarSlugs($object, $meta, $config, $preferedSlug);
        // add similar persisted slugs into account
        $result += $this->getSimilarPersistedSlugs($meta->name, $preferedSlug);
        // leave only right slugs
        if (!$recursing) {
            $this->filterSimilarSlugs($result, $config, $preferedSlug);
        }

        if ($result) {
            $generatedSlug = $preferedSlug;
            $sameSlugs = array();
            foreach ((array)$result as $list) {
                $sameSlugs[] = $list[$config['slug']];
            }

            $i = pow(10, $this->exponent);
            do {
                $generatedSlug = $preferedSlug . $config['separator'] . $i++;
            } while (in_array($generatedSlug, $sameSlugs));

            $mapping = $meta->getFieldMapping($config['slug']);
            if (isset($mapping['length']) && strlen($generatedSlug) > $mapping['length']) {
                $generatedSlug = substr(
                    $generatedSlug,
                    0,
                    $mapping['length'] - (strlen($i) + strlen($config['separator']))
                );
                $this->exponent = strlen($i) - 1;
                $generatedSlug = $this->makeUniqueSlug($ea, $object, $generatedSlug, true);
            }
            $preferedSlug = $generatedSlug;
        }
        return $preferedSlug;
    }

    /**
     * In case if any number of records are persisted instantly
     * and they contain same slugs. This method will filter those
     * identical slugs specialy for persisted objects. Returns
     * array of similar slugs found
     *
     * @param string $class
     * @param string $preferedSlug
     * @return array
     */
    private function getSimilarPersistedSlugs($class, $preferedSlug)
    {
        $result = array();
        if (isset($this->persistedSlugs[$class])) {
            array_walk($this->persistedSlugs[$class], function($val) use ($preferedSlug, &$result) {
                if (preg_match("/{$preferedSlug}.*/smi", $val)) {
                    $result[] = array('slug' => $val);
                }
            });
        }
        return $result;
    }

    /**
     * Filters $slugs which are matched as prefix but are
     * simply shorter slugs
     *
     * @param array $slugs
     * @param array $config
     * @param string $prefered
     */
    private function filterSimilarSlugs(array &$slugs, array &$config, $prefered)
    {
        foreach ($slugs as $key => $similar) {
            if (!preg_match("@{$prefered}($|{$config['separator']}[\d]+$)@smi", $similar['slug'])) {
                unset($slugs[$key]);
            }
        }
    }
    

    /**
     * {@inheritDoc}
     */
    protected function getNamespace()
    {
        return __NAMESPACE__;
    }
}
