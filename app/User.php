<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function isRole()
    {
        
        $id = Auth::id();
        
        if($id) {
             $role = $this::where('id', '=', $id)->firstOrFail()->role;
        
            if($role == 'admin') return 'Админ';

            return 'Пользователь';
            }
        
        return 'Гость';
        
    }
    
    public function addUser($user)
    {   
        
        $this->name = $user['name'];
        $this->email = $user['email'];
        $this->role = $user['role'];
    }
    
    public function generatePassword($password)
    {
         $this->password = Hash::make($password);
    }
    
    public function uploadAvatar($image, $imgOld = null)
    {

        if($image && $imgOld->image){
            if($imgOld->image == 'uploads/users/ava.png') {
                
                //Что бы не удалять дефолтную картинку
                $fileName = $image->store('uploads/users');
                $this->image = $fileName;
            }
            else {
                $this->deleteAvatar($imgOld);
                $fileName = $image->store('uploads/users');
                $this->image = $fileName;
            }
    
        }
        
        if($imgOld) return;
             
        if($image === null) {
              return $this->image = 'uploads/users/ava.png';
        }
        
    }
    
    public function deleteAvatar($imgOld)
    {
        if($imgOld) {
             Storage::delete($imgOld->image);
        }
        
    }
    
    public function deleteUser()
    {
        $this->deleteAvatar($this);
        $this->delete();
    }
    
    public function superAdmin($id)
    {
         $user = User::find($id);
           if($user->id == 1){
             return true;
        }
    }
}
