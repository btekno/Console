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
                scrollY: 'calc(100vh - 335px)',
                ajax : '{!! request()->fullUrl() !!}?datatable=true', 
                columns: [
                    { data: 'pilihan', name: 'pilihan', className: 'table-column-pr-0', orderable: false, searchable: false },
                    { data: 'title', name: 'title', orderable: false, searchable: false },
                    { data: 'footer', name: 'footer', className: 'text-center', orderable: false, searchable: false },
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
        });
    </script>
@endsection

@section('inner-content')
	
	@include('console::layouts.components.breadcrumb', [
        'title' => $title, 
        'tambah' => route("$prefix.create"), 
        'hapus' => true, 
        'breadcrumbs' => [
            route('console::today.index') => 'Today', 
            '#referensi' => 'Referensi', 
        ]
    ])

    <div class="row no-gutters">
    	<div class="col-md-12">
    		<div class="card border-0 shadow-none rounded-0">
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
										<th>TITLE</th>
										<th width="1">FOOTER</th>
										<th width="10%"></th>
									</tr>
								</thead>
							</table>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
    	</div>
    </div>

@endsection