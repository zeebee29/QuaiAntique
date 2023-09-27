<?php

namespace App\tests\KernelTestCase;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Constraints as Assert;

class UserTest extends KernelTestCase
{
    public function getUser (): User
    {
        return(
            new User())
            ->setNom('nomTest')
            ->setPrenom('pre')
            ->setEmail('tst@mail.tst')
            ->setNbConvive(2)
            ->setPlainPassword('Aa*123456798')
            ->setTel('0102030405')
        ;
    }

    public function testValidUser(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getUser();
        $errors = $container->get('validator')->validate($user);
        $this->assertCount(0,$errors);

        $errors = $container->get('validator')->validate($this->getUser()->getUserIdentifier(),new Assert\Email());
        $this->assertCount(0,$errors);
        
        $this->assertMatchesRegularExpression($container->getParameter('regex_password'),$this->getUser()->getPlainPassword());

        $this->assertMatchesRegularExpression($container->getParameter('regex_phone'),$user->getTel());
        //tel version internationale
        $user->setTel('+33102030405');
        $this->assertMatchesRegularExpression($container->getParameter('regex_phone'),$user->getTel());
    }

    public function testInvalidUserDatas():void
    {
        self::bootKernel();
        $container = static::getContainer();

        $errors = $container->get('validator')->validate($this->getUser()->setNom(''));
        $this->assertCount(2,$errors);

        $errors = $container->get('validator')->validate($this->getUser()->setPrenom('t'));
        $this->assertCount(1,$errors);

        $errors = $container->get('validator')->validate($this->getUser()->setEmail('t@t'));
        $this->assertCount(1,$errors);
        $errors = $container->get('validator')->validate($this->getUser()->setEmail('tt.fr'));
        $this->assertCount(1,$errors);

        $user = $this->getUser();
        $user->setEmail('testInvalidEmail');
        $errors = $container->get('validator')->validate($user->getUserIdentifier(),new Assert\Email());
        $this->assertCount(1,$errors);

        $user = $this->getUser();
        //too short password
        $user->setPlainPassword('A12356*');
        $this->assertDoesNotMatchRegularExpression($container->getParameter('regex_password'),$user->getPlainPassword());
        //no number in password
        $user->setPlainPassword('A**aa*aaa');
        $this->assertDoesNotMatchRegularExpression($container->getParameter('regex_password'),$user->getPlainPassword());
        //no letter in password
        $user->setPlainPassword('11223344*');
        $this->assertDoesNotMatchRegularExpression($container->getParameter('regex_password'),$user->getPlainPassword());
        //no special car. in password
        $user->setPlainPassword('Aa12345678');
        $this->assertDoesNotMatchRegularExpression($container->getParameter('regex_password'),$user->getPlainPassword());

        $user = $this->getUser();
        //too short Fr tel
        $user->setTel('002030405');
        $this->assertDoesNotMatchRegularExpression($container->getParameter('regex_phone'),$user->getTel());
        //too short inter. tel
        $user->setTel('+33030405');
        $this->assertDoesNotMatchRegularExpression($container->getParameter('regex_phone'),$user->getTel());
        //too long Fr Tel
        $user->setTel('011102030405');
        $this->assertDoesNotMatchRegularExpression($container->getParameter('regex_phone'),$user->getTel());
        //too long iner. tel
        $user->setTel('+330102030405');
        $this->assertDoesNotMatchRegularExpression($container->getParameter('regex_phone'),$user->getTel());
        //lettre in tel
        $user->setTel('+33a02030405');
        $this->assertDoesNotMatchRegularExpression($container->getParameter('regex_phone'),$user->getTel());
        //indicatif Nok 
        $user->setTel('1102030405');
        $this->assertDoesNotMatchRegularExpression($container->getParameter('regex_phone'),$user->getTel());
        //indicatif Nok
        $user->setTel('+32102030405');
        $this->assertDoesNotMatchRegularExpression($container->getParameter('regex_phone'),$user->getTel());
    }
}
