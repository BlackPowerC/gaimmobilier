<?php

namespace App\Listener;

use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\Metadata\StaticPropertyMetadata;
use JMS\Serializer\SerializationContext;

class OptionListener implements EventSubscriberInterface
{
    /**
     * @Overrided
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            [
                "event" => Events::POST_SERIALIZE,
                "format" => "json",
                "class" => "App\Entity\Option",
                "method" => "onPostSerialize"
            ],
            [
                "event" => Events::POST_SERIALIZE,
                "format" => "xml",
                "class" => "App\Entity\Option",
                "method" => "onPostSerialize"
            ]
        ] ;
    }

    public static function onPostSerialize(ObjectEvent $evt)
    {
        $context = SerializationContext::create() ;

        $evt->getVisitor()->visitProperty(
            new StaticPropertyMetadata("", "delivered_at", null),  (new \DateTime())->format("l jS \of F Y h:i:s A"),
            $context
        ) ;

        $evt->getVisitor()->visitProperty(
            new StaticPropertyMetadata("", "powered_by", null),  "Symfony 4.4.16",
            $context
        ) ;
    }
}