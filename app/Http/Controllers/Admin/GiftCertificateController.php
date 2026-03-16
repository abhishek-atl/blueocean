<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GiftCertificate;
use App\Services\DatabaseService;

class GiftCertificateController extends Controller
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
                'gift_code' => $request->get('search'),
                'recipient_email' => $request->get('search'),
                'sender_email' => $request->get('search'),
            ];
        }

        $giftCertificates = $this->databaseService->getByParams(GiftCertificate::class, $params);

        return view('admin.modules.gift_certificate.index', [
            'giftCertificates' => $giftCertificates,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $giftCertificate = null;
        if ($id) {
            $giftCertificate = $this->databaseService->find(GiftCertificate::class, $id);
        }

        return view('admin.modules.gift_certificate.create_edit', [
            'giftCertificate' => $giftCertificate,
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->except('_token');

        if (isset($params['id'])) {
            $giftCertificate = $this->databaseService->find(GiftCertificate::class, $params['id']);
            $giftCertificate->update($params);
            $message = 'Gift Certificate updated successfully.';
        } else {
            $giftCertificate = GiftCertificate::create($params);
            $message = 'Gift Certificate created successfully.';
        }

        return redirect()
            ->route('admin.gift_certificates.edit', ['id' => $giftCertificate->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        $this->databaseService->destroy(GiftCertificate::class, $id);
        return redirect()
            ->route('admin.gift_certificates.index')
            ->with('status', 'Gift Certificate deleted successfully');
    }
}
