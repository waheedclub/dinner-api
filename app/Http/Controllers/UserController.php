<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['users'] = User::all();
        return $this->respond()
       ->data($data)
       ->send();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
            'name' => 'required|string|max:30',
             'role' => 'required',
             'status' => 'required',
            'image' => 'required',
             'email' => 'required|email|unique:users,email',
             'password' => 'required|min:4|max:20'
        ]);
       $validated['password'] = Hash::make($request->password);
       $data['user'] = User::create($validated);
       return $this->respond()
       ->data($data)
       ->message('User register successfully')
       ->send();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30',
             'role' => 'required',
             'status' => 'required',
            'image' => 'required',
             'email' => 'required|email|unique:users,email,'.$user->id,
        ]);
        if($request->password and $request->password != '') {
           $validated['password'] = Hash::make($request->password);
        }
       $user->update($validated);
       return $this->respond()
       ->message('User updated successfully')
       ->send();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->id == auth()->user()->id) {
            throw ValidationException::withMessages([
                'error' => ['You cannot delete yourself'],
            ]);
        }
        $user->delete();
        return $this->respond()
       ->message('User deleted successfully')
       ->send();
    }
}
