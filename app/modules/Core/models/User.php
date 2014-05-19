<?php

namespace Core\Model;

use Engine\Db\AbstractModel;
use Phalcon\DI;
use Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Validator\StringLength;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * User.
 *
 * @Source("users")
 */
class User extends AbstractModel
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false, column="id", size="11")
     */
    public $id;

    /**
     * @Index("ix_username")
     * @Column(type="string", nullable=false, column="username", size="255")
     */
    public $username;

    /**
     * @Column(type="string", nullable=false, column="password", size="255")
     */
    public $password;

    /**
     * @Index("ix_email")
     * @Column(type="string", nullable=false, column="email", size="150")
     */
    public $email;
}