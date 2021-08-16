@extends('console::today.theme')
@section('inner-title', "$title - ")

@section('inner-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.btekno.id/templates/console/css/datatable.css">
@endsection

@section('inner-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function() {
            var table = $('#datatable').DataTable({ 
                processing: true,
                serverSide: true,
                iDisplayLength: 25, 
                scrollY: 'calc(100vh - 370px)',
                ajax : '{!! request()->fullUrl() !!}?datatable=true', 
                columns: [
                    { data: 'pilihan', name: 'pilihan', className: 'table-column-pr-0', orderable: false, searchable: false },
                    { data: 'order', name: 'order', className: 'text-center', orderable: false, searchable: false },
                    { data: 'name', name: 'name', orderable: false, searchable: false },
                    { data: 'display', name: 'display', className: 'text-center', orderable: false, searchable: false },
                    { data: 'aksi', name: 'aksi', className: 'text-right', orderable: false, searchable: false }
                ],
                oLanguage: {
                    sLengthMenu: "_MENU_ entries",
                    sSearch: "Cari:"
                }, 
                fnDrawCallback: function( oSettings ) {
                    @include('console::layouts.components.scripts.callback')
                }
            });
            $('.js-file-attach').each(function () {
	            var customFile = new HSFileAttach($(this)).init();
	        });
        });
    </script>
@endsection

@section('inner-content')
	
	@include('console::layouts.components.breadcrumb', [
        'title' => $title, 
        'hapus' => true, 
        'breadcrumbs' => [
            route('console::today.index') => 'Today', 
            '#referensi' => 'Referensi', 
        ]
    ])

    <div class="row no-gutters">
    	<div class="col-md-8">
    		<div class="card border-0 shadow-none rounded-0">
    			<div class="card-header rounded-0 bg-dark py-2 px-3">
					<h3 class="card-title text-light h5">
						<i class="tio-format-points"></i> List Reaction
					</h3>
				</div>
				<div class="card-body p-0">
					{!! Form::open(['method' => 'DELETE', 'route' => ["$prefix.destroy", 'hapus-all'], 'id' => 'submit-all']) !!}
						<div class="table-responsive">
							<table id="datatable" class="table table-thead-bordered table-hover table-align-middle">
								<thead class="thead-light">
									<tr>
										<th class="table-column-pr-0" width="1">
											<div class="custom-control custom-checkbox">
												<input id="check-all" type="checkbox" class="custom-control-input">
												<label class="custom-control-label" for="check-all"></label>
											</div>
										</th>
										<th width="1">ORDER</th>
										<th>LABEL</th>
										<th width="1">STATUS</th>
										<th width="10%"></th>
									</tr>
								</thead>
							</table>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
    	</div>
		<div class="col-md-4 ml--1">
			@isset($edit)
				{!! Form::model($edit, ['route' => ["$prefix.update", $edit->id], 'method' => 'PUT', 'files' => true]) !!}
					<div class="card rounded-0 border-0 shadow-none mb-0">
						<div class="card-header rounded-0 bg-dark py-2 px-3">
							<h3 class="card-title text-light h5">
								<i class="tio-new-message"></i> Icon Reaction
							</h3>
						</div>
						@include("$view.form")
					</div>
				{!! Form::close() !!}
			@else
				{!! Form::open(['route' => "$prefix.store", 'files' => true]) !!}
					<div class="card rounded-0 border-0 shadow-none mb-0">
						<div class="card-header rounded-0 bg-dark py-2 px-3">
							<h3 class="card-title text-light h5">
								<i class="tio-add-square-outlined"></i> Icon Reaction
							</h3>
						</div>
						@include("$view.form")
					</div>
				{!! Form::close() !!}
			@endisset
		</div>
    </div>

@endsection