<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
class UserController extends Controller
{
    
            
    public function __construct() {
        $this->middleware('verified');
        $this->middleware('adminmiddleware')->only(['create', 'edit', 'update', 'delete', 'store']);
    }
    
    public function index(Request $request){
        $data = [];
        $data['appendData'] = [];
        $search = $request->input('search') ? $request->input('search') : '';
        $type = $request->input('filter') ? $request->input('filter') : 'id';;
        $order = $request->input('order') ? $request->input('order') : 'asc';
        $data['filters'] = ['name' =>'Nick','email' => 'Email'];
        $orderby = $request->input('orderby') ? $request->input('orderby') : 'id';
        $appendData = ['filter' => $type, 'order' => $order, 'search'=> $search, 'orderby' => $orderby];
        $data['appendData'] = $appendData;
        $users = User::where($type, 'like', '%'.$search.'%')->orderBy($orderby, $order)->paginate(5)->appends($appendData);
        $data['users'] = $users;
        $data['filterselected'] = $type;
        $data['searchvalue'] = $search;
        // dd($data);
        return view('user.index')->with($data);
    }
    
    public function create(){
        $data = [];
        $data['roles'] = ['user', 'admin'];
        return view('user.create')->with($data);
    }
    
    public function store(UserCreateRequest $request){
        try{
            $user = new User($request->all());
            $user->password = Hash::make($request->password);
            
            if($request->verification == 'on'){
                $user->email_verified_at = Carbon::now();
            } else {
                // $user->sendEmailVerificationNotification();
            }
            if($request->validated == 'on'){
                $user->validated = true;
            }
            $user->save();
            return redirect('user');
        } catch(\Exception $e){
            dd($e);
            return back()->withInput();    
        }
        
        
    }

    public function show(User $user){
        $data = [];
        $data['user'] = $user;
        return view('user.show', $data);
    }

    public function edit(User $user){
        if (($user->rol != 'user' )&& auth()->user()->rol != 'root' && $user->id != auth()->user()->id  ){
            return redirect('user');
        }
        
        $data = [];
        $data['user'] = $user;
        return view('user.edit')->with($data);
    }

    public function update(UserEditRequest $request, User $user)
    {
        $result = true;
        
        if ($request->oldpassword != null || $request->password != null){
            //dd([Hash::make($request->oldpassword), auth()->user()->password]);
            $r = Hash::check($request->oldpassword, auth()->user()->password);
            if($r){
                $result = $this->saveUser($request, true, $user);
            } else {
                return back()->withInput()->with(['message' => 'La clave de acceso anterior no es correcta', 'type' => 'danger']);
            }
        } elseif($request->oldpassword == null || $request->password == null){
            $result = $this->saveUser($request, false, $user);
        } else {
            dd("entro por el else");
            return back()->withInput()->withError(['generico' => 'Se han de introducir las claves de acceso o no']);
        }
        if($result){
            $data = [];
            $data['type'] = 'success';
            $data['message'] = 'Usuario editado';            
            return redirect('user');
        } else {
            $data = [];
            $data['type'] = 'danger';
            $data['message'] = 'error al editar el usuario';
            return back()->withInput()->with($data);
        }
    }
    
    public function destroy(User $user){
        $user->delete();
        return redirect('user');
    }
    
    private function saveUser(UserEditRequest $request, $isNewPassword, User $user){
        $result = true;
        
        $user->name = $request->input('name');
        if($user->email != $request->input('email') && $request->input('email') != ''){
            
            $user->email = $request->input('email'); 
            //anular la fecha de verificacion.
            $user->email_verified_at = null;
            //Enviar correo electronico.
            $user->sendEmailVerificationNotification();
        }
        if($isNewPassword){
            $user->password = Hash::make($request->input('password'));
        }
        try{
            
            if($request->verification == 'on' && $user->email_verified_at == null){
                $user->email_verified_at = Carbon::now();
            }
            
            $user->save();
            // $user->sendEmailVerificationNotification();
        } catch(\Exception $e){
            dd($e);
            $result = false;
        }
        return $result;
    }
} 
