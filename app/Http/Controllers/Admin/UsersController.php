<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    public $userClass;
         
    public function __construct(User $userClass)
    {
        $this->userClass = $userClass;
    }
    
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', ['users'   =>  $users]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  =>  'required',
            'email' =>  'required|email|unique:users',
            'password'  =>  'required',
            'avatar'    =>  'nullable|image',
            'role'      => 'required'
        ]);
        
       
        $this->userClass->addUser($request->all());
        $this->userClass->generatePassword($request->get('password'));
        $this->userClass->uploadAvatar($request->file('avatar'));
        $this->userClass->save();

        return redirect()->route('admin.users');
    }

   
    public function edit($id)
    {
        if($this->userClass->superAdmin($id)) {
            return redirect()->route('admin.users');
        }
        
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    
    public function update(Request $request, $id)
    {
        
        $user = User::find($id);

        $this->validate($request, [
            'name'  =>  'required',
            'email' =>  [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'avatar'    =>  'nullable|image',
            'role'      => 'required'
        ]);
        
       $user->name = $request->name;
       $user->password = Hash::make($request->password);
       $user->role = $request->role;
       $imgOld = User::find($id);
        
       $user->uploadAvatar($request->avatar, $imgOld);
  
       $user->save();
        return redirect()->route('admin.users');
    }

    public function destroy($id)
    {
       if($this->userClass->superAdmin($id)) {
            return redirect()->route('admin.users');
        }
        
        User::find($id)->deleteUser();

        return redirect()->route('admin.users');
    }
}
