<div class="py-2 px-3 bg-light">
    <div class="row align-items-center">
        <div class="col-sm mb-2 mb-sm-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-no-gutter mb-0">
                    @isset($breadcrumbs)
                        @foreach($breadcrumbs as $i => $temp)
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="{{ $i }}">{{ $temp }}</a>
                            </li>
                        @endforeach
                    @endisset
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
            <h1 class="page-header-title">{{ $title }}</h1>
        </div>
        <div class="col-sm-auto tombol-kanan d-flex">

            @stack('push-menu')
            
            @if(isset($hapus))
                <button type="submit" class="btn btn-sm btn-danger mr-1" id="delete-all-button" style="display:none">
                    <i class="tio-delete"></i> Hapus
                </button>
            @endif
            @isset($tambah)
                <a class="btn btn-sm btn-primary mr-1" href="{{ $tambah }}">
                    <i class="tio-add"></i> <span class="sembunyi">Tambah</span>
                </a>
            @endisset
            @isset($kembali)
                <a class="btn btn-sm btn-white" href="{{ $kembali }}">
                    <i class="tio-back-ui"></i> Kembali
                </a>
            @endisset
        </div>
    </div>
</div>