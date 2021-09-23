<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }
    public function create(array $payload)
    {
        $payload['password'] = bcrypt($payload['password']);
        $model = $this->model->create($payload);

        $success['token'] =  $model->createToken('MyApp')->accessToken;
        $success['name'] =  $model->name;
        return $success;
    }

    public function update(array $payload, $id)
    {
        $modell = $this->model->find($id);
        return $modell->update([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => bcrypt($payload['password'])
        ]);
    }
}
