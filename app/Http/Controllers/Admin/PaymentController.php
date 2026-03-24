<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use Illuminate\Http\Request;

use App\Models\Payment;
use App\Models\Booking;

use App\Services\DatabaseService;

class PaymentController extends Controller
{
    protected $databaseService;

    public function __construct(
        DatabaseService $databaseService
    ) {
        $this->databaseService = $databaseService;
    }

    public function index(Request $request)
    {
        $params = [];
        $params['sort_by'] = $request->get('sort_by', 'id');
        $params['sort_order'] = $request->get('sort_order', 'desc');

        $params['with'] = ['booking'];

        if (null != $request->get('search')) {
            $params['like'] = ['charge_id' => $request->get('search')];
        }

        $payments = $this->databaseService->getByParams(Payment::class, $params);

        return view('admin.modules.payment.index', [
            'payments' => $payments,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $payment = null;
        if ($id) {
            $payment = $this->databaseService->find(Payment::class, $id);
            $payment->load(['booking']);
        }

        $bookings = $this->databaseService->getByParams(Booking::class, ['all' => true]);

        return view('admin.modules.payment.create_edit', [
            'payment' => $payment,
            'bookings' => $bookings,
        ]);
    }

    public function store(StorePaymentRequest $request)
    {
        $params = $request->except('_token');

        if (isset($params['id'])) {
            $payment = $this->databaseService->find(Payment::class, $params['id']);
            $payment->update($params);
            $message = 'Payment updated successfully.';
        } else {
            $payment = Payment::create($params);
            $message = 'Payment added successfully.';
        }

        if ($request->input('btnStay') === 'Save and stay') {
            return redirect()
                ->route('admin.payments.edit', ['id' => $payment->id])
                ->with('status', $message);
        } else {
            return redirect()
                ->route('admin.payments.index')
                ->with('status', $message);
        }
    }

    public function destroy($id)
    {
        $payment = $this->databaseService->find(Payment::class, $id);
        $payment->delete();

        return redirect()
            ->back()
            ->with('status', 'Payment deleted successfully.');
    }
}
