@extends('base')
@section('content')
<h2>Nuevo Atributo</h2>
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
<form action="{{url('atributo')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block ">
            <div class="col-lg-6">
                
                <div class="form-group">
                    <input type="text" class="form-control " placeholder="Nombre" name="nombre" required>
                </div>
                
                <div class="form-group">
                    <textarea class="form-control " placeholder="Descripcion" name="descripcion" required></textarea>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select required name="tipo">
                        <option disabled selected value=""></option>
                        <option value="origen">Origen</option>
                        <option value="clase">Clase</option>
                    </select>
                </div>
                <input  type="submit" class="btn btn-primary" value="Crear">
            </div>
        </div>
        
    </div>
</form>

<script>
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    console.log("asdf")
    readURL(this);
});
</script>
@endsection