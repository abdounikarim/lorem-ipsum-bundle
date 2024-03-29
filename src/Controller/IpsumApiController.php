<?php

namespace KnpU\LoremIpsumBundle\Controller;

use KnpU\LoremIpsumBundle\Event\FilterApiResponseEvent;
use KnpU\LoremIpsumBundle\Event\KnpULoremIpsumEvents;
use KnpU\LoremIpsumBundle\KnpUIpsum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class IpsumApiController extends AbstractController
{
    private $knpUIpsum;
    private $eventDispatcher;

    public function __construct(KnpUIpsum $knpUIpsum, EventDispatcherInterface $eventDispatcher)
    {
        $this->knpUIpsum = $knpUIpsum;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function index()
    {
        $data = [
            'paragraphs' => $this->knpUIpsum->getParagraphs(),
            'sentences' => $this->knpUIpsum->getSentences(),
        ];
        $event = new FilterApiResponseEvent($data);
        if ($this->eventDispatcher) {
            $this->eventDispatcher->dispatch($event, KnpULoremIpsumEvents::FILTER_API);
        }

        return $this->json($event->getData());
    }
}
