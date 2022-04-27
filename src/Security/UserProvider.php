<?php
// src/Security/UserProvider.php
namespace App\Security;

use \Exception;
use App\Entity\Users;
use App\Entity\Podcasters;
use App\Entity\Administrators;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    private $user_repo;
    private $admin_repo;
    private $podcaster_repo;

    public function __construct(EntityManagerInterface $man) {
        $this->user_repo = $man->getRepository(Users::class);
        $this->admin_repo = $man->getRepository(Administrators::class);
        $this->podcaster_repo = $man->getRepository(Podcasters::class);
    }

    /**
     * Symfony calls this method if you use features like switch_user
     * or remember_me. If you're not using these features, you do not
     * need to implement this method.
     *
     * @throws UserNotFoundException if the user is not found
     */
    public function loadUserByUsername($username): UserInterface
    {

        $user = $this->user_repo->findOneBy(['username' => $username]);

        if ($user instanceof Users) {
            return $user;
        }

        throw new UserNotFoundException("Couldn't find a user with the provided identifier");
    }

    /**
     * Refreshes the user after being reloaded from the session.
     *
     * When a user is logged in, at the beginning of each request, the
     * User object is loaded from the session and then this method is
     * called. Your job is to make sure the user's data is still fresh by,
     * for example, re-querying for fresh User data.
     *
     * If your firewall is "stateless: true" (for a pure API), this
     * method is not called.
     *
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof Users) {
            throw new unsupporteduserexception(sprintf('Invalid user class "%s".', get_class($user)));
        }

        return $this->fetchUser($username);
        // Return a User object after making sure its data is "fresh".
        // Or throw a UserNotFoundException if the user no longer exists.
        throw new Exception('TODO: fill in refreshUser() inside '.__FILE__);
    }

    /**
     * Tells Symfony to use this provider for this User class.
     */
    public function supportsClass($class)
    {
        return Users::class === $class
            || is_subclass_of($class, Users::class);
    }

    public function upgradePassword(UserInterface $user, string $newHashedPassword): void
    {
        // set the new hashed password on the User object
        $user->setPassword($newHashedPassword);

        // execute the queries on the database
        $this->getEntityManager()->flush();
    }
}
