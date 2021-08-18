@extends('console::today.theme')
@section('inner-title', "$title - ")

@section('inner-css')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
	<link rel="stylesheet" href="{{ asset('assets/console/css/menu.css') }}">

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
	<style>
		.material-icons {
			padding-top: 10px;
    		line-height: 0px;
    		margin-right: 5px;
    		font-size: 15px;
		}
	</style>	
@endsection

@section('inner-js')
	<script src="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
	<script>
        $(function() {
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this), {
                	"minimumResultsForSearch": "Infinity"
                });
            });

            @if(request()->filled('location'))
	            $("#nestmenu").nestable({
					group: 1,
					maxDepth: {{ menu_settings($menu->id)['depth'] }},
					callback: function(l,e){
						var list   = l.length ? l : $(l.target);
						var menu = list.nestable('toArray');
						$.ajax({
							url: '{{ route("$prefix.update", $menu->id) }}',
							method: 'PUT',
							responseType: 'json',
							data: {
								'menu': menu,
								'purpose': 'sort',
								'_token': "{{ csrf_token() }}"
							},
							success: function(res){
								if (res.success == true) {
									$('#toast').toast('show');
								}
							}
						});
					}
				});
			@endif
        });
    </script>
    
	@include('console::layouts.components.scripts.swal', [
		'redirect' => route("$prefix.index", 'location=' . request('location'))
	])
@endsection

@push('push-menu')
    {!! Form::open(['method' => 'GET']) !!}
        <div class="mr-2">
            <select class="js-select2-custom custom-select" size="1" style="opacity: 0;" name="location" 
                onchange="this.form.submit()" 
                data-hs-select2-options='{
                  "minimumResultsForSearch": "Infinity", 
                  "width": "200px"
                }'>
                <option value="">Pilih Menu</option>
                @foreach(Modules\Today\Entities\Menu\Menu::get() as $i => $temp)
                    <option value="{{ $temp->location }}"
                        @if(request()->filled('location'))
                            {{ request('location') == $temp->location ? 'selected' : '' }}
                        @endif
                    >{{ $temp->name }}</option>
                @endforeach
            </select>
        </div>
    {!! Form::close() !!}
@endpush

@section('inner-content')

    @if(request()->filled('location'))

    	@include('console::layouts.components.breadcrumb', [
			'title' => $menu->name, 
			'breadcrumbs' => [
				route('console::today.index') => 'Today', 
				'#referensi' => 'Referensi', 
				route("$prefix.index") => $title, 
			]
		])

		<div class="row no-gutters">
			<div class="col-md-4">
				@include("$view.form")
			</div>
			<div class="col-md-8">
				<div class="dd p-3" id="nestmenu">
					@include("$view.draggable", [
						'lists' => $menu->items()->whereNull('parent_id')->orderBy('order')->get()
					])
				</div>
			</div>
		</div>

    @else

		@include('console::layouts.components.breadcrumb', [
			'title' => $title, 
			'breadcrumbs' => [
				route('console::today.index') => 'Today', 
				'#referensi' => 'Referensi', 
			]
		])

    	<div class="row justify-content-sm-center text-center py-10 pb-0 min-height-200px">
			<div class="col-sm-7 col-md-5">
				<img class="img-fluid mb-5" src="https://cdn.btekno.id/templates/console/svg/illustrations/graphs.svg" alt="" style="max-width: 15rem;">
				<h1>Lokasi Menu Belum Dipilih</h1>
				<p>Silahkan pilih salah satu lokasi menu yang ingin diperbarui.</p>
			</div>
		</div>

    @endif

    <div id="toast" class="toast" data-delay="5000" data-animation=true role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
		<div class="toast-header bg-success text-light p-2">
			<i class="tio-checkmark-square mr-2"></i>
			<strong class="mr-auto">Berhasil</strong>
			<small>Baru saja</small>
			<button type="button" class="ml-2 mb-1 text-light close" data-dismiss="toast" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="toast-body">
			Urutan menu berhasil diperbarui.
		</div>
	</div>
@endsection