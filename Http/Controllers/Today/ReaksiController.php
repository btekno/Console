<?php

namespace Modules\Console\Http\Controllers\Today;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Today\Entities\Reaction;

class ReaksiController extends Controller
{
    protected $title = 'Reaction';

    /**
     * Siapkan konstruktor controller
     * 
     * @param Model $data
     */
    public function __construct(Reaction $data) 
    {
        $this->data = $data;
        
        $this->toIndex = route('console::today.reaksi.index');
        $this->prefix = 'console::today.reaksi';
        $this->view = 'console::today.reaksi';

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
        $data = $this->data->orderBy('order', 'asc');
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
        $this->validate($request, [
            'order' => 'required|unique:mysql_today.td_reactions,order', 
            'name' => 'required', 
            'icon' => 'required|mimes:jpg,jpeg,png,gif', 
        ]);

        $input = $request->all();
        
        $input['active'] = $request->filled('active') ? 1 : 0;
        $input['slug'] = str_slug($request->name);
        if($request->hasFile('icon')):
            $input['icon'] = $this->upload($request->file('icon'), $input['slug']);
        endif;

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

        $data = $this->data->orderBy('order', 'asc');
        if($request->has('datatable')):
            return $this->datatable($data);
        endif;

        return view("{$this->view}.index", compact('edit', 'data'));
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
            'order' => 'required|unique:mysql_today.td_reactions,order,' . $edit->id, 
            'name' => 'required', 
            'icon' => 'mimes:jpg,jpeg,png,gif', 
        ]);

        $input = $request->all();

        $input['active'] = $request->filled('active') ? 1 : 0;
        $input['slug'] = str_slug($request->name);
        if($request->hasFile('icon')):
            awsDeleteImg($edit->icon);
            $input['icon'] = $this->upload($request->file('icon'), $input['slug']);
        else:
            $input['icon'] = $edit->icon;
        endif;

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
                awsDeleteImg($data->icon);

                $data->delete();
            endforeach;
            
            notify()->flash($this->tDelete, 'success');
            return redirect()->back();
        endif;
    }

    /**
     * Function for Upload File
     * 
     * @param  $file, $filename
     * @return URI
     */
    public function upload($file, $filename) 
    {
        $ekstensi = $file->getClientOriginalExtension();

        $image = \Image::make($file)->stream();
        \Storage::disk('s3')->put('Today/Reaction/'.$filename.'.'.$ekstensi, file_get_contents($file), 'public');

        return \Storage::disk('s3')->url('Today/Reaction/'.$filename.'.'.$ekstensi);
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
            ->editColumn('order', function($data) {
                $return = $data->order;

                return $return;
            })
            ->editColumn('name', function($data) {
                $return = <<<EOD
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm">
                            <img class="avatar-img" src="{$data->icon}" alt="">
                        </div>
                        <div class="ml-3">
                            <span class="d-block h5 text-hover-primary mb-0">{$data->name}</span>
                        </div>
                    </div>
                EOD;

                return $return;
            })
            ->editColumn('display', function($data) {
                $status = $data->active == 1 ? 'checked' : '';
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
                'order', 
                'name', 
                'display', 
                'aksi'
            ])->toJson();
    }
}
