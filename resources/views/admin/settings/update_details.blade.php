@extends('admin.layout.layout')

@section('content')
<div class="main-panel">        
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Settings</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">Update Admin Password</h4>     
                @if (Session::has('error_msg'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error:</strong> {{ Session::get('error_msg') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @elseif (Session::has('success_msg'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success:</strong> {{ Session::get('success_msg') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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

                <form class="forms-sample" action="{{ route('admin_update_admin_details') }}" method="POST" enctype="multipart/form-data" name="updateAdminDetailsForm" id="updateAdminDetailsForm">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Admin Username/Email</label>
                        <input type="text" name="username" value={{$adminData['email']}} class="form-control" readonly="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Admin Type</label>
                        <input type="text" name="admin_type" value={{$adminData['type']}} class="form-control" readonly="">
                    </div>
                    <div class="form-group">
                        <label>Admin Name</label>
                        <input type="text" name="admin_name" value={{ Auth::guard('admin')->user()->name }} class="form-control" id="admin_name" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Admin Phone</label>
                        <input type="text" name="admin_phone" value={{$adminData['phone']}} class="form-control" id="admin_phone" required="" maxlength="10" minlength="10">
                    </div>
                    <div class="form-group">
                        <label>Admin Photo</label>
                        <input type="file" name="admin_photo" class="form-control" id="admin_photo">
                        @if (!empty($adminData['image']))
                            <a href="{{ url('admin/images/photos/'.$adminData['image'])}}"><img src="{{ url('admin/images/photos/'.$adminData['image'])}}" width="75" height="50" /></a>
                            <input type="hidden" name="current_photo" value="{{$adminData['image']}}" />
                            @endif
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection