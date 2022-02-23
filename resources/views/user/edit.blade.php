@extends('base')
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif

@if(Session::has('message'))
<div class="alert alert-{{session()->get('type')}}">
    {{ session()->get('message')}}
</div>
@endif


<form class="form"action="{{url('user/'. $user->id)}}" method="post">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block ">
            <div class="col-lg-6">
                
                <div class="form-group">
                    <input type="text" class="form-control " value="{{ $user->name }}" maxlenght="50" placeholder="Nick" name="name" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control " value="{{ $user->email }}" placeholder="Email" name="email" required>
                </div>
                @if (auth()->user()->id == $user->id)
                <div class="form-group">
                    <input type="password" class="form-control " min="1" placeholder="Contraseña Actual" name="oldpassword">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control " min="1" placeholder="Nueva Contraseña" name="password">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control " min="1" placeholder="Repite nueva contraseña" name="password_confirmation">
                </div>
                @endif

                <div class="form-group">
                    
                    <label for="verification">Verificado</label>
                    @if ($user->email_verified_at != null)
                    <input checked type="checkbox" class="form-control " name="verification">
                    @else
                    <input type="checkbox" class="form-control " name="verification">
                    @endif
                    
                </div>
                
                <div class="form-group">
                    <label for="validated">Validado</label>
                    @if ($user->validated == true)
                    <input checked type="checkbox" class="form-control " name="validated">
                    @else
                    <input type="checkbox" class="form-control " name="validated">
                    @endif
                    
                </div>
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select class="form-control " value="{{ old('rol') }}" name="rol" required>
                        <option value=""selected disabled></option>
                        @if ($user->rol == 'user')
                        <option selected value="user">User</option>
                        <option value="admin">Admin</option>
                        @endif
                        @if ($user->rol == 'admin')
                        <option value="user">User</option>
                        <option selected value="admin">Admin</option>
                        @endif
                        @if ($user->rol == 'root')
                        <option selected value="root">Root</option>
                        <option disabled value="user">User</option>
                        <option disabled value="admin">Admin</option>
                        @endif
                        
                    </select>
                </div>
                
                <input  type="submit" class="btn btn-primary" value="Editar">
            </div>
        </div>
    </div>
    
</form>
@endsection