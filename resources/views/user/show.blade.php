@extends('base')
@section('content')
@if(Session::has('message'))

<div class="alert alert-{{session()->get('type')}}">
    {{ session()->get('message')}}
</div>
@endif
<h2>{{ $user->name}}</h2>
<form class="form"action="{{url('user')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block ">
            <div class="col-lg-6">
                
                <div class="form-group">
                    <input type="text" class="form-control " disabled value="{{ $user->name }}" maxlenght="50" placeholder="Nick" name="name" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control " disabled value="{{ $user->email }}" placeholder="Email" name="email" required>
                </div>


                <div class="form-group">
                    <label for="verification">Verificado</label>
                                        @if ($user->email_verified_at != null)
                    <input type="checkbox" disabled class="form-control " checked name="verified">
                    @else
                    <input type="checkbox" disabled class="form-control "  name="verified">
                    @endif
                </div>
                
                <div class="form-group">
                    <label for="validated">Validado</label>
                    @if ($user->validated)
                    <input type="checkbox" disabled class="form-control " checked name="validated">
                    @else
                    <input type="checkbox" disabled class="form-control "  name="validated">
                    @endif
                    
                </div>
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select class="form-control "disabled name="rol" required>
                        <option disabled value=""selected disabled></option>
                        @if ($user->rol == 'root')
                        <option selected value="root">Root</option>
                        
                        @endif
                        @if ($user->rol == 'admin')
                        <option selected value="admin">Admin</option>
                        @else
                        <option value="admin">Admin</option>
                        @endif
                        @if ($user->rol == 'user')
                        <option selected value="user">User</option>
                        @else
                        <option value="user">User</option>
                        @endif
                        
                    </select>
                </div>
                
            </div>
            @if(auth()->user()->id == $user->id)
            <a href="{{ url('user/'.$user->id. '/edit/') }}">Editar perfil</a>
            @endif
        </div>
        <div class="col-lg-3">
            @if ($user->rol == 'user')
            <img class="rounded-circle" width="100%" heigth="100%"src="{{ url('assets/img/t3ghost.png') }}"></img>            
            @elseif ($user->rol == 'admin') 
            <img class="rounded-circle" width="100%" heigth="100%"src="{{ url('assets/img/aoshin.png') }}"></img>            
            @else
            <img class="rounded-circle" width="100%" heigth="100%"src="{{ url('assets/img/chaospengu.jpg') }}"></img>            
            @endif
            
        </div>
        
    </div>
    
</form>
@endsection