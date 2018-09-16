@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <h1>Add Image</h1>
            <form action="/store" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                @if ($errors->has('image'))
                    <span style="color: red; font-weight: bold;">{{$errors->first('image')}}</span>
                 @endif
                <input type="file" name="image"> 
                <div class="form-group">
                 <label for="formGroupExampleInput">Описание</label>
                 <br>
                  @if ($errors->has('description'))
                    <span style="color: red; font-weight: bold;">{{$errors->first('description')}}</span>
                 @endif
                
                 <input name="description" type="text" class="form-control" id="formGroupExampleInput" placeholder="Введите что-нибудь" value="{{ old('description') }}">
                 <br>
                 @if ($errors->has('choose-category'))
                    <span style="color: red; font-weight: bold;">{{$errors->first('choose-category')}}</span>
                 @endif
                 <br>
                 <select multiple size="10" name="choose-category[]">                    
                      @foreach($category as $cat) 
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                      @endforeach
                 </select>
                 
               </div> 
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection