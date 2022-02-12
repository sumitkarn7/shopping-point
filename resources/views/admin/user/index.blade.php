@extends('admin.template')


@section('title','Ecommerce Site || All User')


@section('js')

    <script>

        $(document).on('click','.show-user',function(e){

            e.preventDefault();

            let user_id=$(this).data('userid');
            // console.log('Banner-Id:',banner_id);

            $.ajax({
                url:"{{ route('show-user') }}",
                type:"get",
                data:{
                    user_id:user_id
                },
                success:function(response)
                {
                    if(typeof(response) !='object')
                    {
                        response=JSON.parse(response);
                    }

                    if(response.error)
                    {
                        alert(response.error);
                    }

                   
                    $('#main-name').html(response.data.name);
                    $('#user_name').html(response.data.name);
                    $('#email').html(response.data.email);
                    $('#role').html(response.data.role);
                    $('#status').html(response.data.status);
                    $('#user_address').html(response.user_address);
                    $('#user_phone').html(response.user_phone);
                    $('#created_by').html(response.user_name);


                    
                }
            })
        });

    </script>
    
    
                
@endsection


@section('main-content')

<div class="page-title">
        <h3>User</h3>
        <p class="text-subtitle text-muted">All User Listed Here......</p>
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">User List</h4>
                        
                        <div class="d-flex ">
                        <a href="{{ route('user.create') }}" class="btn btn-sm btn-success">
                            <i data-feather="plus"></i> Add User
                        </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="table-responsive">
                            <table class='table mb-0 text-center' id="myTable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Image</th>
                                        <th>Created-By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($user)
                                        @foreach($user as $user_info)
                                            <tr class="{{ $user_info->trashed() ?'table-danger':''}}">
                                                <td>{{ $user_info->id}}</td>
                                                <td>{{ ucfirst($user_info->name) }}</td>
                                                <td>{{ $user_info->email}}</td>
                                                <td>{{ $user_info->role}}</td>
                                                <td>
                                                    <a href="{{ route('user.update-status',[$user_info->id,$user_info->status]) }}" class="badge bg-{{ $user_info->status=='active'?'success':'danger'}}">
                                                        {{ ucfirst($user_info->status)}}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($user_info->UserInfo && $user_info->UserInfo->image !=null)
                                                        <a href="{{ asset('Uploads/User/'.$user_info->UserInfo->image) }}" data-lightbox="image-{{ $user_info->id}}" data-title="{{$user_info->title}}">
                                                            Image
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{ @$user_info->UserInfo->getUser->name}}</td>
                                                <td>
                                                    <a href="javascript:;" data-userid="{{ $user_info->id}}" class="btn btn-sm icon btn-rounded btn-dark btn-style show-user" data-toggle="modal" data-target="#user-detail">
                                                        <i data-feather="eye"></i>
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-sm  icon btn-rounded btn-danger btn-style delete-user" data-id="{{ $user_info->id}}">
                                                        <i data-feather="trash"></i>
                                                    </a>

                                                    <a href="{{ route('user.edit',$user_info->id) }}" class="btn btn-sm  icon btn-rounded btn-primary btn-style" >
                                                        <i data-feather="edit-3"></i>
                                                    </a>
                                                    {{ Form::open(['url'=>route('user.destroy',$user_info->id),'class'=>'delete-form'])}}
                                                        @method('delete')
                                                    {{ Form::close()}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


                <!--scrollbar Modal -->
                <div class="modal fade" id="user-detail" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title" id="exampleModalLongTitle">Detail Of User--<span id="main-name"></span> </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <strong>Name :</strong> <span id="user_name"></span>
                                    </div>
                                    <br>
                                    <div>
                                        <strong>Email :</strong> <span id="email"></span>
                                    </div>
                                    <br>
                                    <div>
                                        <strong>Role :</strong> <span id="role"></span>
                                    </div>
                                    <br>
                                    <div>
                                        <strong>Status :</strong> <span id="status"></span>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-md-6">
                                    <div>
                                        <strong>Address :</strong> <span id="user_address"></span>
                                    </div>
                                    <br>
                                    <div>
                                        <strong>Phone :</strong> <span id="user_phone"></span>
                                    </div>
                                    <br>
                                    <div>
                                        <strong>Created-By :</strong> <span id="created_by"></span>
                                    </div>
                                </div>
                            </div>    

                                                            
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                            </button>

                        </div>
                        </div>
                    </div>
                    </div>

@endsection


