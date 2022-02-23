@extends('base')
@section('content')
<h2>Users</h2>
@if(Session::has('message'))

<div class="alert alert-{{session()->get('type')}}">
    {{ session()->get('message')}}
</div>
@endif

<form class="form-inline" action="{{ $rutaSearch ?? '' }}" method="get">
  <div class="input-group">
    <div class="form-outline">
      @foreach($appendData as $name => $value)
      
      <input type="hidden" name="{{$name}}" value="{{$value}}">
      @endforeach
      
      <select name="filter" class="form-select">
        <option value="" disabled selected>Filtro</option>
        @foreach($filters as $filter => $filterdata)
        @if ($filter == $appendData['filter'])
        <option selected value="{{ $filter }}">{{ $filterdata }}</option>
        @else
        <option value="{{ $filter }}">{{ $filterdata }}</option>
        @endif
        @endforeach
      </select>
      <input placeholder="Search..."type="search" id="form1" value="{{$appendData['search']}}"name="search" class="form-control" />
      
    </div>
    <button type="submit" style="margin-left:5px" type="button" class="btn btn-primary">
      <i class="fas fa-search"></i>
    </button>
  </div>
</form>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Borrar Ficha</h5>
        <button type="button" id="cross-modal-btn" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Estás a punto de borrar al usuario <span id="delete-item">asdf</span>
      </div>
      <div class="modal-footer">
        <button type="button" id="close-modal-btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="delete-modal-btn" class="btn btn-primary">Borrar</button>
      </div>
    </div>
  </div>
</div>
<form id="delete-form" method="POST" action="">
  @csrf
  @method('delete')
</form>

<table class="table">
    <thead class="thead">
        <tr>
            <td>#</td>
            <td>
              <a href="{{ route('user.index',['orderby' =>'id', 'order'=>'asc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-up"></i></a>
              ID
              <a href="{{ route('user.index',['orderby' =>'id', 'order'=>'desc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-down"></i></a>
            </td>
            <td>
              <a href="{{ route('user.index',['orderby' =>'id', 'order'=>'asc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-up"></i></a>
              Nickname
              <a href="{{ route('user.index',['orderby' =>'id', 'order'=>'desc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-down"></i></a>
            </td>
            <td>
              <a href="{{ route('user.index',['orderby' =>'id', 'order'=>'asc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-up"></i></a>              
              Email
              <a href="{{ route('user.index',['orderby' =>'id', 'order'=>'desc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-down"></i></a>
            </td>
            <td>Email Verificado</td>
            <td>Rol</td>
            <td>Validated</td>
            <td>Ver</td>
            @if (auth()->user()->rol != 'user')
            <td>Editar</td>
            <td>Borrar</td>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ ($user->email_verified_at ? $user->email_verified_at  : 'No verificado')}}</td>
            <td>{{ $user->rol }}</td>
            <td>{{ $user->validated ? 'Usuario verificado' : '' }}</td>
            
            <td><a href="{{url('user/'. $user->id)}}">Ver</a></td>
            @if (auth()->user()->rol != 'user')

            @if($user->rol != 'user' && auth()->user()->rol != 'root')
            
            @else
            <td><a href="{{url('user/'. $user->id . '/edit')}}">Editar</a></td>
            <td><a href="" data-name="{{ $user->name }}" data-id="{{ $user->id  }}" class="delete-btn">Delete</a></td>
            @endif
            
            
            @if ($user->id != auth()->user()->id)
            
            @endif
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

@if (auth()->user()->rol != 'user')
<a class="btn btn-primary" href="{{ url('user/create') }}">Dar de alta nuevo usuario</a>
@endif

@endsection
@section('js')
<script>
var myModal = new bootstrap.Modal(document.getElementById('exampleModal'))

$('.delete-btn').on('click', function(event){
  event.preventDefault();
  myModal.show();
  $('#delete-item').text($(this).data('name'))
  $("#delete-form").attr('action', 'user/'+$(this).data('id'));

})

$('#close-modal-btn').on('click', function(){
  myModal.toggle();
})

$('#cross-modal-btn').on('click', function(){
  myModal.toggle();
})

$('#delete-modal-btn').on('click', function() {
  console.log("asdf")
  
    $("#delete-form").submit();
})
</script>
@endsection