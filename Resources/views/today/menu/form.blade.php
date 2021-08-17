<div class="card rounded-0 border-0 shadow-none mb-0 p-3">
	<div class="card-header rounded-0 bg-dark py-2 px-3">
		<h3 class="card-title text-light h5">
			<i class="tio-new-message"></i> {{ $menu->name }}
		</h3>
	</div>
	@isset($menu_item->id)
		{!! Form::model($menu_item, ['route' => ["$prefix.update", $menu_item->id], 'method' => 'PUT']) !!}
		{!! Form::hidden('location', request('location')) !!}
	@else
		{!!  Form::open(['route' => "$prefix.store"]) !!}
	@endisset
		<div class="card-body bg-light p-0">
			<input type="hidden" name="menu_id" value="{{ $menu->id }}">
			<input type="hidden" name="id" value="{{ isset($menu_item->id) ? $menu_item->id : null }}">
			<div class="p-3">
				<div class="form-group mb-3">
					<label for="title" class="mb-1 ml-1 text-muted text-cap text-bold small">
						Label <span class="text-danger">*</span>
					</label>
					{!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'eg. Contact']) !!}
					{!! $errors->first('title', '<small class="text-danger">:message</small>') !!}
				</div>
				<div class="row no-gutters">
					<div class="col-md-7">
						<div class="form-group mb-3">
							<label for="url" class="mb-1 ml-1 text-muted text-cap text-bold small">
								URL <span class="text-danger">*</span>
							</label>
							{!! Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'eg. /contact']) !!}
							{!! $errors->first('url', '<small class="text-danger">:message</small>') !!}
						</div>
					</div>
					<div class="col-md-5 pl-2">
						<div class="form-group mb-3">
							<label for="target" class="mb-1 ml-1 text-muted text-cap text-bold small">
								Open In <span class="text-danger">*</span>
							</label>
							{!! Form::select('target', ['_self'=> 'Same Tab', '_blank' => 'New Tab'], null, ['class' => 'form-control js-select2-custom'])  !!}
							{!! $errors->first('target', '<small class="text-danger">:message</small>') !!}
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-md-6 pr-1">
						<div class="form-group mb-3">
							<label for="icon" class="mb-1 ml-1 text-muted text-cap text-bold small">
								Menu Icon
							</label>
							{!! Form::text('icon', null, ['class' => 'form-control', 'placeholder' => 'eg. library_books']) !!}
							<span class="text-muted small">Temukan kode icon <a href="https://material.io/icons/" target="_blank">disini</a>.</span>
							{!! $errors->first('icon', '<small class="text-danger">:message</small>') !!}
						</div>
					</div>
					<div class="col-md-6 pl-1">
						<div class="form-group mb-3">
							<label for="custom_class" class="mb-1 ml-1 text-muted text-cap text-bold small">
								Custom Class
							</label>
							{!! Form::text('custom_class', null, ['class' => 'form-control', 'placeholder' => 'eg. text-danger']) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer p-3 bg-light">
			<div class="d-flex justify-content-between">
				@if(isset($menu_item->id))
                    <a href="{{ route("$prefix.index") }}?location={{ request('location') }}" class="btn btn-sm btn-secondary pull-right">
                    	Batal
                    </a>
                @else
                	<div></div>
                @endif
				<button type="submit" class="btn btn-sm btn-primary">Tambah</button>
			</div>
		</div>
    {!! Form::close() !!}

    @if(!isset($menu_item))
		{{-- <div class="card-header rounded-0 bg-dark py-2 px-3">
			<h3 class="card-title text-light h5">
				<i class="tio-add-square-outlined"></i> Ambil dari Kategori
			</h3>
		</div>
		<div class="card-body bg-light p-0">
			<div class="p-3">
				<div class="form-group mb-3">
					<label for="name" class="mb-1 ml-1 text-muted text-cap text-bold small">
						Label <span class="text-danger">*</span>
					</label>
					{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'eg. Awesome']) !!}
					{!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
				</div>
			</div>
		</div>
		<div class="card-footer p-2 bg-light">
			<div class="d-flex justify-content-end">
				<button type="submit" class="btn btn-sm btn-primary">Tambah</button>
			</div>
		</div> --}}
	@endif
</div>