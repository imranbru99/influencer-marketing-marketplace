<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderConversation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManageOrderController extends Controller
{

    public function index()
    {
        $this->pageTitle = 'All Orders';
        return $this->filterOrder();
    }

    public function pending()
    {
        $this->pageTitle = 'Pending Orders';
        return $this->filterOrder('pending');
    }

    public function inprogress()
    {
        $this->pageTitle = 'Inprogress Orders';
        return $this->filterOrder('inprogress');
    }

    public function jobDone()
    {
        $this->pageTitle = 'Job Done Orders';
        return $this->filterOrder('JobDone');
    }

    public function completed()
    {
        $this->pageTitle = 'Completed Orders';
        return $this->filterOrder('completed');
    }

    public function reported()
    {
        $this->pageTitle = 'Reported Orders';
        return $this->filterOrder('reported');
    }

    public function cancelled()
    {
        $this->pageTitle = 'Cancelled Orders';
        return $this->filterOrder('cancelled');
    }

    protected function filterOrder($scope = null)
    {
        $orders = Order::paymentCompleted();

        if ($scope) {
            $orders = $orders->$scope();
        }

        $request = request();

        if ($request->search) {
            $search = request()->search;
            $orders = $orders->where(function ($q) use ($search) {
                $q->where('order_no', $search)->orWhereHas('user', function ($user) use ($search) {
                    $user->where('username', $search);
                })->orWhereHas('influencer', function ($influencer) use ($search) {
                    $influencer->where('username', $search);
                });
            });
        }

        $orders = $orders->with('user', 'influencer')->latest()->paginate(getPaginate());

        $pageTitle = $this->pageTitle;

        return view('admin.order.list', compact('pageTitle', 'orders'));
    }

    public function detail($id)
    {
        $pageTitle     = 'Order Detail';
        $order         = Order::with('user', 'influencer')->findOrFail($id);
        $conversations = OrderConversation::where('order_id', $order->id)->take(10)->orderBy('id', 'desc')->get();
        return view('admin.order.detail', compact('pageTitle', 'order', 'conversations'));
    }

    public function takeAction($id, $status)
    {

        $order = Order::with('user', 'influencer', 'service')->findOrFail($id);

        if ($status == 1) {
            $this->inFavourOfInfluencer($order);
        }

        if ($status == 6) {
            $this->inFavourOfClient($order);
        }

        $order->status = $status;
        $order->save();

        $notify[] = ['success', 'Action taken successfully'];
        return back()->withNotify($notify);
    }

    protected function inFavourOfClient($order)
    {
        $influencer = $order->influencer;
        $user       = $order->user;

        $user->balance += $order->amount;
        $user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $order->amount;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type     = '+';
        $transaction->details      = 'Payment refunded due to incomplete service';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'payment_refunded';
        $transaction->save();

        $general = gs();

        notify($user, 'ORDER_REFUND', [
            'site_currency' => $general->cur_text,
            'title'         => @$order->title,
            'amount'        => showAmount($order->amount),
            'post_balance'  => showAmount($user->balance),
            'order_no'      => $order->order_no,
        ]);

        notify($influencer, 'ORDER_REJECTED', [
            'site_currency' => $general->cur_text,
            'title'         => @$order->title,
            'amount'        => showAmount($order->amount),
            'post_balance'  => showAmount($influencer->balance),
            'order_no'      => $order->order_no,
        ]);
    }

    protected function inFavourOfInfluencer($order)
    {

        $influencer = $order->influencer;
        $user       = $order->user;

        $influencer->balance += $order->amount;
        $influencer->increment('completed_order');
        $influencer->save();

        $transaction                = new Transaction();
        $transaction->influencer_id = $influencer->id;
        $transaction->amount        = $order->amount;
        $transaction->post_balance  = $influencer->balance;
        $transaction->trx_type      = '+';
        $transaction->details       = 'Payment received for completing service order';
        $transaction->trx           = getTrx();
        $transaction->remark        = 'order_payment';
        $transaction->save();

        $general = gs();

        $shortCodes = [
            'title'         => $order->title,
            'site_currency' => $general->cur_text,
            'amount'        => showAmount($order->amount),
            'order_no'      => $order->order_no,
        ];

        notify($influencer, 'ORDER_COMPLETED_INFLUENCER', $shortCodes);
        notify($user, 'ORDER_COMPLETED_CLIENT', $shortCodes);
    }

    public function download($attachment)
    {
        $path = getFilePath('conversation');
        $file = $path . '/' . $attachment;
        return response()->download($file);
    }

    public function conversationStore(Request $request, $id)
    {
        $order     = Order::find($id);
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $conversation                = new OrderConversation();
        $conversation->order_id      = $order->id;
        $conversation->user_id       = $order->user_id;
        $conversation->influencer_id = $order->influencer_id;
        $conversation->admin_id      = auth()->guard('admin')->id();
        $conversation->sender        = 'admin';
        $conversation->message       = $request->message;
        $conversation->save();

        return view('admin.order.last_message', compact('conversation'));
    }

    public function conversationMessage(Request $request)
    {
        $conversations = OrderConversation::where('order_id', $request->order_id)->take($request->messageCount)->orderBy('id', 'desc')->get();
        return view('admin.order.conversation', compact('conversations'));
    }
}
