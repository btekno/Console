<?php

namespace Modules\Console\Http\Controllers\Today;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Today\Entities\Post;

class PostController extends Controller
{
    /**
     * Siapkan konstruktor controller
     * 
     * @param Model $data
     */
    public function __construct(Post $data) 
    {
        $this->data = $data;
        
        $this->toIndex = route('console::today.posts.index');
        $this->prefix = 'console::today.posts';
        $this->view = 'console::today.posts';

        $this->tCreate = "Data Postingan berhasil ditambah!";
        $this->tUpdate = "Data Postingan berhasil diubah!";
        $this->tDelete = "Beberapa Postingan berhasil dihapus!";

        view()->share([
            'prefix' => $this->prefix, 
            'view' => $this->view
        ]);
    }

    /**
     * Return a list of the names of the site's organizations.
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\View\View
     */
    public function index(Request $request) 
    {
        if($request->has('datatable')):
            return $this->datatable($request);
        endif;

        $type = 'all';
        $title = 'Latest Posts';
        if($request->filled('only')):
            if($request->only == 'unapproved'):
                $type = 'unapproved';
                $title = 'Menunggu Persetujuan';
            endif;
            if($request->only == 'trashed'):
                $type = 'trashed';
                $title = 'Recycle Bin';
            endif;
            if($request->only == 'featured'):
                $type = 'featured';
                $title = 'Featured Posts';
            endif;
        endif;

        return view("{$this->view}.index")->with([
            'title' => $title, 
            'desc' => '', 
            'type' => $type
        ]);
    }

