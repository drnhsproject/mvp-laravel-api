<?php

namespace App\Modules\User\Presentation\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Application\UseCases\CreateUser;
use App\Modules\User\Application\UseCases\DeleteUser;
use App\Modules\User\Application\UseCases\GetUserList;
use App\Modules\User\Application\UseCases\GetUser;
use App\Modules\User\Application\UseCases\UpdateUser;
use App\Modules\User\Presentation\Requests\StoreUserRequest;
use App\Modules\User\Presentation\Requests\UpdateUserRequest;
use App\Modules\User\Presentation\Resources\UserResource;
use Illuminate\Http\Request;

use App\Http\Resources\BaseListResource;
use App\Modules\User\Application\DTOs\GetUserListQuery;
use App\Modules\User\Application\Commands\CreateUserCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    protected $getUserList;
    protected $createUser;
    protected $updateUser;
    protected $deleteUser;
    protected $getUser;

    public function __construct(
        GetUserList $getUserList,
        CreateUser $createUser,
        UpdateUser $updateUser,
        DeleteUser $deleteUser,
        GetUser $getUser
    ) {
        $this->getUserList = $getUserList;
        $this->createUser = $createUser;
        $this->updateUser = $updateUser;
        $this->deleteUser = $deleteUser;
        $this->getUser = $getUser;
    }

    public function show(int $id)
    {
        $user = $this->getUser->execute($id);
        if (!$user) {
            throw new ModelNotFoundException('user not found');
        }
        return new UserResource($user, 'user detail retrieved successfully');
    }

    public function index(Request $request)
    {
        $query = GetUserListQuery::fromRequest($request->all());
        $users = $this->getUserList->execute($query);

        return new BaseListResource($users, 'user list retrieved successfully', UserResource::class);
    }

    public function store(StoreUserRequest $request)
    {
        $command = CreateUserCommand::fromRequest($request->validated());
        $user = $this->createUser->execute($command);
        return new UserResource($user, 'user created successfully');
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        if (!$this->updateUser->execute($id, $request->validated())) {
            throw new ModelNotFoundException('user not found or update failed');
        }

        $user = $this->getUser->execute($id);
        return new UserResource($user, 'user updated successfully');
    }

    public function destroy(int $id)
    {
        if (!$this->deleteUser->execute($id)) {
            throw new ModelNotFoundException('user not found or delete failed');
        }

        $user = $this->getUser->execute($id);
        return new UserResource($user, 'user deleted successfully');
    }
}
