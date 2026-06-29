<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\DatabaseService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    public function index(Request $request)
    {
        $params = [];
        $params['sort_by'] = $request->input('sort_by', 'id');
        $params['sort_order'] = $request->input('sort_order', 'desc');

        if (null != $request->input('search')) {
            $params['like'] = [
                'text' => $request->input('search'),
                'url' => $request->input('search'),
                'placement' => $request->input('search'),
            ];
        }

        $banners = $this->databaseService->getByParams(Banner::class, $params);

        return view('admin.modules.banner.index', [
            'banners' => $banners,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $banner = null;
        if ($id) {
            $banner = $this->databaseService->find(Banner::class, $id);
        }

        return view('admin.modules.banner.create_edit', [
            'banner' => $banner,
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->except('_token');

        if (isset($params['id'])) {
            $banner = $this->databaseService->find(Banner::class, $params['id']);
            $banner->update($params);
            $message = 'Banner updated successfully.';
        } else {
            $banner = Banner::create($params);
            $message = 'Banner created successfully.';
        }

        return redirect()
            ->route('admin.banners.edit', ['id' => $banner->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        $this->databaseService->destroy(Banner::class, $id);

        return redirect()
            ->route('admin.marquees.index')
            ->with('status', 'Marquee deleted successfully');
    }
}
