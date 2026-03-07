<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blacklist;
use App\Services\DatabaseService;

class BlacklistController extends Controller
{
    protected $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    public function index(Request $request)
    {
        $params = [];
        $params['sort_by'] = $request->get('sort_by', 'id');
        $params['sort_order'] = $request->get('sort_order', 'desc');

        if (null != $request->get('search')) {
            $params['like'] = [
                'mobile' => $request->get('search'),
                'ip_address' => $request->get('search'),
            ];
        }

        $blacklists = $this->databaseService->getByParams(Blacklist::class, $params);

        return view('admin.modules.blacklist.index', [
            'blacklists' => $blacklists,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $blacklist = null;
        if ($id) {
            $blacklist = $this->databaseService->find(Blacklist::class, $id);
        }

        return view('admin.modules.blacklist.create_edit', [
            'blacklist' => $blacklist,
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->except('_token');

        if (isset($params['id'])) {
            $blacklist = $this->databaseService->find(Blacklist::class, $params['id']);
            $blacklist->update($params);
            $message = 'Blacklist entry updated successfully.';
        } else {
            $blacklist = Blacklist::create($params);
            $message = 'Blacklist entry created successfully.';
        }

        return redirect()
            ->route('admin.blacklists.edit', ['id' => $blacklist->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        $this->databaseService->destroy(Blacklist::class, $id);
        return redirect()
            ->route('admin.blacklists.index')
            ->with('status', 'Blacklist entry deleted successfully');
    }
}
