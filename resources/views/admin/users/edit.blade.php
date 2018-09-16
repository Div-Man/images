@extends('admin.layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Добавить пользователя
        <small>приятные слова..</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <form action="{{route('admin.users.update', ['id' => $user->id])}}" method="post" enctype="multipart/form-data">
      <input type="hidden" name="_method" value="PUT">
      {{csrf_field()}}
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Добавляем пользователя</h3>
          @include('admin.errors')
        </div>
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Имя</label>
              <input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="" value="{{$user->name}}">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">E-mail</label>
              <input type="text" class="form-control" id="exampleInputEmail1" name="email" placeholder="" value="{{$user->email}}">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Пароль</label>
              <input type="password" class="form-control" id="exampleInputEmail1" name="password" placeholder="">
            </div>
            <div class="form-group">
              <img src="{{$user->image}}" alt="" width="200" class="img-responsive">
              <label for="exampleInputFile">Аватар</label>
              <input type="file" name="avatar" id="exampleInputFile">

              <p class="help-block">Какое-нибудь уведомление о форматах..</p>
            </div>
              <div class="form-group">
              <label>Роль</label><br>
              
                <select name="role">                     
                   @if ($user->role === 'user')
                       <option selected value="user">Пользователь</option> 
                       <option value="admin">Админ</option> 
                    @endif
                    
                     @if ($user->role === 'admin')
                       <option value="user">Пользователь</option> 
                       <option selected value="admin">Админ</option> 
                    @endif
                 </select>
              
              
              
            </div>
        </div>
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-warning pull-right">Изменить</button>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
	</form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection