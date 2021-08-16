<div class="card-body pb-0" style="height: calc(100vh - 245px);overflow-y: scroll;">
    <div class="row form-group mb-2">
        <label for="title" class="col-sm-2 col-form-label font-weight-bold">
            Title <span class="text-danger">*</span>
        </label>
        <div class="col-sm-10">
            {!! Form::text('title', null, ['class' => 'form-control' . $errors->first('title', ' is-invalid')]) !!}
            {!! $errors->first('title', '<small class="text-danger">:message</small>') !!}
        </div>
    </div>

    <div class="row form-group mb-2">
        <label for="content" class="col-sm-2 col-form-label font-weight-bold">
            Content <span class="text-danger">*</span>
        </label>
        <div class="col-sm-10">
            {!! Form::textarea('content', null, ['class' => 'form-control tinymce' . $errors->first('content', ' is-invalid')]) !!}
            {!! $errors->first('content', '<small class="text-danger">:message</small>') !!}
        </div>
    </div>

    <div class="row form-group mb-2">
        <label for="footer" class="col-sm-2 col-form-label font-weight-bold">
            Footer Link ?
        </label>
        <div class="col-sm-10">
            <label class="toggle-switch d-flex align-items-center mb-0" for="footer">
                {!! Form::checkbox('footer', 1, null, ['class' => 'toggle-switch-input', 'id' => 'footer']) !!}
                <span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span>
                <span class="toggle-switch-content">
                    <span class="d-block">Tampilkan</span>
                </span>
            </label>
        </div>
    </div>
</div>

<div class="card-footer p-2 rounded-0 bg-light d-flex justify-content-end">
    <button type="submit" class="btn btn-primary">
        <i class="tio-save"></i>
        Simpan
    </button>
</div>