<?php

namespace Modules\Console\Http\Controllers\Today;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    /**
     * Siapkan konstruktor controller
     * 
     * @param Model $data
     */
    public function __construct() 
    {
        $this->toIndex = route('console::today.pengaturan.index');
        $this->prefix = 'console::today.pengaturan';
        $this->view = 'console::today.pengaturan';

        view()->share([
            'prefix' => $this->prefix, 
            'view' => $this->view
        ]);
    }

    /**
     * Display a listing of the resource.
     * 
     * @return Renderable
     */
    public function index(Request $request)
    {
        switch($request->page):
            case 'mail-settings':
                return view("$this->view.mail-settings");
            break;
            case 'social-media':
                return view("$this->view.social-media");
            break;
            case 'file-storage':
                return view("$this->view.file-storage");
            break;
            case 'other-settings':
                return view("$this->view.other-settings");
            break;
            case 'appearance':
                return view("$this->view.appearance");
            break;
            case 'advanced':
                return view("$this->view.advanced");
            break;
            default:
                return view("$this->view.general-settings");
            break;
        endswitch;
    }
}
