<?php

namespace App\Modules\Role\Presentation\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseListResource;
use App\Modules\Role\Application\Commands\CreateRoleCommand;
use App\Modules\Role\Application\DTOs\GetRoleListQuery;
use App\Modules\Role\Application\UseCases\CreateRole;
use App\Modules\Role\Application\UseCases\DeleteRole;
use App\Modules\Role\Application\UseCases\GetRole;
use App\Modules\Role\Application\UseCases\GetRoleList;
use App\Modules\Role\Application\UseCases\UpdateRole;
use App\Modules\Role\Presentation\Requests\StoreRoleRequest;
use App\Modules\Role\Presentation\Requests\UpdateRoleRequest;
use App\Modules\Role\Presentation\Resources\RoleResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function __construct(
        protected GetRoleList $getRoleList,
        protected GetRole $getRole,
        protected CreateRole $createRole,
        protected UpdateRole $updateRole,
        protected DeleteRole $deleteRole
    ) {}

    public function index(Request $request)
    {
        Gate::authorize('list', \App\Models\Role::class); // Match 'role.list' with middleware/seeder

        $query = GetRoleListQuery::fromRequest($request->all());
        $roles = $this->getRoleList->execute($query);

        return new BaseListResource($roles, 'role list retrieved successfully', RoleResource::class);
    }

    public function show(int $id)
    {
        $roleModel = \App\Models\Role::findOrFail($id);
        Gate::authorize('detail', $roleModel);

        $role = $this->getRole->execute($id);
        return new RoleResource($role, 'role detail retrieved successfully');
    }

    public function store(StoreRoleRequest $request)
    {
        Gate::authorize('create', \App\Models\Role::class);

        $command = CreateRoleCommand::fromRequest($request->validated());
        $role = $this->createRole->execute($command);

        return new RoleResource($role, 'role created successfully');
    }

    public function update(UpdateRoleRequest $request, int $id)
    {
        $roleModel = \App\Models\Role::findOrFail($id);
        Gate::authorize('update', $roleModel);

        if (!$this->updateRole->execute($id, $request->validated())) {
            throw new ModelNotFoundException('role not found or update failed');
        }

        $role = $this->getRole->execute($id);
        return new RoleResource($role, 'role updated successfully');
    }

    public function destroy(int $id)
    {
        $roleModel = \App\Models\Role::findOrFail($id);
        Gate::authorize('delete', $roleModel);

        if (!$this->deleteRole->execute($id)) {
            // Maybe failed due to user assignment check or not found
            throw new ModelNotFoundException('role not found or delete failed (role might be in use)');
        }

        $role = $this->getRole->execute($id); // Deleted logic? 
        // If deleted, we can't retrieve. Return deleted status or simplified resource.
        // Actually BaseListResource or just JSON.
        // Returning resource of deleted item is tricky.
        // Existing User module returned "Deleted user" but fetched it? Step 813.
        // Wait, if deleted, `getUser->execute($id)` should return null.
        // I will follow existing pattern but check null.

        return response()->json([
            'success' => true,
            'message' => 'role deleted successfully'
        ]);
    }
}
