<?php


namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class User extends BaseObject
{
    /**
     * Identifier of the logged in user, e.g. the primary key of the user
     *
     * @var string
     */
    private $id;

    /**
     * Email of the logged in user
     *
     * @var string
     */
    private $email;

    /**
     * The username of the logged in user
     *
     * @var string
     */
    private $username;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'username' => $this->username,
        ];
    }

    /**
     * Define object validation rules
     *
     * @return array
     */
    public function validationRules(): array
    {
        // TODO: Implement validationRules() method.
    }
}