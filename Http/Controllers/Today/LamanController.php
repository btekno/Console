<?php

namespace Modules\Console\Http\Controllers\Today;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Today\Entities\Page;

class LamanController extends Controller
{
    protected $title = 'Halaman';

    /**
     * Siapkan konstruktor controller
     * 
     * @param Model $data
     */
    public function __construct(Page $data) 
    {
        $this->data = $data;
        
        $this->toIndex = route('console::today.laman.index');
        $this->prefix = 'console::today.laman';
        $this->view = 'console::today.laman';

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
        $data = $this->data->latest();
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
            ->editColumn('title', function($data) {
                $return = $data->title;

                return $return;
            })
            ->editColumn('footer', function($data) {
                $status = $data->footer == 1 ? 'checked' : '';
                return <<<EOD
                    <label class="toggle-switch toggle-switch-sm align-items-center" for="status">
                        <input type="checkbox" name="status" class="toggle-switch-input" id="status" {$status} disabled>
                        <span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span>
                    </label>
                EOD;
            })
            ->editColumn('aksi', function($data) {
                $return  = '<a href="'.route("$this->prefix.edit", $data->id).'" class="btn btn-xs btn-white" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">';
                $return .= '    <i class="tio-new-message"></i> <span class="sembunyi">Edit</span>';
                $return .= '</a>';

                return $return;
            })
            ->rawColumns([
                'pilihan', 
                'title', 
                'footer', 
                'aksi'
            ])->toJson();
    }
}
