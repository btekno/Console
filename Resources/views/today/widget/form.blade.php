<div class="card-body bg-light scrollbar p-0" style="height: calc(100vh - 275px);">
	<div class="p-3">
		<div class="form-group mb-3 mt-3">
			<label for="name" class="mb-1 ml-1 text-muted text-cap text-bold small">
				Nama Widget <span class="text-danger">*</span>
			</label>
			{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nama Widget (Iklan)']) !!}
			{!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
		</div>

		<div class="form-group mb-3">
			<label for="html" class="mb-1 ml-1 text-muted text-cap text-bold small">
				Paste HTML / Adsense Code / Social Media Embeds Here <span class="text-danger">*</span>
			</label>
			{!! Form::textarea('html', null, ['class' => 'form-control', 'placeholder' => 'Tempel disini ...', 'rows' => 4]) !!}
			{!! $errors->first('html', '<small class="text-danger">:message</small>') !!}
		</div>

		<div class="form-group mb-3 mt-3">
			<label for="position" class="mb-1 ml-1 text-muted text-cap text-bold small">
				Letak Widget
			</label>
			{!! Form::select('position', lokasi_widget(), request()->filled('position') ? request('position') : null, ['class' => 'form-control js-select2-custom']) !!}
			<span class="text-muted small pl-1">For AMP ad codes follow here: <a target="_blank" href="https://amp.dev/documentation/guides-and-tutorials/develop/monetization/#step-2:-add-the-amp-ad-tag-to-your-amp-page">https://amp.dev/...#amp-page</a></span>
		</div>

		<div class="row mb-3 mt-3">
			<div class="col-md-6">
				<div class="form-group">
					<label for="show_web" class="mb-1 ml-1 text-muted text-cap text-bold small">
						Tampil di Web
					</label>
					{!! Form::select('show_web', [1 => 'Ya', 0 => 'Tidak'], null, ['class' => 'form-control js-select2-custom']) !!}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="show_mobile" class="mb-1 ml-1 text-muted text-cap text-bold small">
						Tampil di Mobile
					</label>
					{!! Form::select('show_mobile', [1 => 'Ya', 0 => 'Tidak'], null, ['class' => 'form-control js-select2-custom']) !!}
				</div>
			</div>
		</div>
		
	</div>
</div>

<div class="card-footer p-2 bg-light">
	<div class="d-flex justify-content-between">
		<div class="form-group mb-0 pl-2">
			<label for="active" class="mb-1 ml-1 text-muted text-cap text-bold small"></label>
			<label class="toggle-switch d-flex align-items-center mb-0" for="active">
				{!! Form::checkbox('active', 1, null, ['class' => 'toggle-switch-input', 'id' => 'active']) !!}
				<span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span>
				<span class="toggle-switch-content">
					<span class="d-block">Aktif</span>
				</span>
			</label>
		</div>
		<button type="submit" class="btn btn-sm btn-primary">
			<i class="tio-save"></i>
			Simpan
		</button>
	</div>
</div>