<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        return response()->json(['data'=>$users],200);
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
        //
        $rules=[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:3|confirmed'

        ];
        $this->validate($request,$rules);
        $data=$request->all();
        $data['password']=bcrypt($request->password);
        $data['verified']=User::UNVERIFIED_USER;
        $data['verification_token']=User::generateVerificationCode();
        $data['admin']=User::REGULAR_USER;
        $user=User::create($data);
        return response()->json(['user'=>$user],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return response()->json(['user'=>$user],201);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user=User::findOrFail($id);
        $rules=[
            'email'=>'email|unique:users,email,' .$user->id,
            'password'=>'min:3|confirmed',
            'admin'=>'in:'.User::ADMIN_USER.','.User::REGULAR_USER

        ];
        $this->validate($request,$rules);
        if($request->has('name'))
        {
            $user->name=$request->name;
        }
        if($request->has('email') && $user->email != $request->email)
        {
            $user->verified=User::UNVERIFIED_USER;
            $user->verfication_token=User::generateVerificationCode();
            $user->email=$request->email;
        }
        if($request->has('password'))
        {
            $user->password=bcrypt($request->password);
        }
        if($request->has('admin'))
        {
            if(!$user->isVerified())
            {
                return response()->json(['error'=>'You must be verified to make this change','code'=>401],401);
            }
            $user->admin=$request->admin;
        }
        if(!$user->isDirty())
        {
            return response()->json(['error'=>'You need to make update','code'=>402],402);
        }
        $user->save();
        return response()->json(['user'=>$user],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
       // $user=User::findOrFail($id);
        $user->delete();
        return response()->json(['status'=>'User deleted'],200);

    }
}
