@extends('base')
@section('content')

<h2>Nueva Ficha</h2>

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
<form class="form"action="{{url('ficha')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block ">
            <div class="col-lg-6">
                
                <div class="form-group">
                    <input type="text" class="form-control " value="{{ old('nombre') }}" maxlenght="50" placeholder="Nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control " value="{{ old('coste') }}" placeholder="Coste" name="coste" min="1" max="5" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control " value="{{ old('ad') }}" min="1" placeholder="Daño de ataque" name="ad" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control " value="{{ old('ap') }}" min="1" placeholder="Poder de habilidad" name="ap" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control " value="{{ old('vida') }}" min="1" placeholder="Vida" name="vida" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control " value="{{ old('mana') }}" min="1" placeholder="Mana" name="mana" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control "placeholder="Definitiva" name="ulti" required>{{ old('ulti') }}</textarea>
                </div>
                <div class="form-group">
                    <input id="imgInp" type="file" value="{{ old('imagen') }}" name="imagen" required accept="image/*">
                </div>
                <input  type="submit" class="btn btn-primary" value="Crear">
            </div>
        </div>
        <div class="col-md-5" style="box-sizing:border-box;">
            <img id="img" width="100%"src="https://images.contentstack.io/v3/assets/blt731acb42bb3d1659/bltcb2c4b07583666f5/6137f97a876fcf3cb80c3446/EsportsPengu_Header.jpg" alt="Img">
        </div>
    </div>
    
</form>

<button id="add-btn" class="btn btn-info">Añadir atributo</button>

<div class="form-group attribute-select sample hidden" >
    <button class="btn btn-warning remove-btn">Borrar atributo</button>
    <label for="tipo">Tipo</label>
    <select required  name="atributo[]">
        <option disabled selected value=""></option>
        @foreach($atributos as $atributo)
        <option value="{{ $atributo->id }}">{{ $atributo->nombre }}</option>
        @endforeach
    </select>
</div>

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

$('#add-btn').on('click', function(event){
    event.preventDefault()
    let select = $('.sample').clone()
    select.removeClass('sample')
    select.removeClass('hidden')
    
    select.children('.remove-btn').on('click', function(event){
    event.preventDefault()
    $(this).parent().remove()
})
    $('.form').append(select)
})



</script>
@endsection