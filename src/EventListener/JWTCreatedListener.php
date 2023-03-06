<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener{
    private RequestStack $requestStack;
    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $id = $event->getUser()->getId();
        $user = $event->getUser()->getUserIdentifier();
        $roles = $event->getUser()->getRoles();
        $array = ['id' => $id,
            'username' => $user,
            'roles' => $roles
            ];

        $event->setData($array);

        $header = $event->getHeader();
        $header['cty'] = 'JWT';

        $event->setHeader($header);

    }
}

