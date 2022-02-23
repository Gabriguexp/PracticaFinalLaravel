@extends('base')
@section('content')
@if(Session::has('message'))

<div class="alert alert-{{session()->get('type')}}">
    {{ session()->get('message')}}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif


<script src="{{ url('assets/vendor/jquery/jquery.min.js') }}"></script>
<form class="form"action="{{url('user')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block ">
            <div class="col-lg-6">
                
                <div class="form-group">
                    <input type="text" class="form-control " value="{{ old('name') }}" maxlenght="50" placeholder="Nick" name="name" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control " value="{{ old('email') }}" placeholder="Email" name="email" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control " value="{{ old('password') }}" min="1" placeholder="Contraseña" name="password" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control " value="{{ old('password_confirmation') }}" min="1" placeholder="Repite contraseña" name="password_confirmation" required>
                </div>
                
                <div class="form-group">
                    <label for="verification">Verificado</label>
                    <input type="checkbox" class="form-control " name="verification">
                </div>
                
                <div class="form-group">
                    <label for="validated">Validado</label>
                    <input type="checkbox" class="form-control " name="validated">
                </div>
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select class="form-control " value="{{ old('rol') }}" name="rol" required>
                        <option value=""selected disabled></option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                
                <input  type="submit" class="btn btn-primary" value="Crear">
            </div>
        </div>
    </div>
    
</form>

@endsection