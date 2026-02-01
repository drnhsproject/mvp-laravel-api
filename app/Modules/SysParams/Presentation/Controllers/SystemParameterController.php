<?php

namespace App\Modules\SysParams\Presentation\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseListResource;
use App\Modules\SysParams\Application\Commands\CreateSystemParameterCommand;
use App\Modules\SysParams\Application\Commands\UpdateSystemParameterCommand;
use App\Modules\SysParams\Application\DTOs\GetSystemParameterListQuery;
use App\Modules\SysParams\Application\UseCases\CreateSystemParameter;
use App\Modules\SysParams\Application\UseCases\DeleteSystemParameter;
use App\Modules\SysParams\Application\UseCases\GetSystemParameter;
use App\Modules\SysParams\Application\UseCases\GetSystemParameterList;
use App\Modules\SysParams\Application\UseCases\UpdateSystemParameter;
use App\Modules\SysParams\Presentation\Requests\StoreSystemParameterRequest;
use App\Modules\SysParams\Presentation\Requests\UpdateSystemParameterRequest;
use App\Modules\SysParams\Presentation\Resources\SystemParameterResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SystemParameterController extends Controller
{
    public function __construct(
        protected readonly GetSystemParameterList $getSystemParameterList,
        protected readonly GetSystemParameter $getSystemParameter,
        protected readonly CreateSystemParameter $createSystemParameter,
        protected readonly UpdateSystemParameter $updateSystemParameter,
        protected readonly DeleteSystemParameter $deleteSystemParameter,
    ) {}

    /**
     * Display a listing of system parameters.
     */
    public function index(Request $request)
    {
        $query = GetSystemParameterListQuery::fromRequest($request->all());
        $systemParameters = $this->getSystemParameterList->execute($query);

        return new BaseListResource(
            $systemParameters,
            'system parameters retrieved successfully',
            SystemParameterResource::class
        );
    }

    /**
     * Display the specified system parameter.
     */
    public function show(int $id)
    {
        $systemParameter = $this->getSystemParameter->execute($id);

        if (!$systemParameter) {
            throw new ModelNotFoundException('system parameter not found');
        }

        return new SystemParameterResource($systemParameter, 'system parameter detail retrieved');
    }

    /**
     * Store a newly created system parameter.
     */
    public function store(StoreSystemParameterRequest $request)
    {
        $command = CreateSystemParameterCommand::fromRequest($request->validated());
        $systemParameter = $this->createSystemParameter->execute($command);

        return new SystemParameterResource($systemParameter, 'system parameter created successfully');
    }

    /**
     * Update the specified system parameter.
     */
    public function update(UpdateSystemParameterRequest $request, int $id)
    {
        $command = UpdateSystemParameterCommand::fromRequest($request->validated());
        $systemParameter = $this->updateSystemParameter->execute($id, $command);

        return new SystemParameterResource($systemParameter, 'system parameter updated successfully');
    }

    /**
     * Remove the specified system parameter.
     */
    public function destroy(int $id)
    {
        if (!$this->deleteSystemParameter->execute($id)) {
            throw new ModelNotFoundException('system parameter not found or delete failed');
        }

        return response()->json([
            'message' => 'system parameter deleted successfully',
        ]);
    }
}
