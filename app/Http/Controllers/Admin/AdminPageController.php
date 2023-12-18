<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserLog;
use App\Http\Controllers\Controller;
use App\Jobs\CustomerJob;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPageController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->search;

        $users = User::where(function ($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('gender', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%");
        })
            ->with('roles')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.searched', compact('users', 'search'));
    }

    public function userList()
    {
        $users = User::orderBy('created_at', 'asc')->where('id', '!=', auth()->id())->with('roles')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'                      =>          ['required', 'max:255'],
            'address'                   =>          ['required', 'max:255'],
            'roles'                     =>          ['required', 'max:255'],
            'email'                     =>          ['required', 'max:255', 'email', 'unique:users,email'],
            'password'                  =>          ['required', 'confirmed', 'max:20', 'min:6'],
            'password_confirmation'     =>          ['required', 'max:20', 'min:6']
        ]);

        $token = Str::random(24);

        $user = User::create([
            'name'              =>             $request->name,
            'address'           =>             $request->address,
            'email'             =>             $request->email,
            'password'          =>             bcrypt($request->password),
            'remember_token'    =>             $token
        ]);

        $selectedRole = $request->input('roles');

        if ($selectedRole === 'Admin') {
            $user->assignRole('Admin');
            $user->givePermissionTo(['manage-all', 'customer']);
        } else {
            $user->assignRole('User');
            $user->givePermissionTo('customer');
        }

        CustomerJob::dispatch($user);
        $log_entry = Auth::user()->name . " added a new account email: " . $user->email . " with the id# " . $user->id;
        event(new UserLog($log_entry));

        return redirect('/admin/users')->with('message', 'Account -' . $user->email . '- registered successfully. Please check the email for the verification link for the account.');
    }

    public function updateUser(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'                      =>          ['required', 'max:255'],
            'address'                   =>          ['required', 'max:255'],
            'roles'                     =>          ['required', 'max:255'],
            'email'                     =>          ['required', 'max:255', 'email', 'unique:users,email->ignore($request->user->id)']
        ]);

        $user->update([
            'name'              =>             $request->name,
            'address'           =>             $request->address,
            'email'             =>             $request->email
        ]);

        $selectedRole = $request->input('roles');

        $user->syncRoles([]);
        $user->revokePermissionTo(['manage-all', 'customer']);

        if ($selectedRole === 'Admin') {
            $user->assignRole('Admin');
            $user->givePermissionTo(['manage-all', 'customer']);
        } else {
            $user->assignRole('User');
            $user->givePermissionTo('customer');
        }

        if ($user->email_verified_at == null) {
            CustomerJob::dispatch($user);
        }

        $log_entry = Auth::user()->name . " updated an account email: " . $user->email . " with the id# " . $user->id;
        event(new UserLog($log_entry));

        return redirect('/admin/users')->with('message', 'Account -' . $user->email . '- updated successfully');
    }

    public function delete(User $user)
    {
        $log_entry = Auth::user()->name . " deleted an account email: " . $user->email . " with the id# " . $user->id;
        event(new UserLog($log_entry));
        $user->delete();

        return redirect('/admin/users')->with('message', 'Account -' . $user->email . '- deleted successfully');
    }
}
