<?php

namespace App\Modules\Privilege\Presentation\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseListResource;
use App\Modules\Privilege\Application\DTOs\GetPrivilegeListQuery;
use App\Modules\Privilege\Application\UseCases\CreatePrivilege;
use App\Modules\Privilege\Application\UseCases\DeletePrivilege;
use App\Modules\Privilege\Application\UseCases\GetPrivilege;
use App\Modules\Privilege\Application\UseCases\GetPrivilegeList;
use App\Modules\Privilege\Application\UseCases\UpdatePrivilege;
use App\Modules\Privilege\Presentation\Requests\StorePrivilegeRequest;
use App\Modules\Privilege\Presentation\Requests\UpdatePrivilegeRequest;
use App\Modules\Privilege\Presentation\Resources\PrivilegeResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PrivilegeController extends Controller
{
    public function __construct(
        protected GetPrivilegeList $getPrivilegeList,
        protected GetPrivilege $getPrivilege,
        protected CreatePrivilege $createPrivilege,
        protected UpdatePrivilege $updatePrivilege,
        protected DeletePrivilege $deletePrivilege
    ) {}

    public function index(Request $request)
    {
        Gate::authorize('list', \App\Models\Privilege::class);

        $query = GetPrivilegeListQuery::fromRequest($request->all());
        $privileges = $this->getPrivilegeList->execute($query);

        return new BaseListResource($privileges, 'privilege list retrieved successfully', PrivilegeResource::class);
    }

    public function show(int $id)
    {
        $privilegeModel = \App\Models\Privilege::findOrFail($id);
        Gate::authorize('detail', $privilegeModel);

        $privilege = $this->getPrivilege->execute($id);
        return new PrivilegeResource($privilege, 'privilege detail retrieved successfully');
    }

    public function store(StorePrivilegeRequest $request)
    {
        Gate::authorize('create', \App\Models\Privilege::class);

        $privilege = $this->createPrivilege->execute($request->validated());

        return new PrivilegeResource($privilege, 'privilege created successfully');
    }

    public function update(UpdatePrivilegeRequest $request, int $id)
    {
        $privilegeModel = \App\Models\Privilege::findOrFail($id);
        Gate::authorize('update', $privilegeModel);

        if (!$this->updatePrivilege->execute($id, $request->validated())) {
            throw new ModelNotFoundException('privilege not found or update failed');
        }

        $privilege = $this->getPrivilege->execute($id);
        return new PrivilegeResource($privilege, 'privilege updated successfully');
    }

    public function destroy(int $id)
    {
        $privilegeModel = \App\Models\Privilege::findOrFail($id);
        Gate::authorize('delete', $privilegeModel);

        if (!$this->deletePrivilege->execute($id)) {
            throw new ModelNotFoundException('privilege not found or delete failed');
        }

        return response()->json([
            'success' => true,
            'message' => 'privilege deleted successfully'
        ]);
    }
}
