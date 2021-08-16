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
        $typew = $request->query('type');
        $type = $typew;

        $only = $request->query('only');

        $post = Post::leftJoin('td_users', 'td_posts.user_id', '=', 'td_users.id');
        $post->select('td_posts.*');

        if ($typew == 'all') {
            //not set
        } elseif ($typew === 'category') {
            $category_id = $request->query('category_id');
            $post->where('categories', 'LIKE',  '%"' . $category_id . ',%')->orWhere('categories', 'LIKE',  '%,' . $category_id . ',%');
        } elseif ($typew !== 'featured') {
            $post->where('type', $type);
        } else {
            $post->whereNotNull("featured_at");
        }

        if ($only == 'trashed') {
            $post->onlyTrashed();
        } else {
            $post->whereNull('deleted_at');
        }

        if ($only == 'unapproved') {
            $post->whereApprove('no');
        } else {
            $post->whereApprove('yes');
        }

        return datatables()->of($post)
            ->editColumn('selection', function ($post) {
                return '<div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false"><input type="checkbox" name="selection[]" value="'.$post->id.'"></div>';
            })
            ->editColumn('thumb', function ($post) {
                return '<img src="' . makepreview($post->thumb, 's', 'posts') . '" width="125">';
            })
            ->editColumn('title', function ($post) {
                return '<a href="' . generate_post_url($post) . '" target=_blank style="font-size:16px;font-weight: 600">
                        ' . $post->title . '
                        </a>
                        <div class="product-meta"></div>
                    ';
            })
            ->editColumn('user', function ($post) {
                return $post->user ? '<div  style="font-weight: 400;color:#aaa">
                                        <a href="/profile/' . $post->user->username_slug . '" target="_blank"><img src="' . makepreview($post->user->icon, 's', 'members/avatar') . '" width="32" style="margin-right:6px">' . $post->user->username . '</a>
                                </div>' : '';
            })
            ->addColumn('approve', function ($post) {

                if ($post->deleted_at !== null) {
                    $fsdfd = '<div class="label label-danger">' . trans("admin.OnTrash") . '</div>';
                } elseif ($post->approve == 'draft') {
                    $fsdfd = '<div class="label label-info" style="background-color: #9c486c !important;">' . trans("admin.DraftPost") . '</div>';
                } elseif ($post->approve == 'no') {
                    $fsdfd = '<div class="label label-info" style="background-color: #9c6a11 !important;">' . trans("admin.AwaitingApproval") . '</div>';
                } elseif ($post->featured_at !== null) {
                    $fsdfd =  '<div class="clear"></div><div class="label label-warning" style="background-color: #9C5D54 !important;">' . trans("admin.FeaturedPost") . '</div>';
                } elseif ($post->approve == 'yes') {
                    $fsdfd = '<div class="label label-info">' . trans("admin.Active") . '</div>';
                }

                if ($post->show_in_homepage == 'yes') {
                    $fsdfd .= '<div class="clear"></div><div class="label label-success">' . trans("admin.Pickedforhomepage") . '</div>';
                }

                // if ($post->published_at->getTimestamp() > \Carbon\Carbon::now()->getTimestamp()) {
                //     $fsdfd .= '<div class="label bg-gray">' . trans('v3.scheduled_date', ['date' => $post->published_at->format('j M Y, h:i A')])  . '</div>';
                // }

                return $fsdfd;
            })
            ->editColumn('language', function ($post) {
                if ($post->language) {
                    return config('languages.language.' . $post->language)['name'];
                }
                return "-";
            })
            ->editColumn('published_at', function ($post) {
                if ($post->published_at) {
                    return $post->published_at->format('Y-m-d H:i:s');
                }
                return "-";
            })
            ->editColumn('featured_at', function ($post) {
                if ($post->featured_at) {
                    return $post->featured_at->format('Y-m-d H:i:s');
                }
                return "-";
            })
            ->addColumn('action', function ($post) {
                $edion = '<div class="input-group-btn">
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Actions <span class="fa fa-caret-down"></span></button>
                                  <ul class="dropdown-menu pull-left" style="left:-100px;  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);">';

                if ($post->deleted_at == null) {
                    if ($post->approve == 'no') {
                        $edion = $edion . '<li><a href="' . route("$this->prefix.edit",  $post->id) . '?purpose=approve"><i class="fa fa-check"></i>  ' . trans("admin.Approve") . '</a></li>';
                    } elseif ($post->approve == 'yes') {
                        $edion = $edion . '<li><a href="' . route("$this->prefix.edit",  $post->id) . '?purpose=approve"><i class="fa fa-remove"></i> ' . trans("admin.UndoApprove") . '</a></li>';
                    }

                    if ($post->featured_at == null) {
                        $edion = $edion .  '<li><a href="' . route("$this->prefix.edit",  $post->id) . '?purpose=featured"><i class="fa fa-star"></i> ' . trans("admin.PickforFeatured") . '</a></li>';
                    } else {
                        $edion = $edion .  '<li><a href="' . route("$this->prefix.edit",  $post->id) . '?purpose=featured"><i class="fa fa-remove"></i> ' . trans("admin.UndoFeatured") . '</a></li>';
                    }

                    if ($post->show_in_homepage == null) {
                        $edion = $edion .  '<li><a href="' . route("$this->prefix.edit",  $post->id) . '?purpose=homepage"><i class="fa fa-dashboard"></i> ' . trans("admin.PickforHomepage") . '</a></li>';
                    } elseif ($post->show_in_homepage == 'yes') {
                        $edion = $edion .  '<li><a href="' . route("$this->prefix.edit",  $post->id) . '?purpose=homepage"><i class="fa fa-remove"></i>   ' . trans("admin.UndofromHomepage") . '</a></li>';
                    }

                    $edion = $edion .  '<li class="divider"></li>';

                    $edion = $edion .  '<li><a target="_blank" href="/edit/' . $post->id . '"><i class="fa fa-edit"></i> ' . trans("admin.EditPost") . '</a></li>';

                    $edion = $edion .  '<li class="divider"></li>';
                }

                if ($post->deleted_at == null) {
                    $edion = $edion . '<li><a class="sendtrash" href="' . route("$this->prefix.destroy",  $post->id) . '"><i class="fa fa-trash"></i> ' . trans("admin.SendtoTrash") . '</a></li>';
                } else {
                    $edion = $edion . '<li><a href="' . route("$this->prefix.destroy",  $post->id) . '"><i class="fa fa-trash"></i> ' . trans("admin.RetrievefromTrash") . '</a></li>';
                }

                $edion = $edion .  '<li><a class="permanently" href="' . route("$this->prefix.destroy",  $post->id) . '?force=true"><i class="fa fa-remove"></i> ' . trans("admin.Deletepermanently") . '</a></li>';

                $edion = $edion .  '</ul>
                            </div>';

                return $edion;
            })
            ->escapeColumns(['*'])
            ->make(true);
    }
}
