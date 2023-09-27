<?php

namespace App\tests\KernelTestCase;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\User;
use App\EntityListener\UserListener;

class UserEntityListenerTest extends KernelTestCase
{
/*    private $listener;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->listener = new UserListener($container->get('security.password_hasher'));
    }
*/
    public function testEncodePassword():void
    {
        self::bootKernel();
        $container = static::getContainer();
        $listener = new UserListener($container->get('security.password_hasher'));
        $password = 'Aa*123456798';
        $user = new User();
        $user->setPlainPassword($password);
        $listener->encodePassword($user);
        //test si mot de passe encodé
        $this->assertTrue(password_verify($password,$user->getPassword()));
        //test si plainPassword est null après hashage
        $this->assertEquals('', $user->getPlainPassword());
    }
}
