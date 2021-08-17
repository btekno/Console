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
                ajax : '{!! request()->fullUrl() !!}{!! request()->filled('filter') ? '&' : '?' !!}datatable=true', 
                columns: [
                    { data: 'pilihan', name: 'pilihan', className: 'table-column-pr-0', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'created_at', name: 'created_at', className: 'text-right' },
                    { data: 'aksi', name: 'aksi', className: 'text-right', orderable: false, searchable: false }
                ],
                oLanguage: {
                    sLengthMenu: "_MENU_ entries",
                    sSearch: "Cari:"
                }, 
                fnDrawCallback: function( oSettings ) {
                    @include('console::layouts.components.scripts.callback')
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this), {
                    "minimumResultsForSearch": "Infinity"
                });
            });
        });
    </script>
@endsection

@push('push-menu')
    {!! Form::open(['method' => 'GET']) !!}
        <div class="mr-2">
            <select class="js-select2-custom custom-select" size="1" style="opacity: 0;" name="filter" 
                onchange="this.form.submit()" 
                data-hs-select2-options='{
                  "minimumResultsForSearch": "Infinity", 
                  "width": "200px"
                }'>
                <option value="all">- Semua User -</option>
                <option value="admin" {{ request()->filled('filter') && request()->filter == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="staff" {{ request()->filled('filter') && request()->filter == 'staff' ? 'selected' : '' }}>Staff / Editor</option>
                <option value="banned" {{ request()->filled('filter') && request()->filter == 'banned' ? 'selected' : '' }}>Banned</option>
                <option value="member" {{ request()->filled('filter') && request()->filter == 'member' ? 'selected' : '' }}>Member</option>
            </select>
        </div>
    {!! Form::close() !!}
@endpush

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
                                        <th>USER</th>
                                        <th width="15%">STATUS</th>
                                        <th width="15%">JOINED AT</th>
										<th width="15%"></th>
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