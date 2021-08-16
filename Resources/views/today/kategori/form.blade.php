<div class="card-body bg-light p-0" style="min-height: calc(100vh - 266px);">

	<div class="p-3">
		<div class="form-group mb-3">
	        <div class="form-row">
	            <div class="col-sm mb-2 mb-sm-0">
	                <div class="form-control">
	                    <div class="custom-control custom-radio">
	                        {{ Form::radio('jenis', 'Kategori Utama', null, ['class' => 'custom-control-input', 'id' => 'kategori-1', 'data-target' => '#tab-kategori-utama']) }}
	                        <label class="custom-control-label" for="kategori-1">Kategori Utama</label>
	                    </div>
	                </div>
	            </div>
	            <div class="col-sm mb-2 mb-sm-0">
	                <div class="form-control">
	                    <div class="custom-control custom-radio">
	                        {{ Form::radio('jenis', 'Sub Kategori', null, ['class' => 'custom-control-input', 'id' => 'kategori-2', 'data-target' => '#tab-kategori-sub']) }}
	                        <label class="custom-control-label" for="kategori-2">Sub Kategori</label>
	                    </div>
	                </div>
	            </div>
	        </div>
	        {!! $errors->first('jenis', '<small class="text-danger d-block mt-1">:message</small>') !!}
	    </div>

		<div class="tab-content">

			<div id="tab-kategori-utama" class="tab-pane {{ old('jenis') == 'Kategori Utama' ? 'active' : '' }}">
                <div class="form-group mb-3">
					<label for="jenis" class="mb-1 ml-1 text-muted text-cap text-bold small">
						Jenis Postingan <span class="text-danger">*</span>
					</label>
					{!! Form::select('jenis', list_postingan(), null, ['class' => 'form-control js-select2-custom']) !!}
					{!! $errors->first('jenis', '<small class="text-danger">:message</small>') !!}
				</div>
            </div>

            <div id="tab-kategori-sub" class="tab-pane {{ old('jenis') == 'Sub Kategori' ? 'active' : '' }}">
                <div class="form-group mb-3">
					<label for="induk_id" class="mb-1 ml-1 text-muted text-cap text-bold small">
						Kategori Induk <span class="text-danger">*</span>
					</label>
					{!! Form::text('induk_id', null, ['class' => 'form-control']) !!}
					{!! $errors->first('induk_id', '<small class="text-danger">:message</small>') !!}
				</div>
            </div>

			<div class="form-group mb-3">
				<label for="nama" class="mb-1 ml-1 text-muted text-cap text-bold small">
					Nama Kategori <span class="text-danger">*</span>
				</label>
				{!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'eg. Kalimantan Timur']) !!}
				{!! $errors->first('nama', '<small class="text-danger">:message</small>') !!}
			</div>
			<div class="form-group mb-3">
				<label for="slug" class="mb-1 ml-1 text-muted text-cap text-bold small">
					Slug (URL) <span class="text-danger">*</span>
				</label>
				{!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'eg. kalimantan-timur']) !!}
				<span class="text-muted pl-1 small">https://today.btekno.id/<code>slug-kategori</code>/judul-postingan</span>
				{!! $errors->first('slug', '<small class="text-danger">:message</small>') !!}
			</div>
			<div class="form-group mb-3">
				<label for="keterangan" class="mb-1 ml-1 text-muted text-cap text-bold small">
					Keterangan (Opsional)
				</label>
				{!! Form::textarea('keterangan', null, ['class' => 'form-control', 'rows' => 2]) !!}
			</div>
		</div>
	</div>
</div>

<div class="card-footer p-1 bg-light">
	<div class="d-flex justify-content-end pr-1">
		<button type="submit" class="btn btn-sm btn-primary">
			<i class="tio-save"></i>
			Simpan
		</button>
	</div>
</div>