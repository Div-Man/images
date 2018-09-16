@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <h1>Edit Image</h1>
            
            <img src="/{{$imageInView->image}}" class="img-thumbnail">
            
            <form action="/update/{{$imageInView->id}}" method="post" enctype="multipart/form-data">
                
                {{csrf_field()}}
                
                <input type="file" name="image">
                
                <div class="form-group">
                 <label for="formGroupExampleInput">Описание</label>
                 <input name="description" type="text" class="form-control" id="formGroupExampleInput" value="{{$imageInView->description}}">
               </div> 
                
                <button type="submit" class="btn btn-warning">Edit</button>
            </form>
        </div>
    </div>
</div>
@endsection