<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use App\Models\Atributo;
use App\Models\AtributoFicha;
use App\Models\ImagenFicha;
use Illuminate\Http\Request;
use App\Http\Requests\FichaCreateRequest;
use App\Http\Requests\FichaEditRequest;
use Illuminate\Support\Str;
class FichaController extends Controller
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
        $data['filters'] = ['nombre' =>'Nombre','coste' => 'Coste', 'ad'=> 'Daño de ataque', 'ap'=> 'Poder de habilidad', 'vida'=> 'Vida','mana'=> 'Mana'];
        $orderby = $request->input('orderby') ? $request->input('orderby') : 'id';
        $appendData = ['filter' => $type, 'order' => $order, 'search'=> $search, 'orderby' => $orderby];
        $data['appendData'] = $appendData;
        $ficha = Ficha::where($type, 'like', '%'.$search.'%')->orderBy($orderby, $order)->paginate(5)->appends($appendData);
        $data['fichas'] = $ficha;
        $data['filterselected'] = $type;
        $data['searchvalue'] = $search;
        // dd($data);
        return view('ficha.index')->with($data);
        
    }

    public function create(){
        $data = [];
        $data['atributos'] = Atributo::all();
        return view('ficha.create')->with($data);
    }


    public function store(FichaCreateRequest $request){
        $data = [];
        try{
            $ficha = new Ficha($request->all());
            //dd($ficha);
            $ficha->imagen = $request->file('imagen')->getClientOriginalName();
            $ficha->save();
            $this->uploadImg($request, $ficha->id);
            if ($request->input('atributo')){
                foreach($request->input('atributo') as $atributo){
                    $atributoficha = new AtributoFicha(['idficha' => $ficha->id, 'idatributo' => $atributo]);
                    $atributoficha->save();
                }
            }
            $data['type'] = 'success';
            $data['message'] = 'Ficha añadida con exito';
        } catch(\Exception $e){
            dd($e);
            $data['type'] = 'error';
            $data['message'] = 'No ha podido añadirse la ficha, intentalo de nuevo';
            
            return back()->withInput()->with($data);
        }
        // dd($data);
        return redirect('ficha')->with($data);
    }


    public function show(Ficha $ficha){
        
        $data = [];
        $data['ficha'] = $ficha;
        $atribs = AtributoFicha::where('idficha', $ficha->id)->get();
        $atributos = [];
        foreach($atribs  as $atr){
            $atributos[] = Atributo::find($atr->idatributo); 
        }
        
        $data['atributos'] = $atributos;
        return view('ficha.show', $data);
    }

    public function edit(Ficha $ficha){
        $data = [];
        $data['ficha'] = $ficha;
        $atribs = AtributoFicha::where('idficha', $ficha->id)->get();
        $atributos = [];
        foreach($atribs  as $atr){
            $atributos[] = Atributo::find($atr->idatributo); 
        }
        $data['atributos'] = $atributos;
        $data['allatributos'] = Atributo::all();
        return view('ficha.edit', $data);
    }

    public function update(FichaEditRequest $request, Ficha $ficha) {
        
        $result = true;
        try {
            $result = $ficha->update($request->all());    
            if ($request->file('imagen')){
                $img = ImagenFicha::where('idficha', $ficha->id)->get();
                $fichaid = $ficha->id;
                $imgid = $img[0]->id;
                $this->updateImg($fichaid, $imgid, $request);
            }
            if(AtributoFicha::where('idficha', $ficha->id)->count() == count($request->atributo)){
                $atributosfichas = AtributoFicha::where('idficha', $ficha->id)->get();
                for($i = 0; $i < count($request->atributo); $i++){
                    $atributosfichas[$i]->idatributo = $request->atributo[$i];
                    $atributosfichas[$i]->save();
                }
            } else{
                $atributosfichas = AtributoFicha::where('idficha', $ficha->id)->get();
                foreach($atributosfichas as $atribficha){
                    $atribficha->delete();
                }
                foreach($request->input('atributo') as $atributo){
                    $atributoficha = new AtributoFicha(['idficha' => $ficha->id, 'idatributo' => $atributo]);
                    $atributoficha->save();
                }
            }
            $data['type'] = 'success';
            $data['message'] = 'Ficha actualizada';
            return redirect('ficha')->with($data);
        } catch(\Exception $e){
            // dd($e);
            $data['type'] = 'danger';
            $data['message'] = 'La ficha no ha podido actualizarse';
            $result = false;
            return back()->withInput()->with($data);
        }
    }

    public function destroy(Ficha $ficha) {
        $data =[];
        try{
            $ficha->delete();    
            $data['type'] = 'success';
            $data['message'] = 'La ficha ha sido borrada';
        } catch(\Exception $e){
            $data['type'] = 'danger';
            $data['message'] = 'La ficha no ha podido borrarse';
            dd($e);
        }
        
        return redirect('ficha')->with($data);
    }
    
    public function uploadImg(Request $request, $id){
        $datos = [];
        $data = [];
        //idempleado nombre	nombreoriginal	mimetype
        $archivo = $request->file('imagen');
        $nombre = $request->input('nombre'); //nombre con el que se guarda el archivo en el storage
        $img = new ImagenFicha($request->all());
        // $archivo = $request->file('imagen');
        $img->nombreoriginal = $archivo->getClientOriginalName();;
        $img->mimetype = $archivo->getMimeType();
        $img->idficha = $id;
        $nuevoNombre = Str::random(12);
        $img->nuevonombre = $nuevoNombre;
        
        try{
            $result = $img->save();
            if($result){
                $path = $archivo->storeAs('public/images/'. $id . '/', $nuevoNombre);
                $ficha = Ficha::find($id);
                $ficha->imagen = $img->nuevonombre;
                $ficha->save();
                $data['message'] = "Imagen subida";
                $data['type'] = "success";
            }
        } catch(\Exception $e){
            dd($e);
            $data['message'] = "Ha ocurrido un error al subir la imagen";
            $data['type'] = "danger";
        }
        
        return back()->withData($data);
    }
    
    public function updateImg($idficha, $idimagen, Request $request){
        
        
        $data = [];
        try{
            $img = ImagenFicha::find($idimagen);
            $img->nombre = $request->input('nombre');
            $archivo = $request->file('imagen');
            $img->nombreoriginal = $archivo->getClientOriginalName();;
            $img->mimetype = $archivo->getMimeType();
            $img->idficha = $idficha;
            $nuevoNombre = Str::random(12);
            
            $img->nuevonombre = $nuevoNombre;
            $result = $img->update();
            if ($result){
                $path = $archivo->storeAs('public/images/'. $idficha . '/', $nuevoNombre);
                $ficha = Ficha::find($idficha);
                $ficha->imagen = $img->nuevonombre;
                $ficha->save();
                $data['message'] = "Imagen subida";
                $data['type'] = "success";
            } else {
                $data['message'] = "Ha ocurrido un error al actualizar el nombre de la imagen";
                $data['type'] = "danger";
                return back()->withData($data);
            }
            $data['message'] = "Nombre de la imagen actualizado";
            $data['type'] = "success";
            //return redirect('ficha/'. $idficha)->withData($data);
        }catch(\Exception $e){
            dd($e);
            $data['message'] = "Ha ocurrido un error al actualizar el nombre de la imagen";
            $data['type'] = "danger";
            return back()->withData($data);
        }
    }
    
    public function deleteImg($idficha, $idimagen){
        $data = [];
        try{
            $img = ImagenFicha::find($idimagen);
            Storage::delete('public/images/'. $idficha. '/' . $img->nuevonombre);
            $img->delete();
            $data['message'] = "Imagen borrada";
            $data['type'] = "success";
            return redirect('empleado/'. $idficha)->withData($data);
        }catch(\Exception $e){
            $data['message'] = "Ha ocurrido un error al borrar la imagen";
            $data['type'] = "danger";
            return back()->withData($data);
        }
    }

}
