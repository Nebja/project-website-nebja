<?php

namespace App\Subscribers;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;

class ProfilerSub implements EventSubscriberInterface
{

    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }
    /**
     * @return string[]
     */
    #[ArrayShape([KernelEvents::RESPONSE => "string"])]
    public static function getSubscribedEvents(): array
    {
        // return the subscribed events, their methods and priorities
        return [
            KernelEvents::RESPONSE => 'onKernelResponse'
        ];
    }
    public function onKernelResponse(ResponseEvent $event): void
    {
        // If in debug mode
        if (!$this->kernel->isDebug()) {
            return;
        }
        // If it is an XMlHTTPRequest don't change headers
        $request = $event->getRequest();
        if ($request->isXmlHttpRequest()) {
            return;
        }

        $response = $event->getResponse();
        $response->headers->set('Symfony-Debug-Toolbar-Replace', 1);
    }
}
