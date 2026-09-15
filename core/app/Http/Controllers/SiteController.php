<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\Frontend;
use App\Models\Hiring;
use App\Models\HiringConversation;
use App\Models\Influencer;
use App\Models\InfluencerCategory;
use App\Models\Language;
use App\Models\Order;
use App\Models\OrderConversation;
use App\Models\Page;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceTag;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SiteController extends Controller {

    public function index() {
        $pageTitle = 'Home';
        $sections  = Page::where('tempname', $this->activeTemplate)->where('slug', '/')->first();
        $tags      = Tag::withCount('serviceTag')->orderBy('service_tag_count', 'desc')->take(6)->get();
        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections', 'tags'));
    }

    public function pages($slug) {
        $page      = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections  = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }

    public function contact() {
        $pageTitle = "Contact Us";
        $sections  = Page::where('tempname', $this->activeTemplate)->where('slug', 'contact')->first();
        return view($this->activeTemplate . 'contact', compact('pageTitle', 'sections'));
    }

    public function login() {
        $pageTitle    = "Login";
        $loginContent = Frontend::where('data_keys', 'login.content')->first();
        return view($this->activeTemplate . 'login', compact('pageTitle', 'loginContent'));
    }

    public function contactSubmit(Request $request) {

        $this->validate($request, [
            'name'    => 'required',
            'email'   => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket           = new SupportTicket();
        $ticket->user_id  = auth()->id() ?? 0;

        if(!auth()->id()){
            $ticket->influencer_id = authInfluencerId()??0;
        }

        $ticket->name     = $request->name;
        $ticket->email    = $request->email;
        $ticket->priority = 2;

        $ticket->ticket     = $random;
        $ticket->subject    = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status     = 0;
        $ticket->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title     = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message                    = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message           = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        if(auth()->user()){
            $view = 'ticket.view';
        }elseif(authInfluencer()){
            $view = 'influencer.ticket.view';
        }else{
            $view = 'ticket.view';
        }

        return to_route($view, [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id) {
        $policy    = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null) {
        $language = Language::where('code', $lang)->first();

        if (!$language) {
            $lang = 'en';
        }

        session()->put('lang', $lang);
        return back();
    }

    public function cookieAccept() {
        $general = gs();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);
        return back();
    }

    public function cookiePolicy() {
        $pageTitle = 'Cookie Policy';
        $cookie    = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null) {
        $imgWidth  = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text      = $imgWidth . '×' . $imgHeight;
        $fontFile  = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize  = round(($imgWidth - 50) / 8);

        if ($fontSize <= 9) {
            $fontSize = 9;
        }

        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox    = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance() {
        $pageTitle = 'Maintenance Mode';
        $general   = gs();

        if ($general->maintenance_mode == 0) {
            return to_route('home');
        }

        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view($this->activeTemplate . 'maintenance', compact('pageTitle', 'maintenance'));
    }

    public function services(Request $request) {
        $pageTitle   = 'Services';
        $services    = $this->getServices($request);
        $allCategory = Category::active()->orderBy('name')->get();
        $sections    = Page::where('tempname', $this->activeTemplate)->where('slug', 'service')->first();
        return view($this->activeTemplate . 'service.list', compact('services', 'pageTitle', 'allCategory', 'sections'));
    }

    public function serviceByTag(Request $request, $id, $name) {
        $pageTitle = 'Service - ' . $name;

        $serviceId = collect(ServiceTag::where('tag_id', $id)->pluck('service_id'))->toArray();
        $orders    = array_map(function ($item) {
            return "id = {$item} desc";
        }, $serviceId);
        $rawOrder    = implode(', ', $orders);
        $services    = Service::approved()->whereIn('id', $serviceId)->orderByRaw($rawOrder)->with('influencer', 'category')->paginate(getPaginate());
        $allCategory = Category::active()->orderBy('name')->get();

        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'service')->first();
        return view($this->activeTemplate . 'service.list', compact('services', 'pageTitle', 'id', 'sections', 'allCategory'));
    }

    public function filterService(Request $request) {
        $services = $this->getServices($request);
        return view($this->activeTemplate . 'service.filtered', compact('services'));
    }

    protected function getServices($request) {

        $services = Service::approved();

        if ($request->categories) {
            $services = $services->whereIn('category_id', $request->categories);
        }

        if ($request->tagId) {
            $serviceId = collect(ServiceTag::where('tag_id', $request->tagId)->pluck('service_id'))->toArray();
            $services  = $services->whereIn('id', $serviceId);
        }

        if ($request->min && $request->max) {
            $min      = intval($request->min);
            $max      = intval($request->max);
            $services = $services->whereBetween('price', [$min, $max]);
        }

        if ($request->sort) {
            $sort     = explode('_', $request->sort);
            $services = $services->orderBy(@$sort[0], @$sort[1]);
        }

        if ($request->search) {
            $search   = $request->search;
            $services = $services->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')->orWhere('description', 'LIKE', '%' . $search . '%');
            })->orWhereHas('category', function ($category) use ($search) {
                $category->where('name', 'like', "%$search%");
            });
        }

        return $services->latest()->with('influencer', 'category')->paginate(getPaginate(15));
    }

    public function serviceDetails($slug, $id, $orderId = 0) {

        if ($orderId) {
            $order = Order::completed()->where('user_id', auth()->id())->where('service_id', $id)->findOrFail($orderId);
        }

        $service         = Service::approved()->where('id', $id)->with('category', 'influencer.socialLink', 'gallery', 'reviews.user', 'tags')->firstOrFail();
        $pageTitle       = 'Service Details';
        $customPageTitle = $service->title;

        $anotherServices = Service::approved()->where('influencer_id', $service->influencer->id)->where('id', '!=', $id)->with('influencer')->latest()->take(4)->get();

        $seoContents['keywords']           = $service->meta_keywords ?? [];
        $seoContents['social_title']       = $service->title;
        $seoContents['description']        = strLimit(strip_tags($service->description), 150);
        $seoContents['social_description'] = strLimit(strip_tags($service->description), 150);
        $seoContents['image']              = getImage(getFilePath('service') . '/' . $service->image, getFileSize('service'));
        $seoContents['image_size']         = getFileSize('service');

        return view($this->activeTemplate . 'service.detail', compact('service', 'pageTitle', 'anotherServices', 'seoContents', 'orderId', 'customPageTitle'));
    }

    public function influencerProfile($name, $id) {
        $influencer              = Influencer::active()->with('education', 'qualification', 'services.category')->findOrFail($id);
        $pageTitle               = 'Influencer Profile';
        $reviews                 = Review::where('influencer_id', $id)->where('order_id', 0)->with('user')->latest()->paginate(10);

        $data['ongoing_job']   = Order::inprogress()->where('influencer_id', $id)->count() + Hiring::inprogress()->where('influencer_id', $id)->count();
        $data['completed_job'] = Order::completed()->where('influencer_id', $id)->count() + Hiring::completed()->where('influencer_id', $id)->count();;
        $data['queue_job']     = Order::whereIn('status', [2, 3])->where('influencer_id', $id)->count() + Hiring::whereIn('status', [2, 3])->where('influencer_id', $id)->count();
        $data['pending_job']   = Order::pending()->where('influencer_id', $id)->count() + Hiring::pending()->where('influencer_id', $id)->count();

        return view($this->activeTemplate . 'influencer.profile', compact('pageTitle', 'influencer', 'data', 'reviews'));
    }

    public function influencers(Request $request) {
        $pageTitle   = 'Influencers';
        $countries   = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $influencers = $this->getInfluencer($request);
        $sections    = Page::where('tempname', $this->activeTemplate)->where('slug', 'influencers')->first();
        $allCategory = Category::active()->orderBy('name')->get();

        return view($this->activeTemplate . 'influencers', compact('influencers', 'pageTitle', 'sections', 'countries', 'allCategory'));
    }

    public function influencerByCategory(Request $request, $id, $name) {

        $pageTitle    = 'Category - ' . $name;
        $countries    = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $influencerId = InfluencerCategory::where('category_id', $id)->select('influencer_id')->get();
        $influencers  = Influencer::active()->whereIn('id', $influencerId)->with('socialLink')->latest()->paginate(getPaginate(15));
        $sections     = Page::where('tempname', $this->activeTemplate)->where('slug', 'influencers')->first();
        return view($this->activeTemplate . 'influencers', compact('influencers', 'pageTitle', 'sections', 'countries', 'id'));
    }

    public function filterInfluencer(Request $request) {
        $influencers = $this->getInfluencer($request);
        return view($this->activeTemplate . 'filtered_influencer', compact('influencers'));
    }

    protected function getInfluencer($request) {
        $influencers = Influencer::active();

        if ($request->categories) {
            $influencerId = InfluencerCategory::whereIn('category_id', $request->categories)->select('influencer_id')->get();
            $influencers  = $influencers->whereIn('id', $influencerId);
        }

        if ($request->categoryId) {
            $influencerId = InfluencerCategory::where('category_id', $request->categoryId)->select('influencer_id')->get();
            $influencers  = $influencers->whereIn('id', $influencerId);
        }

        if ($request->search) {
            $search      = $request->search;
            $influencers = $influencers->where(function ($query) use ($search) {
                $query->where('firstname', "LIKE", "%$search%")
                    ->orWhere('lastname', 'LIKE', "%%$search")
                    ->orWhere('username', 'LIKE', "%$search%")
                    ->orWhere('profession', 'LIKE', "%$search%");
            });
        }

        if ($request->country) {
            $influencers = $influencers->whereJsonContains('address', ['country' => $request->country]);
        }

        if ($request->rating) {
            $influencers = $influencers->where('rating', '>=', $request->rating);
        }

        if ($request->sort == 'top_rated') {
            $influencers = $influencers->where('completed_order', '>', 0)->orderBy('completed_order', 'desc');
        }

        if ($request->completedJob) {
            $influencers = $influencers->where('completed_order', '>', $request->completedJob)->orderBy('completed_order', 'desc');
        }

        return $influencers->with('socialLink')->orderBy('completed_order', 'desc')->paginate(getPaginate(18));
    }

    public function attachmentDownload($attachment, $conversation_id, $type) {
        if($type == 'order'){
            OrderConversation::where('id',$conversation_id)->firstOrFail();
        }elseif($type == 'hiring'){
            HiringConversation::where('id',$conversation_id)->firstOrFail();
        }else{
            ConversationMessage::where('id',$conversation_id)->firstOrFail();
        }
        $path = getFilePath('conversation');
        $file = $path . '/' . $attachment;
        return response()->download($file);
    }

    public function campaignBrief() {
        $pageTitle  = 'AI Campaign Brief & Proposal Generator';
        $categories = Category::active()->orderBy('name')->get();
        return view($this->activeTemplate . 'campaign_brief', compact('pageTitle', 'categories'));
    }

    public function roiCalculator() {
        $pageTitle  = 'Influencer Rate & ROI Calculator';
        $categories = Category::active()->orderBy('name')->get();
        return view($this->activeTemplate . 'roi_calculator', compact('pageTitle', 'categories'));
    }
}

