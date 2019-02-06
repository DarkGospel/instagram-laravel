@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card">
                @include('includes.message')
                <div class="card-header">Subir nueva imagen</div>
            
            <div class="card-body">
                
                <form method="POST" action="{{route('image.save')}}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group row">
                        <label for="image_path" class="col-md-3 col-form-label text-md-right">Imagen</label>
                        <div class="col-md-7">
                            <input type="file" id="image_path" name="image_path" class="form-control" required/>
                            
                            @if($errors->has('image_path'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$erros->first('image_path')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="descripcion" class="col-md-3 col-form-label text-md-right">descripcion</label>
                        <div class="col-md-7">
                            <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
                            
                            @if($errors->has('descripcion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$erros->first('descripcion')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                       
                        <div class="col-md-6 offset-md-3">
                            <input type="submit" class="btn btn-primary" value="Subir imagen"/>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection