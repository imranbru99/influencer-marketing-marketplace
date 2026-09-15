<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Traits\SupportTicketManager;

class TicketController extends Controller
{
    use SupportTicketManager;

    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
        $this->layout = 'frontend';


        $this->middleware(function ($request, $next) {
            $this->user = authInfluencer();
            if ($this->user) {
                $this->layout = 'master';
            }
            return $next($request);
        });

        $this->redirectLink = 'influencer.ticket.view';
        $this->userType     = 'influencer';
        $this->column       = 'influencer_id';
    }
}
