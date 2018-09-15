<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identifier' => (int)$user->id,
            'name' => (string)$user->name,
            'email' => (string)$user->email,
            'password' => (string)$user->password,
            'isVerified' => (int)$user->verified,
            'isAdmin' => ($user->admin === 'true'),
            'creationDate' => (string)$user->created_at,
            'lastChange' => (string)$user->updated_at,
            'deletedDate' => isset($user->deleted_at) ? (string)$user->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('user.show', $user->id),
                ],
            ],
        ];
    }

    public static function originalAttribute($index)
    {
        $attribute = [
            'identifier' => 'id',
            'name' => 'name',
            'email' => 'email',
            'password' => 'password',
            'isVerified' => 'verified',
            'isAdmin' => 'admin',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attribute = [
            'id' => 'identifier',
            'name' => 'name',
            'email' => 'email',
            'password' => 'password',
            'verified' => 'isVerified',
            'admin' => 'isAdmin',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
