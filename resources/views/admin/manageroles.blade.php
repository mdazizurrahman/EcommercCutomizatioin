@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.manageroles') }} <small>{{ trans('labels.manageroles') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.manageroles') }}</li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content"> 
    <!-- Info boxes --> 
    
    <!-- /.row -->

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ trans('labels.manageroles') }} </h3>
            <div class="box-tools pull-right">
            	<a href="{{ URL::to('admin/addadmintype')}}" type="button" class="btn btn-block btn-primary">{{ trans('labels.addadmintype') }}</a>
            </div>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		
				  @if (count($errors) > 0)
					  @if($errors->any())
						<div class="alert alert-success alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  {{$errors->first()}}
						</div>
					  @endif
				  @endif
              </div>
              
            </div>
            <div class="row">
              <div class="col-xs-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>{{ trans('labels.ID') }}</th>
                      <th>{{ trans('labels.types') }}</th>
                      <th>{{ trans('labels.Date') }}</th>
                      <th>{{ trans('labels.Status') }}</th>
                      <th>{{ trans('labels.Manage Role') }}</th>
                      <th>{{ trans('labels.Action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                   @if (count($result['adminTypes']) > 0)
						@foreach ($result['adminTypes']  as $key=>$adminType)
							<tr>
								<td>{{ $adminType->admin_type_id }}</td>
								<td>
                                    {{ $adminType->admin_type_name }}
                                </td>
								<td>
                                    <strong>{{ trans('labels.AddedDate')}}: </strong>{{ date('d-m-Y', $adminType->created_at) }}<br>
									<strong>{{ trans('labels.ModifiedDate')}}: </strong>@if(!empty($adminType->updated_at)){{ date('d-m-Y', $adminType->updated_at) }}@else --- @endif<br>
								</td>
                                <td>
                                  @if($adminType->isActive==1)
                                    <strong class="btn btn-success">{{trans('labels.Active')}} </strong>
                               	  @else
                                	<strong class="badge bg-light-grey">{{trans('labels.InActive')}} </strong>
                                  @endif
                                  
                                </td>
                                <td>
                                 <a href="addrole/{{ $adminType->admin_type_id }}" class="manage-role-popup" admin_type_id = "{{ $adminType->admin_type_id }}"> {{ trans('labels.Manage Role')}}</span>
                                </td>
								<td>
                                <ul class="nav table-nav">
                                  <li class="nav-item">
                                    <ul class="nav table-nav">
                                        <li role="presentation"><a class="btn btn-info sm" title="{{ trans('labels.Edit') }}"  role="menuitem" tabindex="-1" href="editadmintype/{{ $adminType->admin_type_id }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></li>
                                        <li role="presentation" class="divider"></li>
                                        <li role="presentation"><a onclick="return confirm('Are you sure?')" href="deleteadmin/{{ $adminType->admin_type_id }}" class="btn btn-danger sm" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteCustomerFrom" customers_id="{{ $adminType->admin_type_id }}"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                    </ul>
                                  </li>
                              </ul>
								</td>
							</tr>
						@endforeach
                    @else
                    	<tr>
							<td colspan="5">{{ trans('labels.NoRecordFound') }}</td>							
						</tr>
                    @endif
                  </tbody>
                </table>
                @if (count($result['adminTypes']) > 0)
					<div class="col-xs-12 text-right">
						{{$result['adminTypes']->links('vendor.pagination.default')}}
					</div>
                 @endif
              </div>
            </div>
          </div>
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
      </div>
      <!-- /.col --> 
    </div>
    
    <!-- /.row --> 
   
    <!-- deleteCustomerModal -->
	<div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-labelledby="deleteCustomerModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="deleteCustomerModalLabel">{{ trans('labels.AdminType') }}</h4>
		  </div>
		  {!! Form::open(array('url' =>'admin/deleteadmintype', 'name'=>'deleteadmintype', 'id'=>'deleteadmintype', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
				  {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
				  {!! Form::hidden('admin_type_id',  '', array('class'=>'form-control', 'id'=>'customers_id')) !!}
		  <div class="modal-body">						
			  <p>{{ trans('labels.Are you sure you want to delete this admin type') }}</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
			<button type="submit" class="btn btn-primary">{{ trans('labels.Delete') }}</button>
		  </div>
		  {!! Form::close() !!}
		</div>
	  </div>
	</div>
    
    <div class="modal fade" id="manageRoleModal" tabindex="-1" role="dialog" aria-labelledby="manageRoleModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content" id="manage-role-content">
		  
		</div>
	  </div>
	</div>

    <!-- Main row --> 
    
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
@endsection 