<?php

namespace Modules\Console\Http\Controllers\Today;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Today\Entities\User;

class MemberController extends Controller
{
    protected $title = 'Member';

    /**
     * Siapkan konstruktor controller
     * 
     * @param Model $data
     */
    public function __construct(User $data) 
    {
        $this->data = $data;
        
        $this->toIndex = route('console::today.member.index');
        $this->prefix = 'console::today.member';
        $this->view = 'console::today.member';

        $this->tCreate = "Data $this->title berhasil ditambah!";
        $this->tUpdate = "Data $this->title berhasil diubah!";
        $this->tDelete = "Beberapa $this->title berhasil dihapus!";

        view()->share([
            'title' => $this->title, 
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
        $data = $this->data->query();

        if($request->filled('filter')):
            if($request->filter == 'admin'):
                $data = $data->where('type', 'Admin');
            endif;
            if($request->filter == 'staff'):
                $data = $data->where('type', 'Staff');
            endif;
            if($request->filter == 'banned'):
                $data = $data->where('type', 'Banned');
            endif;
            if($request->filter == 'member'):
                $data = $data->where('type', 'Member');
            endif;
        endif;

        if($request->has('datatable')):
            return $this->datatable($data);
        endif;

        return view("{$this->view}.index", compact('data'));
    }

    /**
     * Tampilkan halaman untuk menambah data
     * 
     * @return Illuminate\View\View
     */
    public function create() 
    {
        return abort(404);
    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param  Illuminate\Http\Request
     * @return mixed
     */
    public function store(Request $request) 
    {
        return abort(404);
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

        if($request->filled('purpose')):
            switch($request->purpose):
                case 'banned':
                    $edit->type = 'Banned';
                    $edit->save();
                break;
                case 'member':
                    $edit->type = 'Member';
                    $edit->save();
                break;
                case 'make-admin':
                    $edit->type = 'Admin';
                    $edit->save();
                break;
                case 'make-staff':
                    $edit->type = 'Staff';
                    $edit->save();
                break;
                default:
                    return abort(404);
                break;
            endswitch;
        endif;

        notify()->flash('Status member berhasil diperbarui.', 'success');
        return redirect()->back();
    }

    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Back [Tampilkan halaman yang sama]
     */
    public function update(Request $request, $id) 
    {   
        return abort(404);
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
     * Datatable API
     * @param  $data
     * @return Datatable
     */
    public function datatable($data) 
    {
        return datatables()->of($data)
            ->editColumn('pilihan', function($data) {
                $return  = '<div class="custom-control custom-checkbox">';
                $return .= '    <input type="checkbox" class="custom-control-input pilihan" id="pilihan['.$data->id.']" name="pilihan[]" value="'.$data->id.'">';
                $return .= '    <label class="custom-control-label" for="pilihan['.$data->id.']"></label>';
                $return .= '</div>';

                return $return;
            })
            ->editColumn('name', function($data) {
                $return = $data->user->name;

                return <<<EOD
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm">
                            <img class="avatar-img" src="{$data->user->photo}" alt="">
                        </div>
                        <div class="ml-2">
                            <span class="d-block h5 text-hover-primary mb-0">{$data->user->name}</span>
                            <span class="d-block font-size-sm text-body">{$data->user->email}</span>
                        </div>
                    </div>
                EOD;
            })
            ->editColumn('status', function($data) {
                $return = '';
                switch($data->type):
                    case 'Admin':
                        $return .= '<span class="legend-indicator bg-success"></span>';
                    break;
                    case 'Staff':
                        $return .= '<span class="legend-indicator bg-warning"></span>';
                    break;
                    case 'Member':
                        $return .= '<span class="legend-indicator bg-secondary"></span>';
                    break;
                    case 'Banned':
                        $return .= '<span class="legend-indicator bg-danger"></span>';
                    break;
                endswitch;
                $return .= $data->type;

                return $return;
            })
            ->editColumn('created_at', function($data) {
                \Carbon\Carbon::setLocale('id');
                if(!is_null($data->user->created_at)):
                    $return  = '<span class="d-block small text-body">'.date('Y-m-d h:i:s', strtotime($data->user->created_at)).'</span>';
                    $return .= '<span class="d-block h6 mb-0">Last Seen: ' . ($data->user->last_logged ?? '-').'</span>';
                else:
                    $return = '<small>Never Login</small>';
                endif;

                return $return;
            })
            ->editColumn('aksi', function($data) {
                $return  = '<div class="btn-group">';
                $return .= '<a href="" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Edit">';
                $return .= '    <i class="tio-new-message"></i>';
                $return .= '</a>';
                if($data->type == 'Banned'):
                    $return .= '<a href="'.route("$this->prefix.edit", $data->id).'?purpose=member" class="btn btn-xs btn-white" data-toggle="tooltip" data-placement="top" title="Unlock User">';
                    $return .= '    <i class="tio-lock-opened"></i>';
                    $return .= '</a>';
                else:
                    $return .= '<a href="'.route("$this->prefix.edit", $data->id).'?purpose=banned" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Lock User">';
                    $return .= '    <i class="tio-lock"></i>';
                    $return .= '</a>';
                endif;
                if($data->type != 'Admin'):
                    $return .= '<a href="'.route("$this->prefix.edit", $data->id).'?purpose=make-admin" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Jadikan Admin">';
                    $return .= '    <i class="tio-account-square"></i>';
                    $return .= '</a>';
                else:
                    $return .= '<a href="'.route("$this->prefix.edit", $data->id).'?purpose=member" class="btn btn-xs btn-white" data-toggle="tooltip" data-placement="top" title="Not Admin">';
                    $return .= '    <i class="tio-clear"></i>';
                    $return .= '</a>';
                endif;
                if($data->type != 'Staff'):
                    $return .= '<a href="'.route("$this->prefix.edit", $data->id).'?purpose=make-staff" class="btn btn-xs btn-warning text-white" data-toggle="tooltip" data-placement="top" title="Jadikan Staff">';
                    $return .= '    <i class="tio-user-add"></i>';
                    $return .= '</a>';
                else:
                    $return .= '<a href="'.route("$this->prefix.edit", $data->id).'?purpose=member" class="btn btn-xs btn-white" data-toggle="tooltip" data-placement="top" title="Not Staff">';
                    $return .= '    <i class="tio-clear"></i>';
                    $return .= '</a>';
                endif;
                $return .= '</div>';

                return $return;
            })
            ->rawColumns([
                'pilihan', 
                'name', 
                'status', 
                'created_at', 
                'last_login', 
                'aksi'
            ])->toJson();
    }
}
