@extends ('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CREATION DE COMPTE</h1>
          </div>
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admin-dashboard">Accueil</a></li>
              <li class="breadcrumb-item active">Enrollement</li>
            </ol>
          </div> -->
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="row justify-content-center">
          @if($errors->any())
              @foreach($errors->all() as $error)
                  <div class="alert alert-class alert-danger text-center col-6">

                  {{$error}}<br>
              </div>
              @endforeach
          @endif
          @if(Session::has('success'))

              <div class="alert
              {{ Session::get('alert-class', 'alert-success') }} text-center col-md-8">

                      {{Session::get('success') }}
              </div>

          @endif

          @if(Session::has('error'))

              <div class="alert
              {{ Session::get('alert-class', 'alert-danger') }} text-center col-8">

                  {{Session::get('error') }}
              </div>

          @endif
      </div>

      <div class="container-fluid">
        <!-- form end -->
        <form method="POST" action="{{ route('superadmin.update', $user_info[0]['user']) }}">
            @csrf
            @method('PUT')
                <!-- Start row -->
                <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">INFOS COMPTE</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                   
                        <div class="card-body">
                        <div class="form-group">
                            <label for="lastname">Nom</label>
                            <input value="{{ $user_info[0]['user']->lastname }}" required name="lastname" type="text" class="form-control" id="lastname" placeholder="Nom">
                        </div>
                        <div class="form-group">
                            <label for="firstname">Prénom</label>
                            <input value="{{ $user_info[0]['user']->firstname }}" required name="firstname" type="text" class="form-control" id="firstname" placeholder="Prénom">
                        </div>
                        <div class="form-group">
                            <label for="phone">Contact</label>
                            <input value="{{ $user_info[0]['user']->phone }}" required name="phone" type="text" class="form-control" id="phone" placeholder="Telephone">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input value="{{ $user_info[0]['user']->email }}" required name="email" type="email" class="form-control" id="email" placeholder="exemple@exemple.com">
                        </div>
                        <div class="form-group">
                            <label for="address">Adresse</label>
                            <input value="{{ $user_info[0]['user']->address }}" required name="address" type="text" class="form-control" id="address" placeholder="Adresse complet">
                        </div>
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->


                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">
                                <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                        <h3 class="card-title">Role</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                    
                        <div class="card-body">
                            <div class="form-group">
                                <select required name="role" class="form-control select2" style="width: 100%;">
                                    <option value="{{ $user_info[0]['user_role']->id }}">{{ $user_info[0]['user_role']->name }}</option>
                                    @for($i = 0; $i < count($role_list); $i++)
                                        <option value="{{$role_list[$i]->id}}">{{ $role_list[$i]->name }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->
    
              </div>
            <!-- /.card --> 
          <!-- </div> -->
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-lg">METTRE A JOUR</button>
        </div>
        <!-- form end -->
    </form>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection