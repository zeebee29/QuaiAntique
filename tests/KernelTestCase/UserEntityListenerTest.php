<?php

namespace App\tests\KernelTestCase;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\User;
use App\EntityListener\UserListener;

class UserEntityListenerTest extends KernelTestCase
{
    private $listener;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->listener = new UserListener($container->get('security.password_hasher'));
    }

    public function testEncodePassword():void
    {
        //test si plainPassword est null après hashage
        $user = new User();
        $user->setPlainPassword('Aa*123456798');

        $this->listener->encodePassword($user);
        $this->assertEquals('', $user->getPlainPassword());
    }
}
