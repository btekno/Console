<div class="card-body bg-light p-0" style="min-height: calc(100vh - 266px);">
	<div class="p-3">
		<div class="form-group mb-2 mt-3">
			<label for="order" class="mb-1 ml-1 text-muted text-cap text-bold small">
				Order <span class="text-danger">*</span>
			</label>
			{!! Form::number('order', null, ['class' => 'form-control', 'placeholder' => 'Urutan tampilan icon.']) !!}
			{!! $errors->first('order', '<small class="text-danger">:message</small>') !!}
		</div>

		<div class="form-group mb-2">
			<label for="name" class="mb-1 ml-1 text-muted text-cap text-bold small">
				Nama <span class="text-danger">*</span>
			</label>
			{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'eg. Awesome']) !!}
			{!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
		</div>

		<div class="form-group mb-2">
			<label for="icon" class="mb-1 ml-1 text-muted text-cap text-bold small">
				Icon <span class="text-danger">*</span>
			</label>
			<div class="custom-file">
				<input type="file" class="js-file-attach custom-file-input" id="customFile" name="icon" 
				data-hs-file-attach-options='{
					"textTarget": "[for=\"customFile\"]"
				}'>
				<label class="custom-file-label" for="customFile">Pilih File</label>
			</div>
			<span class="d-block mt-1 pl-1 text-muted small">Hanya mendukung file .jpg, .png & .gif</span>
			{!! $errors->first('icon', '<small class="text-danger">:message</small>') !!}
		</div>
	</div>
</div>

<div class="card-footer p-1 bg-light">
	<div class="d-flex justify-content-between">
		<div class="form-group mb-0">
			<label for="active" class="mb-1 ml-1 text-muted text-cap text-bold small"></label>
			<label class="toggle-switch d-flex align-items-center mb-0" for="active">
				{!! Form::checkbox('active', 1, null, ['class' => 'toggle-switch-input', 'id' => 'active']) !!}
				<span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span>
				<span class="toggle-switch-content">
					<span class="d-block">Tampilkan</span>
				</span>
			</label>
		</div>
		<button type="submit" class="btn btn-sm btn-primary">
			<i class="tio-save"></i>
			Simpan
		</button>
	</div>
</div>