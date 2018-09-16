@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Добавить статью
        <small>приятные слова..</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Добавляем статью</h3>
          @include('admin.errors')
        </div>
          
          <form action="{{url('/admin/posts/store')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Название</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="description" value="{{old('title')}}">
            </div>
            
            <div class="form-group">
              <label for="exampleInputFile">Изображение</label>
              <input type="file" id="exampleInputFile" name="image">
              
            </div>
            <div class="form-group">
              <label>Категория</label><br>
              
                <select multiple size="10" name="choose-category[]">                    
                      @foreach($category as $cat) 
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                      @endforeach
                 </select>
              
            </div>

          </div>
         
         
      </div>
      
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-default">Назад</button>
          <button class="btn btn-success pull-right">Добавить</button>
        </div>
        </form>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
	
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection