<?php

namespace App\Listener;

use App\Entity\Immo;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber
{

    /**
     *
     * @var CacheManager
     */
    private $cache ;

    /**
     *
     * @var UploaderHelper
     */
    private $helper ;
    
    public function __construct(CacheManager $cache, UploaderHelper $helper)
    {
        $this->helper = $helper ;
        $this->cache = $cache ;
    }

    /**
     * @override
     *
     * @return void
     */
    public function getSubscribedEvents() {
        return ["preRemove", "preUpdate"] ;
    }

    public function preRemove(LifeCycleEventArgs $args)
    {
        $entity = $arg->getEntity() ;
        if($entity instanceof Immo) {
            $$this->cache->remove($this->helper->asset($entity, "imageFile")) ;
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $arg->getEntity() ;
        if($entity instanceof Immo && $entity->getImageFile() instanceof UploadedFile) {
            $$this->cache->remove($this->helper->asset($entity, "imageFile")) ;
        }
    }
}