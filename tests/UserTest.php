<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 06/04/2018
 * Time: 19:24
 */

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class UserTest extends TestCase
{
    private function getTestRepo()
    {
        $user = new User();
        $user->setUsername('paul');
        $user->setPassword('password');
        $user->setId('0');
        $user->setRoles(['ROLE_TESTER']);

        $userRp = $this->createMock(ObjectRepository::class);

        $userRp->expects($this->any())->method('find')->willReturn($user);

        $objectManager = $this->createMock(ObjectManager::class);
        $objectManager->expects($this->any())->method('getRepository')->willReturn($userRp);

        return $objectManager;

    }

    public function testInstance()
    {
        $obj_manager = $this->getTestRepo();

        $userRp = $obj_manager->getRepository(User::class);
        $user = $userRp->find(1);

        $this->assertNotNull($user);
    }

    public function testUserIdNotNull()
    {
        $obj_manager = $this->getTestRepo();

        $userRp = $obj_manager->getRepository(User::class);
        $user = $userRp->find(1);

        $this->assertNotNull($user->getId());
    }

    public function testIDEqualToZero()
    {
        $obj_manager = $this->getTestRepo();

        $userRp = $obj_manager->getRepository(User::class);
        $user = $userRp->find(1);

        $this->assertEquals('0', $user->getId());
    }

    public function testUserName()
    {
        $obj_manager = $this->getTestRepo();

        $userRp = $obj_manager->getRepository(User::class);
        $user = $userRp->find(1);

        $this->assertNotNull($user->getUsername());
        $this->assertEquals('paul', $user->getUsername());
    }

    public function testUserNameFail()
    {
        $obj_manager = $this->getTestRepo();

        $userRp = $obj_manager->getRepository(User::class);
        $user = $userRp->find(1);

        $this->assertNotEquals('kaul', $user->getUsername());
    }

    public function testUserPassword()
    {
        $obj_manager = $this->getTestRepo();

        $userRp = $obj_manager->getRepository(User::class);
        $user = $userRp->find(1);

        $this->assertNotNull($user->getPassword());
        $this->assertEquals('password', $user->getPassword());
    }

    public function testRoleNotEmpty()
    {
        $obj_manager = $this->getTestRepo();

        $userRp = $obj_manager->getRepository(User::class);
        $user = $userRp->find(1);

        $this->assertNotEmpty($user->getRoles());

    }

    public function testNulls()
    {
        $obj_manager = $this->getTestRepo();

        $userRp = $obj_manager->getRepository(User::class);
        $user = $userRp->find(1);

        $this->assertNull($user->eraseCredentials());
        $this->assertNull($user->getSalt());

        $this->assertNotNull($user->serialize());
        $this->assertNull($user->unserialize($user->serialize()));
    }
}