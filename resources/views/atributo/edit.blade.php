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
<form action="{{url('atributo/'. $atributo->id)}}" method="post">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block ">
            <div class="col-lg-6">
                
                <div class="form-group">
                    <input type="text" class="form-control " placeholder="Nombre" name="nombre" required value="{{ $atributo->nombre}}">
                </div>
                
                <div class="form-group">
                    <textarea class="form-control " placeholder="Descripcion" name="descripcion" required>{{ $atributo->descripcion }}</textarea>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select required name="tipo">
                        @if ($atributo->tipo == "origen")
                        <option selected value="origen">Origen</option>
                        <option value="clase">Clase</option>
                        @else
                        <option value="origen">Origen</option>
                        <option selected value="clase">Clase</option>                        
                        @endif

                    </select>
                </div>
                <input type="submit" class="btn btn-primary" value="Editar">
            </div>
        </div>
        
    </div>
</form>
@endsection