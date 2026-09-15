<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Traits\SupportTicketManager;

class SupportTicketController extends Controller
{
    use SupportTicketManager;

    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('admin')->user();
            return $next($request);
        });

        $this->userType = 'admin';
        $this->column = 'admin_id';
    }

    public function tickets()
    {
        $pageTitle = 'Support Tickets';
        $items = SupportTicket::where('influencer_id','!=',1)->orderBy('id','desc')->with('user','influencer')->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'pageTitle'));
    }

    public function pendingTicket()
    {
        $pageTitle = 'Pending Tickets';
        $items = SupportTicket::where('influencer_id','!=',1)->whereIn('status', [0,2])->orderBy('id','desc')->with('user','influencer')->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'pageTitle'));
    }

    public function closedTicket()
    {
        $pageTitle = 'Closed Tickets';
        $items = SupportTicket::where('influencer_id','!=',1)->where('status',3)->orderBy('id','desc')->with('user','influencer')->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'pageTitle'));
    }

    public function answeredTicket()
    {
        $pageTitle = 'Answered Tickets';
        $items = SupportTicket::where('influencer_id','!=',1)->orderBy('id','desc')->with('user','influencer')->where('status',1)->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'pageTitle'));
    }

    public function influencerTickets()
    {
        $pageTitle = 'Support Tickets';
        $items = SupportTicket::where('influencer_id','!=',0)->orderBy('id','desc')->with('influencer')->paginate(getPaginate());
        return view('admin.support.influencer_tickets', compact('items', 'pageTitle'));
    }

    public function influencerPendingTicket()
    {
        $pageTitle = 'Pending Tickets';
        $items = SupportTicket::where('influencer_id','!=',0)->whereIn('status', [0,2])->orderBy('id','desc')->with('influencer')->paginate(getPaginate());
        return view('admin.support.influencer_tickets', compact('items', 'pageTitle'));
    }

    public function influencerClosedTicket()
    {
        $pageTitle = 'Closed Tickets';
        $items = SupportTicket::where('influencer_id','!=',0)->where('status',3)->orderBy('id','desc')->with('influencer')->paginate(getPaginate());
        return view('admin.support.influencer_tickets', compact('items', 'pageTitle'));
    }

    public function influencerAnsweredTicket()
    {
        $pageTitle = 'Answered Tickets';
        $items = SupportTicket::where('influencer_id','!=',0)->orderBy('id','desc')->with('influencer')->where('status',1)->paginate(getPaginate());
        return view('admin.support.influencer_tickets', compact('items', 'pageTitle'));
    }

    public function ticketReply($id)
    {
        $ticket = SupportTicket::with('user','influencer')->where('id', $id)->firstOrFail();
        $pageTitle = 'Reply Ticket';
        $messages = SupportMessage::with('ticket','admin','attachments')->where('support_ticket_id', $ticket->id)->orderBy('id','desc')->get();
        return view('admin.support.reply', compact('ticket', 'messages', 'pageTitle'));
    }

    public function ticketDelete($id)
    {
        $message = SupportMessage::findOrFail($id);
        $path = getFilePath('ticket');
        if ($message->attachments()->count() > 0) {
            foreach ($message->attachments as $attachment) {
                fileManager()->removeFile($path.'/'.$attachment->attachment);
                $attachment->delete();
            }
        }
        $message->delete();
        $notify[] = ['success', "Support ticket deleted successfully"];
        return back()->withNotify($notify);

    }

}
