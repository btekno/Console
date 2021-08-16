@extends('console::today.theme')
@section('title', "$title - ")

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
	                url: data_url , // This is the URL to the API
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
	        $('.doaction').on('click', function() {
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
                order: [[5, 'desc']],
                processing: true,
                serverSide: true,
                scrollY: 'calc(100vh - 333px)',
                autoWidth: false,
                language: {
                	sLengthMenu: "_MENU_ entries",
                    sSearch: "Cari:", 
	                "sDecimal": ",",
	                "infoEmpty": "No data available in table",
	                "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
	                "sInfoEmpty": "Showing 0 to 0 of 0 entries",
	                "sInfoFiltered": "(filtered from _MAX_ total entries)",
	                "sInfoPostFix": "",
	                "sInfoThousands": ".",
	                "sLoadingRecords": "Loading...",
	                "sProcessing": "Processing...",
	                "sZeroRecords": "No matching records found",
	                "oPaginate": {
	                    "sFirst": "First",
	                    "sLast": "Last",
	                    "sNext": "Next",
	                    "sPrevious": "Previous"
	                },
	                "oAria": {
	                    "sSortAscending": ": activate to sort column ascending",
	                    "sSortDescending": ": activate to sort column descending"
	                }
	            },
                ajax: {
                    "url": '{!! route("$prefix.index") !!}?datatable=true&type=all&only={{ request()->query('only') }}'
                },
                columns: [{
	                    sType: 'html',
	                    data: 'selection',
	                    name: 'selection',
	                    orderable: false,
	                    searchable: false,
	                    "width": "2%"
	                },
	                {
	                    sType: 'html',
	                    data: 'thumb',
	                    name: 'thumb',
	                    orderable: false,
	                    searchable: false,
	                    "width": "2%"
	                },
	                {
	                    sType: 'html',
	                    data: 'title',
	                    name: 'title',
	                    orderable: false,
	                    searchable: true,
	                    "width": "33%"
	                },
	                {
	                    data: 'user',
	                    name: 'user',
	                    orderable: false,
	                    searchable: false,
	                    "width": "15%"
	                },
	                {
	                    data: 'approve',
	                    name: 'approve',
	                    orderable: false,
	                    searchable: false,
	                    "width": "13%"
	                },
                    @if($type == 'featured')
                    {
	                    data: 'featured_at',
	                    name: 'featured_at',
	                    orderable: true,
	                    searchable: false,
	                    "width": "10%"
	                },
                    @else
					{
	                    data: 'published_at',
	                    name: 'published_at',
	                    orderable: true,
	                    searchable: false,
	                    "width": "10%"
	                },
	                @endif
	                 {
	                    data: 'action',
	                    name: 'action',
	                    orderable: false,
	                    searchable: false,
	                    "width": "10%"
	                }
	            ],
	            drawCallback: function(settings) {
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
        'hapus' => true, 
        'breadcrumbs' => [
            route('console::today.index') => 'Today'
        ]
    ])

    <div class="row no-gutters">
    	<div class="col-md-12">
    		<div class="card border-0 shadow-none rounded-0">
				<div class="card-body p-0">
					{!! Form::open(['method' => 'DELETE', 'route' => ["$prefix.destroy", 'hapus-all'], 'id' => 'submit-all']) !!}

						@if($type == 'trashed')
						<div class="table-actions-menu">
                        <div class="btn-group">
                                                        <button type="button" class="btn btn-success dropdown-toggle doaction"
                                data-url="https://buzzy.akbilisim.com/admin/post-send-to-trash?action=restore"
                                data-type="move" data-toggle="dropdown" aria-expanded="true"><span class="fa fa-recycle"
                                    style="margin-right:5px"></span> Retrieve from Trash </button>
                                                    </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="true">Actions <span class="fa fa-caret-down"
                                    style="margin-left:5px"></span></button>
                            <ul class="dropdown-menu pull-left"
                                style="left:0px;  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);">
                                                                <li><a href="javascript:;" class="doaction"
                                        data-url="https://buzzy.akbilisim.com/admin/post-delete-perma?action=remove"
                                        data-type="deleteperma" data-action="deleteperma"><i class="fa fa-remove"></i>
                                        Delete permanently</a></li>
                            </ul>
                        </div>
                    </div>
                    @else
						<div class="table-actions-menu">
	                        <div class="btn-group">
	                                                        <button type="button" class="btn btn-danger dropdown-toggle doaction"
	                                data-url="https://buzzy.akbilisim.com/admin/post-send-to-trash?action=remove"
	                                data-type="move" data-toggle="dropdown" aria-expanded="true"><span class="fa fa-trash"
	                                    style="margin-right:5px"></span> Send to Trash </button>
	                                                    </div>
	                        <div class="btn-group">
	                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
	                                aria-expanded="true">Actions <span class="fa fa-caret-down"
	                                    style="margin-left:5px"></span></button>
	                            <ul class="dropdown-menu pull-left"
	                                style="left:0px;  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);">
	                                                                <li><a href="javascript:;" class="doaction"
	                                        data-url="https://buzzy.akbilisim.com/admin/post-approve?action=yes"
	                                        data-type="do" data-action="Approve"><i class="fa fa-check text-green"></i>
	                                        Approve</a></li>
	                                <li><a href="javascript:;" class="doaction"
	                                        data-url="https://buzzy.akbilisim.com/admin/post-approve?action=no"
	                                        data-type="do" data-action="UndoApprove"><i class="fa fa-check"></i>
	                                        Undo Approve</a></li>
	                                <li class="divider"></li>
	                                <li><a href="javascript:;" class="doaction"
	                                        data-url="https://buzzy.akbilisim.com/admin/post-set-featured?action=yes"
	                                        data-type="do" data-action="PickforFeatured"><i
	                                            class="fa fa-star text-yellow"></i> Pick for Featured</a>
	                                </li>
	                                <li><a href="javascript:;" class="doaction"
	                                        data-url="https://buzzy.akbilisim.com/admin/post-set-featured?action=no"
	                                        data-type="do" data-action="UndoFeatured"><i class="fa fa-star"></i>
	                                        Undo Featured</a></li>
	                                <li class="divider"></li>
	                                <li><a href="javascript:;" class="doaction"
	                                        data-url="https://buzzy.akbilisim.com/admin/post-set-for-homepage?action=yes"
	                                        data-type="do" data-action="PickforHomepage"><i
	                                            class="fa fa-dashboard text-red"></i>
	                                        Pick for Homepage</a></li>
	                                <li><a href="javascript:;" class="doaction"
	                                        data-url="https://buzzy.akbilisim.com/admin/post-set-for-homepage?action=no"
	                                        data-type="do" data-action="UndofromHomepage"><i class="fa fa-dashboard"></i>
	                                        UndofromHomepage</a></li>
	                                <li class="divider"></li>
	                                                                <li><a href="javascript:;" class="doaction"
	                                        data-url="https://buzzy.akbilisim.com/admin/post-delete-perma?action=remove"
	                                        data-type="deleteperma" data-action="deleteperma"><i class="fa fa-remove"></i>
	                                        Delete permanently</a></li>
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
										<th>Preview</th>
		                                <th>Title</th>
		                                <th>User</th>
		                                <th>Status</th>
		                                @if($type=='featured')
		                                <th>Featured Date</th>
		                                @else
		                                <th>Dates</th>
		                                @endif
		                                <th>Actions</th>
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