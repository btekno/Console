<?php

namespace Modules\Console\Http\Controllers\Today;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Today\Entities\Menu\Menu;
use Modules\Today\Entities\Menu\Item;

class MenuController extends Controller
{
    protected $title = 'Menu';

    /**
     * Siapkan konstruktor controller
     * 
     * @param Model $data
     */
    public function __construct(Menu $data, Item $item) 
    {
        $this->data = $data;
        $this->item = $item;
        
        $this->toIndex = route('console::today.menu.index');
        $this->prefix = 'console::today.menu';
        $this->view = 'console::today.menu';

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
        $menu = null;
        if($request->filled('location')):
            $menu = $this->data->whereLocation($request->location)->firstOrFail();
        endif;

        return view("{$this->view}.index", compact('menu'));
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
            'menu_id' => 'required',
            'title' => 'required|max:191', 
            'url' => 'required'
        ]);

        $parent_id = isset($request->parent_id) ? $request->parent_id : null;
        $parent_id = $this->checkParentDepth($request->menu_id, $parent_id);

        $order = ($parent_id)
            ? $this->item->where('parent_id', $parent_id)->max('order')
            : $this->item->whereNull('parent_id')->max('order');

        $menuItem = new Item();
        $menuItem->menu_id = $request->menu_id;
        $menuItem->title = $request->title;
        $menuItem->url = $request->url;
        $menuItem->target = $request->target;
        $menuItem->parent_id = $parent_id;
        $menuItem->order = $order + 1;
        $menuItem->icon = $request->icon;
        $menuItem->custom_class = $request->custom_class;
        $menuItem->save();

        notify()->flash($this->tCreate, 'success');
        return redirect()->back();        
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
        $menu = null;
        if($request->filled('location')):
            $menu = $this->data->whereLocation($request->location)->firstOrFail();
        endif;

        $menu_item = $this->item->findOrFail($id);

        return view("{$this->view}.index", compact('menu', 'menu_item'));
    }

    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Back [Tampilkan halaman yang sama]
     */
    public function update(Request $request, $id) 
    {  
        if($request->filled('purpose')):
            switch($request->purpose):
                case 'sort':
                    return $this->sort($request);
                break;
                default:
                    return abort(404);
                break;
            endswitch;
        endif;

        if($menuItem = $this->item->find($request->get('id'))):
            $menuItem->title = $request->title;
            $menuItem->url = $request->url;
            $menuItem->target = $request->target;
            $menuItem->icon = $request->icon;
            $menuItem->custom_class = $request->custom_class;
            $menuItem->update();
        endif;

        notify()->flash($this->tUpdate, 'success');
        return redirect(route("$this->prefix.index", 'location='.$request->location));
    }

    /**
     * Lakukan penghapusan data yang tidak diinginkan
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return String
     */
    public function destroy(Request $request, $id) 
    {
        if($menuItem = $this->item->find($request->id)):
            if($childrens = $menuItem->childrens):
                foreach($childrens as $children):
                    $child = $this->item->find($children->id);
                    $child->parent_id = $menuItem->parent_id;
                    $child->save();
                endforeach;
            endif;

            $menuItem->delete();
        endif;

        return 'success';
    }

    /**
     * Sort menu items.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    private function sort($request)
    {
        if($request->ajax()):
            $items = $request->get('menu');
            foreach($items as $item):
                $menuItem = $this->item->find($item['id']);
                $parent_id = isset($item['parent_id']) ? $item['parent_id'] : null;

                if($parent_id):
                    $this->order[$parent_id] = isset($this->order[$parent_id]) ? $this->order[$parent_id] + 1 : 1;
                    $newOrder = $this->order[$parent_id];
                endif;

                if(!$parent_id):
                    $this->order['root'] = isset($this->order['root']) ? $this->order['root'] + 1 : 1;
                    $newOrder = $this->order['root'];
                endif;

                if($parent_id != $menuItem->id):
                    $menuItem->parent_id = $parent_id;
                    $menuItem->order = $newOrder;
                    $menuItem->update();
                endif;
            endforeach;

            return response()->json(['success' => true]);
        endif;

        return response()->json(['success' => false]);
    }

    /**
     * Check Root Depths alongs parent and childrens.
     *
     * @param int    $menu_id
     * @param array  $items
     * @param object $menuItem
     * @param int    $child_depth
     * @param array  $ids
     *
     * @return array
     */
    public function checkParentsWithChildrens($menu_id, $items, $menuItem, $child_depth = 0, $ids = [])
    {
        $settings = menu_settings($menu_id);
        foreach ($items as $item) {
            if ($item->id != $menuItem->id) {
                $this->root_depth = 0;
                $depth = $this->getRootDepth($item->id) + $child_depth;

                if ($depth < $settings['depth']) {
                    if ($settings['apply_child_as_parent']) {
                        $this->parents[] = $item;
                    } elseif (!in_array($item->id, $ids)) {
                        $this->parents[] = $item;
                    }
                }
            }
        }

        return $this->parents;
    }

    /**
     * Check Root Parent.
     *
     * @param int   $menu_id
     * @param array $items
     *
     * @return array
     */
    public function checkParents($menu_id, $items)
    {
        foreach ($items as $item) {
            $this->root_depth = 0;
            $depth = $this->getRootDepth($item->id);
            $depth = 2;

            if ($depth < $depth) {
                $this->parents[] = $item;
            }
        }

        return $this->parents;
    }

    /**
     * Check Parent Depth.
     *
     * @param int $menu_id
     * @param int $parent_id
     * @param int $child_depth
     *
     * @return int $parent_id|null
     */
    public function checkParentDepth($menu_id, $parent_id, $child_depth = 0)
    {
        if ($parent_id == null) {
            return null;
        }

        // Check root parent depth limit
        $depth = $this->getRootDepth($parent_id) + $child_depth;
        $settings = menu_settings($menu_id);

        return ($depth < $settings['depth']) ? $parent_id : null;
    }

    /**
     * Get Root Parent Id.
     *
     * @param int $id
     *
     * @return int
     */
    public function getRootParent($id)
    {
        if ($menu = $this->item->find($id)) {
            $this->root = $menu->id;

            if ($menu->parent_id) {
                $this->getRootParent($menu->parent_id);
            }
        }

        return $this->root;
    }

    /**
     * Get root depth.
     *
     * @param int $id
     *
     * @return int
     */
    public function getRootDepth($id)
    {
        if ($menu = $this->item->find($id)) {
            $this->root_depth++;

            if ($menu->parent_id) {
                $this->getRootDepth($menu->parent_id);
            }
        }

        return $this->root_depth;
    }

    /**
     * Get Children depth.
     *
     * @param array $childrens
     *
     * @return int
     */
    public function getDepth($childrens)
    {
        if (count($childrens) > 0) {
            $this->depth++;

            foreach ($childrens as $children) {
                if (count($children->childrens) > 0) {
                    $this->getDepth($children->childrens);
                }
            }
        }

        return $this->depth;
    }

    /**
     * Convert childrens multidimensional to single dimension.
     *
     * @param array $childrens
     *
     * @return array|false
     */
    public function getSingleDimentionChildrens($childrens)
    {
        if (empty($childrens)) {
            return false;
        }

        foreach ($childrens as $children) {
            $this->childrens[] = $children;

            if (!empty($children['childrens'])) {
                $this->getSingleDimentionChildrens($children['childrens']);
            }
        }

        return $this->childrens;
    }

    /**
     * Get all Childrens.
     *
     * @param int    $menu_id
     * @param int    $parent_id
     * @param string $orderBy
     *
     * @return array
     */
    public function getChildrens($menu_id, $parent_id = null, $orderBy = 'asc')
    {
        return $this->item->with('childrens')
            ->where(['menu_id' => $menu_id, 'parent_id' => $parent_id])
            ->orderBy('order', $orderBy)
            ->get();
    }

    /**
     * Get Items id.
     *
     * @param array $items
     *
     * @return array
     */
    public function getIds($items)
    {
        $ids = [];

        foreach ($items as $item) {
            $ids[] = $item->id;
        }

        return $ids;
    }
}
