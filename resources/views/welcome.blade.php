@extends('layout')

@section('content')



<div class="container">
    
    
    <h1 align="center">My Gallery</h1>
    
    <div class="row">
        <div class="col-sm-3 " style="padding: 10px;">
            <p align="center">Категории</p>
            
           
            <ul class="list-group">
                @foreach($allCategory as $cat) 
                    <li class="list-group-item"><a href="/category/{{$cat->id}}">{{$cat->name}}</a></li>
                @endforeach
            </ul>
        </div>
        
    
         
        @foreach($imagesInView as $image)
      
        <div class="col-sm-3 gallery-item">
            <div>
                <img src="/{{$image->image}}" class="img-thumbnail">
                <p style="text-align: center;">{{$image->description}}<p>
            </div>
          <a href="/show/{{$image->id}}" class="btn btn-info my-button">Show</a>
          <a href="/edit/{{$image->id}}" class="btn btn-warning my-button">Edit</a>
          <a href="/delete/{{$image->id}}" onclick="return confirm('Точно удалить?')"class="btn btn-danger my-button">Delete</a>
        </div>
        @endforeach
        
        
    </div>
    
    
    <div style="
        display: table; 
        margin: 0 auto; 
        text-align: center
         ">
        
        {{$imagesInView->links()}}
    </div>  
 
    
</div>

@endsection
    