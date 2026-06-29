<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FAQ;
use App\Services\DatabaseService;

class FAQController extends Controller
{
    protected $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    public function index(Request $request)
    {
        $params = [];
        $params['sort_by'] = $request->get('sort_by', 'display_order');
        $params['sort_order'] = $request->get('sort_order', 'asc');

        if (null != $request->get('search')) {
            $params['like'] = [
                'question' => $request->get('search'),
                'answer' => $request->get('search'),
            ];
        }

        $faqs = $this->databaseService->getByParams(FAQ::class, $params);

        return view('admin.modules.faq.index', [
            'faqs' => $faqs,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $faq = null;
        if ($id) {
            $faq = $this->databaseService->find(FAQ::class, $id);
        }

        return view('admin.modules.faq.create_edit', [
            'faq' => $faq,
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->except('_token');

        if (isset($params['id'])) {
            $faq = $this->databaseService->find(FAQ::class, $params['id']);
            $faq->update($params);
            $message = 'FAQ updated successfully.';
        } else {
            $faq = FAQ::create($params);
            $message = 'FAQ created successfully.';
        }

        return redirect()
            ->route('admin.faqs.edit', ['id' => $faq->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        $this->databaseService->destroy(FAQ::class, $id);
        return redirect()
            ->route('admin.faqs.index')
            ->with('status', 'FAQ deleted successfully');
    }
}
