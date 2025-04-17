<?php

namespace App\Http\Controllers;

use App\Http\Actions\User\UpdateUserAction;
use App\Http\DTOs\RoleData;
use App\Http\DTOs\UserData;
use App\Http\Pipelines\User\Filters\EmailFilter;
use App\Http\Pipelines\User\Filters\NameFilter;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pipeline\Pipeline;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('users/Index', [
            'users' => app(Pipeline::class)
                ->send(User::query()->with('roles'))
                ->through([
                    NameFilter::class,
                    EmailFilter::class,
                ])
                ->thenReturn()
                ->paginate(10)
                ->withQueryString(),
            'roles' => Role::all(),
            'filters' => request()->all(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): Response
    {
        return Inertia::render('users/Show', [
            'User' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user, UpdateUserAction $action): RedirectResponse
    {
        $roles = [];

        foreach ($request->validated('roles') as $role) {
            $roles[] = [
                'name' => $role,
            ];
        }

        $data = UserData::from([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'roles' => RoleData::collect($roles),
        ]);

        try {
            $action->handle($data, $user);

            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $user->delete();

            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
