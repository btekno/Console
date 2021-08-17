@extends('console::today.theme')
@section('title', "$title")

@section('inner-css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdn.btekno.id/templates/console/css/datatable.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.3/skins/flat/blue.min.css">
	<style>
		.table tbody td {
			position: relative
		}
	</style>
@endsection

@section('inner-js')
	@php($only = (request()->query('only') ? '&only=' . request()->query('only') : ''))
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.3/icheck.min.js"></script>
	<script>
		$(function() {
			// Toggle Menu Bulk Manipulation
			function toggle_bulk() {
				var selected_count = $(".table").find('td :checked').length;
				if (selected_count > 0) {
					$(".table-actions-menu").show();
				} else {
					$(".table-actions-menu").hide();
				}
			}

			// Untuk Bulk Manipulation
			$('.do-action').on('click', function() {
				var url = $(this).attr('data-url');
				var ids = '';

				$(".table").find('td :checked').each(function() {
					ids += $(this).val() + ',';
				});

				if (ids === '') {
					return;
				}

				bulk_action(url, ids.slice(0, -1))
			});

			// Ajax untuk Bulk
			function bulk_action(url, ids) {
				$(".overlay").removeClass('hide');
				$.ajax({
					type: 'PUT',
					dataType: 'JSON',
					url: url,
					data: {
						_token: '{{ csrf_token() }}',
						ids: ids, 
						purpose: 'bulk'
					}, 
					success: function(response) {
						if(response.success == true) {
							swal({
								type: "success",
								title: 'Berhasil!',
								text: response.message,
								timer: 2000,
								showConfirmButton: false
							});

							$('.table-actions-menu').css('display','none');
							setTimeout(function() {
								$(".pilihan input[type='checkbox']").iCheck("uncheck");
								$(".overlay").addClass('hide');
								table.ajax.reload();
							}, 500);
						}
					},
					error: function(response) {
						swal({
							type: "warning",
							title: response.statusText,
							text: response.responseJSON.errors,
							timer: 2000,
							showConfirmButton: false
						});
						$(".overlay").addClass('hide');
					},
				});
			}

			// Datatable Init
			var table = $('#datatable').DataTable({ 
				order: [[3, 'desc']],
				processing: true,
				serverSide: true,
				scrollY: 'calc(100vh - 333px)',
				autoWidth: false,
				language: {
					sLengthMenu: "_MENU_ entries",
					sSearch: "Cari:"
				},
				ajax: {
					"url": '{!! route("$prefix.index") !!}?datatable=true&only={{ $type }}'
				},
				columns: [
					{ sType: 'html', data: 'selection', name: 'selection', orderable: false, searchable: false },
					{ sType: 'html', data: 'title', name: 'title', orderable: false, searchable: true },
					@if($type == 'featured')
						{ data: 'featured_at', name: 'featured_at', className: 'align-text-top text-right', orderable: true, searchable: false },
					@elseif($type == 'unapproved')
					@elseif($type == 'trashed')
						{ data: 'deleted_at', name: 'deleted_at', className: 'align-text-top text-right', orderable: true, searchable: false },
					@else
						{ data: 'published_at', name: 'published_at', className: 'align-text-top text-right', orderable: true, searchable: false },
					@endif
					{ data: 'created_at', name: 'created_at', className: 'align-text-top text-right', orderable: true, searchable: false },
					{ data: 'user', name: 'user', className: 'align-text-top text-center', orderable: false, searchable: false },
					{ data: 'aksi', name: 'aksi', className: 'align-text-top', orderable: false, searchable: false }
				],
				drawCallback: function(settings) {
					$('[data-toggle="tooltip"]').tooltip();

					$('.table input[type="checkbox"]').iCheck({
						checkboxClass: 'icheckbox_flat-blue',
						radioClass: 'iradio_flat-blue'
					}).on('ifChecked', function(event) {
						toggle_bulk();
					}).on('ifUnchecked', function(event) {
						toggle_bulk();
					});

					$('.pilihan input[type="checkbox"]').iCheck({
						checkboxClass: 'icheckbox_flat-blue',
						radioClass: 'iradio_flat-blue'
					}).on('ifChecked', function(event) {
						toggle_bulk();
						$(".table input[type='checkbox']").iCheck("check");
					}).on('ifUnchecked', function(event) {
						toggle_bulk();
						$(".table input[type='checkbox']").iCheck("uncheck");
					});
				}
			});
		});
	</script>
@endsection

@section('inner-content')
	
	@include('console::layouts.components.breadcrumb', [
        'title' => $title, 
        'breadcrumbs' => [
            route('console::today.index') => 'Today', 
            '#posts' => 'Posts'
        ]
    ])

    <div class="row no-gutters">
    	<div class="col-md-12">
    		<div class="card border-0 shadow-none rounded-0">
				<div class="card-body p-0">
					{!! Form::open(['method' => 'DELETE', 'route' => ["$prefix.destroy", 'hapus-all'], 'id' => 'submit-all']) !!}

						{{-- Untuk Recycle Bin --}}
						@if($type == 'trashed')
							<div class="table-actions-menu">
								<div class="btn-group">
									<button type="button" class="btn btn-sm btn-success do-action" data-url="{{ route("$prefix.update", 'restore') }}">
										<i class="tio-recycling"></i> Retrieve from Trash
									</button>
									<button type="button" class="btn btn-sm btn-white dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										<i class="tio-more-horizontal"></i>
									</button>
									<ul class="dropdown-menu rounded-sm">
										<li>
											<a href="javascript:;" class="dropdown-item do-action text-danger" data-url="{{ route("$prefix.update", 'delete-permanent') }}">
												<i class="tio-delete-outlined"></i>
												Hapus Permanen
											</a>
										</li>
									</ul>
								</div>
							</div>
						
						{{-- Otherwise --}}
						@else
							<div class="table-actions-menu">
								<div class="btn-group">
									<button type="button" class="btn btn-sm btn-danger do-action" data-url="{{ route("$prefix.update", 'delete') }}">
										<i class="tio-delete"></i> 
										Send to Trash 
									</button>
									<button type="button" class="btn btn-sm btn-white dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										<i class="tio-more-horizontal"></i>
									</button>
									<ul class="dropdown-menu rounded-sm">
										<li>
											<a href="javascript:;" class="dropdown-item pl-3 do-action" data-url="{{ route("$prefix.update", 'approve') }}">
												<i class="tio-checkmark-square mr-1 text-success"></i> Approve
											</a>
										</li>
										<li>
											<a href="javascript:;" class="dropdown-item pl-3 do-action" data-url="{{ route("$prefix.update", 'unapprove') }}">
												<i class="tio-checkmark-square mr-1"></i> Undo Approve
											</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:;" class="dropdown-item pl-3 do-action" data-url="{{ route("$prefix.update", 'featured') }}">
												<i class="tio-star text-warning mr-1"></i> Pick for Featured
											</a>
										</li>
										<li>
											<a href="javascript:;" class="dropdown-item pl-3 do-action" data-url="{{ route("$prefix.update", 'unfeatured') }}">
												<i class="tio-star mr-1"></i> Undo Featured
											</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:;" class="dropdown-item pl-3 do-action" data-url="{{ route("$prefix.update", 'homepage') }}">
												<i class="tio-clock mr-1 text-danger"></i> Pick for Homepage
											</a>
										</li>
										<li>
											<a href="javascript:;" class="dropdown-item pl-3 do-action" data-url="{{ route("$prefix.update", 'unhomepage') }}">
												<i class="tio-clock mr-1"></i> Undo from Homepage
											</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:;" class="dropdown-item pl-3 do-action" data-url="{{ route("$prefix.update", 'delete-permanent') }}">
												<i class="tio-delete text-danger mr-1"></i> Hapus Permanen
											</a>
										</li>
									</ul>
								</div>
							</div>
	                    @endif

						<div class="overlay hide">
							<div class="d-flex justify-content-center align-items-center h-100">
								<div class="spinner-grow" role="status">
									<span class="sr-only">Loading...</span>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table id="datatable" class="table table-thead-bordered table-hover table-align-middle">
								<thead class="thead-light">
									<tr>
										<th>
											<div class="pilihan">
												<input type="checkbox" class="checkbox-toggle">
											</div>
										</th>
										<th>JUDUL</th>
		                                @if($type == 'featured')
		                                	<th width="12%">FEATURED DATE</th>
                    					@elseif($type == 'unapproved')
		                                @elseif($type == 'trashed')
		                                	<th width="12%">DELETED DATE</th>
		                                @else
		                                	<th width="12%">PUBLISH DATE</th>
		                                @endif
		                                <th width="12%">CREATED DATE</th>
		                                <th width="1">UPLOADER</th>
		                                <th width="1"></th>
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