    /**
     * Tampilkan halaman untuk menambah data
     * 
     * @return Illuminate\View\View
     */
    public function create() 
    {
        return view("{$this->view}.create");
    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param  Illuminate\Http\Request
     * @return mixed
     */
    public function store(Request $request) 
    {
        $this->validate($request, [
            'title' => 'required', 
            'content' => 'required'
        ]);

        $input = $request->all();
        
        $input['slug'] = str_slug($request->title);
        $input['footer'] = $request->filled('footer') ? 1 : 0;

        $this->data->create($input);
        
        notify()->flash($this->tCreate, 'success');
        return redirect($this->toIndex);
    }

    /**
     * Menampilkan detail lengkap
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Illuminate\View\View
     */
    public function show($id) 
    {
        return abort(404);
    }

    /**
     * Tampilkan halaman perubahan data
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Illuminate\View\View
     */
    public function edit(Request $request, $id) 
    {
        $edit = $this->data->findOrFail($id);

        return view("{$this->view}.edit", compact('edit'));
    }

    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Back [Tampilkan halaman yang sama]
     */
    public function update(Request $request, $id) 
    {   
        $edit = $this->data->findOrFail($id);

        $this->validate($request, [
            'title' => 'required', 
            'content' => 'required' 
        ]);

        $input = $request->all();

        $input['slug'] = str_slug($request->title);
        $input['footer'] = $request->filled('footer') ? 1 : 0;

        $edit->update($input);
        
        notify()->flash($this->tUpdate, 'success');
        return redirect($this->toIndex);
    }

    /**
     * Lakukan penghapusan data yang tidak diinginkan
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return String
     */
    public function destroy(Request $request, $id) 
    {
        if($request->has('pilihan')):
            foreach($request->pilihan as $temp):
                $data = $this->data->findOrFail($temp);
                $data->delete();
            endforeach;
            
            notify()->flash($this->tDelete, 'success');
            return redirect()->back();
        endif;
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        $type = $request->query('type');
        $only = $request->query('only');

        $post = $this->data->leftJoin('td_users', 'td_posts.user_id', '=', 'td_users.id');
        $post->select('td_posts.*');

        switch($type):
            case 'all':break;
            case 'category':
                $category_id = $request->query('category_id');
                $post->where('categories', 'LIKE', '%"' . $category_id . ',%')->orWhere('categories', 'LIKE',  '%,' . $category_id . ',%');
            break;
            case 'featured':
                $post->where('type', $type);
            break;
            default:
                $post->whereNotNull("featured_at");
            break;
        endswitch;

        if($only == 'trashed'):
            $post->onlyTrashed();
        else:
            $post->whereNull('deleted_at');
        endif;

        if($only == 'unapproved'):
            $post->whereApprove('no');
        else:
            $post->whereApprove('yes');
        endif;

        return datatables()->of($post)
            ->editColumn('selection', function ($post) {
                return '<div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false"><input type="checkbox" name="selection[]" value="'.$post->id.'"></div>';
            })
            ->editColumn('title', function($post) {
                $url = generate_post_url($post);
                $thumb = makepreview($post->thumb, 's', 'posts');

                $status = '';
                if($post->deleted_at !== null):
                    $status .= '<div class="badge badge-soft-danger">On Trash</div><br/>';
                else:
                    if($post->approve == 'yes'):
                        $status .= '<div class="badge badge-success">Active</div><br/>';
                    endif;
                    if($post->approve == 'draft'):
                        $status .= '<div class="badge badge-white">Draft Post</div><br/>';
                    endif;
                    if($post->approve == 'no'):
                        $status .= '<div class="badge badge-soft-warning">Awaiting Approval</div><br/>';
                    endif;

                    if($post->featured_at !== null):
                        $status .= '<div class="badge badge-soft-primary">Featured Post</div><br/>';
                    endif;
                    if($post->show_in_homepage == 'yes'):
                        $status .= '<div class="badge badge-soft-success">Picked for Homepage</div><br/>';
                    endif;
                    // if($post->published_at):
                    //     $status .= '<div class="badge badge-soft-secondary">Scheduled for '.$post->published_at->format('j M Y, h:i A').'</div><br/>';
                    // endif;
                endif;
                return <<<EOD
                    <div class="d-flex align-items-start">
                        <div class="avatar avatar-xl avatar-4by3">
                            <img class="avatar-img" src="{$thumb}" alt="">
                        </div>
                        <div class="ml-2">
                            <a class="d-block text-body mb-0" href="{$url}">{$post->title}</a>
                            <span class="d-block font-size-sm text-body">{$post->user->email}</span>
                            <div>{$status}</div>
                        </div>
                    </div>
                EOD;
            })
            ->editColumn('user', function ($post) {
                return $post->user ? '<a href="/u/' . optional(optional($post->user)->user)->username . '" target="_blank" data-toggle="tooltip" data-placement="top" title="'.optional(optional($post->user)->user)->name.'"><img src="' . optional(optional($post->user)->user)->photo . '" width="32"></a>' : '';
            })
            ->editColumn('created_at', function ($post) {
                \Carbon\Carbon::setLocale('id');
                if($post->created_at):
                    $return  = '<span class="d-block small text-body">'.$post->created_at->format('Y-m-d H:i:s').'</span>';
                    $return .= '<span class="d-block h6 mb-0">'. str_replace('yang ', '', $post->created_at->diffForHumans()) .'</span>';
                else:
                    $return = '-';
                endif;

                return $return;
            })
            ->editColumn('published_at', function ($post) {
                \Carbon\Carbon::setLocale('id');
                if($post->published_at):
                    $return  = '<span class="d-block small text-body">'.$post->published_at->format('Y-m-d H:i:s').'</span>';
                    $return .= '<span class="d-block h6 mb-0">'. str_replace('yang ', '', $post->published_at->diffForHumans()) .'</span>';
                else:
                    $return = '-';
                endif;

                return $return;
            })
            ->editColumn('featured_at', function ($post) {
                \Carbon\Carbon::setLocale('id');
                if($post->featured_at):
                    $return  = '<span class="d-block small text-body">'.$post->featured_at->format('Y-m-d H:i:s').'</span>';
                    $return .= '<span class="d-block h6 mb-0">'. str_replace('yang ', '', $post->featured_at->diffForHumans()) .'</span>';
                else:
                    $return = '-';
                endif;

                return $return;
            })
            ->addColumn('aksi', function ($post) {
                $return = '<button type="button" class="btn btn-sm btn-white dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="tio-more-horizontal"></i>
                        </button>
                        <ul class="dropdown-menu rounded-sm">';

                if($post->deleted_at == null):
                    if($post->approve == 'no'):
                        $return .= '<li>
                                <a href="' . route("$this->prefix.edit",  $post->id) . '?purpose=approve" class="dropdown-item pl-3">
                                    <i class="tio-checkmark-square text-success"></i> Approve
                                </a>
                            </li>';
                    else:
                        $return .= '<li>
                                <a href="' . route("$this->prefix.edit",  $post->id) . '?purpose=approve" class="dropdown-item pl-3">
                                    <i class="tio-clear text-danger"></i> Undo Approve
                                </a>
                            </li>';
                    endif;

                    if($post->featured_at == null):
                        $return .= '<li>
                                <a href="' . route("$this->prefix.edit",  $post->id) . '?purpose=featured" class="dropdown-item pl-3">
                                    <i class="tio-star text-warning"></i> Pick for Featured
                                </a>
                            </li>';
                    else:
                        $return .= '<li>
                                <a href="' . route("$this->prefix.edit",  $post->id) . '?purpose=featured" class="dropdown-item pl-3">
                                    <i class="tio-star"></i> Undo Featured
                                </a>
                            </li>';
                    endif;

                    if($post->show_in_homepage == null):
                        $return .= '<li>
                                <a href="' . route("$this->prefix.edit",  $post->id) . '?purpose=homepage" class="dropdown-item pl-3">
                                    <i class="tio-clock text-success"></i> Pick for Homepage
                                </a>
                            </li>';
                    else:
                        $return .= '<li>
                                <a href="' . route("$this->prefix.edit",  $post->id) . '?purpose=homepage" class="dropdown-item pl-3">
                                    <i class="tio-clock"></i> Undo From Homepage
                                </a>
                            </li>';
                    endif;

                    $return .= '<li class="divider"></li>';
                    $return .= '<li>
                            <a target="_blank" href="/edit/' . $post->id . '" class="dropdown-item pl-3">
                                <i class="tio-new-message"></i> Edit Post
                            </a>
                        </li>';
                    $return .= '<li class="divider"></li>';
                    $return .= '<li>
                            <a href="' . route("$this->prefix.destroy",  $post->id) . '" class="dropdown-item pl-3">
                                <i class="tio-add-to-trash text-danger mr-1"></i> Send to Trash
                            </a>
                        </li>';
                
                else:
                    $return .= '<li><a href="' . route("$this->prefix.destroy",  $post->id) . '" class="dropdown-item pl-3"><i class="tio-recycling text-success mr-1"></i> Retrieve from Trash</a></li>';
                endif;

                $return .= '<li>
                    <a href="' . route("$this->prefix.destroy",  $post->id) . '?force=true" class="dropdown-item pl-3 text-danger">
                        <i class="tio-delete  mr-1"></i> Hapus Permanen
                    </a>
                </li>';

                $return .= '</ul>';

                return $return;
            })
            ->escapeColumns(['*'])
            ->make(true);
    }
}
