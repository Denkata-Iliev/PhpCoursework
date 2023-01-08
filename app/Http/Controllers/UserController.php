<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    const NO_PERMISSIONS = 'You don\'t have the necessary permission';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->validatePermissions();

        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->validatePermissions();

        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ])->assignRole($request['role']);

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->validatePermissions();

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->validatePermissions();

        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Requests\UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if (!is_null($request['name'])) {
            $user->name = $request['name'];
        }

        if (!is_null($request['email'])) {
            if ($request['email'] !== $user->email && User::where('email', $request['email'])->first()->id !== $user->id) {
                return back()->with('error', 'This email is already taken');
            }

            $user->email = $request['email'];
        }

        if (!is_null($request['password'])) {
            $user->password = bcrypt($request['password']);
        }

        if ($user->hasRole('ADMIN') && $this->isLastAdmin()) {
            abort(403, "You can't change the role of the last admin");
        }

        $user->syncRoles($request['role']);
        $user->update();

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->validatePermissions();

        if ($user->id === Auth::user()->id) {
            abort(403, "You can't delete yourself");
        }

        if ($user->hasRole('ADMIN') && $this->isLastAdmin()) {
            abort(403, "You can't delete the last admin");
        }

        $user->deleteProfilePhoto();
        $user->delete();

        return redirect()->route('users.index');
    }

    private function validatePermissions(): void
    {
        abort_if(Gate::denies('access-users'), 403, self::NO_PERMISSIONS);
    }

    /**
     * @return bool
     */
    public function isLastAdmin(): bool
    {
        return count(User::role('ADMIN')->get()) === 1;
    }
}
