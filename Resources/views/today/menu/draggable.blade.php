<ol class="dd-list">
    @foreach ($lists as $list)
        <li class="dd-item" data-order="{{ $list->order }}" data-id="{{ $list->id }}">
            <div class="dd-handle d-flex align-content-center">
                <span class="item-icon" >{!! menu_icon($list->icon) !!} </span>
                <span class="item-title">{{ $list->title }}</span>
                <span class="item-url">{{ $list->url }}</span>
            </div>
            <div class="action-area">
                <a href="{{ route("$prefix.edit", $list->id) }}?location={{ request('location') }}" class="btn btn-sm btn-outline-info mr-1" data-toggle="tooltip" data-original-title="Edit">
                    <i class="tio-new-message"></i>
                </a>
                <a class="btn btn-sm btn-outline-danger" href="javascript:;" onclick="modalHapus('{{ $list->id }}')" role="button" data-toggle="tooltip" data-original-title="Hapus">
                    <i class="tio-delete"></i>
                </a>
            </div>
            @if(count($list->childrens) > 0)
                @include("$view.draggable", ['lists' => $list->childrens])
            @endif
        </li>
    @endforeach
</ol>