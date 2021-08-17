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
        	function toggle_table_actions() {
	            var selected_count = $(".table").find('td :checked').length;
	            if (selected_count > 0) {
	                $(".table-actions-menu").show();
	            } else {
	                $(".table-actions-menu").hide();
	            }
	        }

	        function do_post_action(data_url){
	            $(".overlay").removeClass('hide');
	            $.ajax({
	                type: "GET",
	                dataType: 'json',
	                url: data_url,
	                success: function(data) {
	                    setTimeout(function() {
	                        table.api().ajax.reload();
	                    }, 500);
	                    setTimeout(function() {
	                        $(".cho input[type='checkbox']").iCheck("uncheck");
	                        $(".cho .fa").removeClass("fa-check-square-o").addClass('fa-square-o');
	                        $(".table-actions-menu").removeClass('loading');
	                        $(".overlay").addClass('hide');
	                        toggle_table_actions();
	                    }, 1000);
	                },
	                error: function(data) {
	                    swal({
	                        type: "warning",
	                        title: data.statusText,
	                        text: data.responseJSON.errors,
	                        timer: 2000,
	                        showConfirmButton: false
	                    });
	                    $(".overlay").addClass('hide');
	                },
	            });
	        }

	        $('.do-action').on('click', function() {
	            var data_url = $(this).attr('data-url');

	            var ids = '';
	            $(".table").find('td :checked').each(function() {
	                ids += $(this).val() + ',';
	            });

	            if (ids === '') {
	                return;
	            }
	            do_post_action(data_url+ "&ids=" + ids.slice(0, -1))
	        });

            var table = $('#datatable').DataTable({ 
                order: [[4, 'desc']],
                processing: true,
                serverSide: true,
                scrollY: 'calc(100vh - 333px)',
                autoWidth: false,
                language: {
                	sLengthMenu: "_MENU_ entries",
                    sSearch: "Cari:"
	            },
                ajax: {
                    "url": '{!! route("$prefix.index") !!}?datatable=true&type=all&only={{ request()->query('only') }}'
                },
                columns: [
                	{ sType: 'html', data: 'selection', name: 'selection', orderable: false, searchable: false },
	                { sType: 'html', data: 'title', name: 'title', orderable: false, searchable: true },
                    @if($type == 'featured')
                    	{ data: 'featured_at', name: 'featured_at', className: 'align-text-top text-right', orderable: true, searchable: false },
                    @elseif($type == 'unapproved')
                    	{ data: 'created_at', name: 'created_at', className: 'align-text-top text-right', orderable: true, searchable: false },
                    @else
						{ data: 'published_at', name: 'published_at', className: 'align-text-top text-right', orderable: true, searchable: false },
	                @endif
	                { data: 'user', name: 'user', className: 'align-text-top text-center', orderable: false, searchable: false },
	                { data: 'aksi', name: 'aksi', className: 'align-text-top', orderable: false, searchable: false }
	            ],
	            drawCallback: function(settings) {
                    $('[data-toggle="tooltip"]').tooltip();
	                $('.table input[type="checkbox"]').iCheck({
	                    checkboxClass: 'icheckbox_flat-blue',
	                    radioClass: 'iradio_flat-blue'
	                }).on('ifChecked', function(event) {
	                    toggle_table_actions();
	                }).on('ifUnchecked', function(event) {
	                    toggle_table_actions();
	                });
	                $('.cho input[type="checkbox"]').iCheck({
	                    checkboxClass: 'icheckbox_flat-blue',
	                    radioClass: 'iradio_flat-blue'
	                }).on('ifChecked', function(event) {
	                    toggle_table_actions();
	                    $(".table input[type='checkbox']").iCheck("check");
	                    $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
	                }).on('ifUnchecked', function(event) {
	                    toggle_table_actions();
	                    $(".table input[type='checkbox']").iCheck("uncheck");
	                    $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
	                });
	                $('.do_post_action').on('click', function() {
	                    var data_url = $(this).attr('data-url');

	                    do_post_action(data_url);
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
									<button type="button" class="btn btn-sm btn-success do-action" data-url="=restore">
										<i class="tio-recycling"></i> Retrieve from Trash
									</button>
									<button type="button" class="btn btn-sm btn-white dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										<i class="tio-more-horizontal"></i>
									</button>
									<ul class="dropdown-menu rounded-sm">
										<li>
											<a href="javascript:;" class="dropdown-item do-action text-danger" data-url="action=remove">
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
									<button type="button" class="btn btn-sm btn-danger do-action" data-url="?action=remove">
										<i class="tio-delete"></i> 
										Send to Trash 
									</button>
									<button type="button" class="btn btn-sm btn-white dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										<i class="tio-more-horizontal"></i>
									</button>
									<ul class="dropdown-menu rounded-sm">
										<li>
											<a href="javascript:;" class="dropdown-item pl-3 do-action" data-url="post-approve?action=yes">
												<i class="tio-checkmark-square mr-1 text-success"></i> Approve
											</a>
										</li>
										<li>
											<a href="javascript:;" class="dropdown-item pl-3 do-action" data-url="post-approve?action=no" data-type="do" data-action="UndoApprove">
												<i class="tio-checkmark-square mr-1"></i> Undo Approve
											</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:;" class="dropdown-item pl-3 do-action" data-url="post-set-featured?action=yes" data-type="do" data-action="PickforFeatured">
												<i class="tio-star text-warning mr-1"></i> Pick for Featured
											</a>
										</li>
										<li>
											<a href="javascript:;" class="dropdown-item pl-3 do-action" data-url="post-set-featured?action=no" data-type="do" data-action="UndoFeatured">
												<i class="tio-star mr-1"></i> Undo Featured
											</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:;" class="dropdown-item pl-3 do-action" data-url="post-set-for-homepage?action=yes" data-type="do" data-action="PickforHomepage">
												<i class="tio-clock mr-1 text-danger"></i> Pick for Homepage
											</a>
										</li>
										<li>
											<a href="javascript:;" class="dropdown-item pl-3 do-action" data-url="post-set-for-homepage?action=no" data-type="do" data-action="UndofromHomepage">
												<i class="tio-clock mr-1"></i> Undo from Homepage
											</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:;" class="dropdown-item pl-3 do-action" data-url="https://buzzy.akbilisim.com/admin/post-delete-perma?action=remove" data-type="deleteperma" data-action="deleteperma">
												<i class="tio-delete text-danger mr-1"></i> Hapus Permanen
											</a>
										</li>
									</ul>
								</div>
							</div>
	                    @endif

						<div class="table-responsive">
							<table id="datatable" class="table table-thead-bordered table-hover table-align-middle">
								<thead class="thead-light">
									<tr>
										<th>
											<div class="cho">
												<input type="checkbox" class="checkbox-toggle">
											</div>
										</th>
										<th>JUDUL</th>
		                                @if($type == 'featured')
		                                	<th width="12%">FEATURED DATE</th>
		                                @elseif($type == 'unapproved')
		                                	<th width="12%">CREATED DATE</th>
		                                @else
		                                	<th width="12%">PUBLISH DATE</th>
		                                @endif
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