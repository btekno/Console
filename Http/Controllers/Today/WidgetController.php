<?php

namespace Modules\Console\Http\Controllers\Today;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Today\Entities\Widget;

class WidgetController extends Controller
{
    protected $title = 'Widget';

    /**
     * Siapkan konstruktor controller
     * 
     * @param Model $data
     */
    public function __construct(Widget $data) 
    {
        $this->data = $data;
        
        $this->toIndex = route('console::today.widget.index');
        $this->prefix = 'console::today.widget';
        $this->view = 'console::today.widget';

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
        $widget = [];
        if($request->filled('position')):
            $widget = $this->data->wherePosition($request->position)->get();
        endif;

        return view("{$this->view}.index", compact('widget'));
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
            'name' => 'required',
            'html' => 'required', 
            'position' => 'required'
        ]);

        $input = $request->all();
        
        $input['active'] = $request->filled('active') ? 1 : 0;
        $input['show_web'] = $request->filled('show_web') ? 1 : 0;
        $input['show_mobile'] = $request->filled('show_mobile') ? 1 : 0;

        $this->data->create($input);
        
        notify()->flash($this->tCreate, 'success');
        return redirect(route("$this->prefix.index", 'position=' . $request->position));
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

        $widget = [];
        if($request->filled('position')):
            $widget = $this->data->wherePosition($request->position)->get();
        endif;

        return view("{$this->view}.index", compact('edit', 'widget'));
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
            'name' => 'required',
            'html' => 'required', 
            'position' => 'required'
        ]);

        $input = $request->all();

        $input['active'] = $request->filled('active') ? 1 : 0;
        $input['show_web'] = $request->filled('show_web') ? 1 : 0;
        $input['show_mobile'] = $request->filled('show_mobile') ? 1 : 0;

        $edit->update($input);
        
        notify()->flash($this->tUpdate, 'success');
        return redirect(route("$this->prefix.index", 'position=' . $request->position));
    }

    /**
     * Lakukan penghapusan data yang tidak diinginkan
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return String
     */
    public function destroy(Request $request, $id) 
    {
        if($data = $this->data->findOrFail($id)):
            $data->delete();
        endif;

        return 'success';
    }
}
