<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Models\Influencer;
use App\Models\InfluencerEducation;
use App\Models\InfluencerQualification;
use App\Models\Order;
use App\Models\Service;
use App\Models\SocialLink;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller {

    public function profile() {
        $pageTitle    = "Profile Setting";
        $influencer   = Influencer::where('id', authInfluencerId())->with('education', 'qualification', 'socialLink', 'categories')->firstOrFail();
        
        $languageData = config('languages');
        $countries    = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        $data['ongoing_orders']   = Order::inprogress()->where('influencer_id', $influencer->id)->count();
        $data['completed_orders'] = Order::completed()->where('influencer_id', $influencer->id)->count();
        $data['pending_orders']   = Order::pending()->where('influencer_id', $influencer->id)->count();
        $data['total_services']   = Service::where('status', 1)->where('influencer_id', $influencer->id)->count();

        return view($this->activeTemplate . 'influencer.profile_setting', compact('pageTitle', 'influencer', 'countries', 'data', 'languageData'));
    }

    public function submitProfile(Request $request) {
        $request->validate([
            'firstname'  => 'required|string',
            'lastname'   => 'required|string',
            'profession' => 'nullable|max:40|string',
            'summary'    => 'nullable|string',
            'image'      => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ], [
            'firstname.required' => 'First name field is required',
            'lastname.required'  => 'Last name field is required',
        ]);

        $influencer = authInfluencer();

        if ($request->hasFile('image')) {
            try {
                $old               = $influencer->image;
                $influencer->image = fileUploader($request->image, getFilePath('influencerProfile'), getFileSize('influencerProfile'), $old);
            } catch (\Exception$exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }

        }

        $influencer->firstname = $request->firstname;
        $influencer->lastname  = $request->lastname;

        $influencer->address = [
            'address' => $request->address,
            'state'   => $request->state,
            'zip'     => $request->zip,
            'country' => @$influencer->address->country,
            'city'    => $request->city,
        ];

        $influencer->profession = $request->profession;
        $influencer->summary    = nl2br($request->summary);

        if ($request->category) {
            $categoriesId = $request->category;
            $influencer->categories()->sync($categoriesId);
        }

        $influencer->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function submitSkill(Request $request) {

        $request->validate([
            "skills"   => "nullable|array",
            "skills.*" => "required|string",
        ]);

        $influencer         = authInfluencer();
        $influencer->skills = $request->skills;
        $influencer->save();

        $notify[] = ['success', 'Skill added successfully'];
        return back()->withNotify($notify);
    }

    public function addLanguage(Request $request) {

        $request->validate([
            'name'      => 'required|string|max:40',
            'listening' => 'required|in:Basic,Medium,Fluent',
            'speaking'  => 'required|in:Basic,Medium,Fluent',
            'writing'   => 'required|in:Basic,Medium,Fluent',
        ]);

        $influencer   = authInfluencer();
        $oldLanguages = authInfluencer()->languages ?? [];

        $addedLanguages = array_keys($oldLanguages);

        if (in_array(strtolower($request->name), array_map('strtolower', $addedLanguages))) {
            $notify[] = ['error', $request->name . ' already added'];
            return back()->withNotify($notify);
        }

        $newLanguage[$request->name] = [
            'listening' => $request->listening,
            'speaking'  => $request->speaking,
            'writing'   => $request->writing,
        ];

        $languages = array_merge($oldLanguages, $newLanguage);

        $influencer->languages = $languages;
        $influencer->save();

        $notify[] = ['success', 'Language added successfully'];
        return back()->withNotify($notify);
    }

    public function removeLanguage($language) {
        $influencer     = authInfluencer();
        $oldLanguages   = $influencer->languages ?? [];
        $addedLanguages = array_keys($oldLanguages);

        if (in_array($language, $addedLanguages)) {
            unset($oldLanguages[$language]);
        }

        $influencer->languages = $oldLanguages;
        $influencer->save();

        $notify[] = ['success', 'Language removed successfully'];
        return back()->withNotify($notify);
    }

    public function addSocialLink(Request $request, $id = 0) {
        $request->validate([
            'social_icon' => 'required',
            'url'         => 'required',
            'followers'   => 'required|string|max:40',
        ]);

        $influencerId = authInfluencerId();

        if ($id) {
            $social       = SocialLink::where('influencer_id', $influencerId)->findOrFail($id);
            $notification = 'Social link updated successfully';
        } else {
            $social                = new SocialLink();
            $social->influencer_id = $influencerId;
            $notification          = 'Social link added successfully';
        }

        $social->social_icon = $request->social_icon;
        $social->url         = $request->url;
        $social->followers   = $request->followers;
        $social->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function removeSocialLink($id) {
        $influencerId = authInfluencerId();
        SocialLink::where('influencer_id', $influencerId)->findOrFail($id)->delete();
        $notify[] = ['success', 'Social link removed successfully'];
        return back()->withNotify($notify);
    }

    public function changePassword() {
        $pageTitle = 'Change Password';
        return view($this->activeTemplate . 'influencer.password', compact('pageTitle'));
    }

    public function addEducation(Request $request, $id = 0) {

        $request->validate([
            'country'    => 'required|string',
            'institute'  => 'required|string',
            'degree'     => 'required|string',
            'start_year' => 'required|date_format:Y',
            'end_year'   => 'required|date_format:Y|after_or_equal:start_year',
        ]);

        $influencerId = authInfluencerId();

        if ($id) {
            $education    = InfluencerEducation::where('influencer_id', $influencerId)->findOrFail($id);
            $notification = 'Education updated successfully';
        } else {
            $education                = new InfluencerEducation();
            $education->influencer_id = $influencerId;
            $notification             = 'Education added successfully';
        }

        $education->country    = $request->country;
        $education->institute  = $request->institute;
        $education->degree     = $request->degree;
        $education->start_year = $request->start_year;
        $education->end_year   = $request->end_year;
        $education->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function removeEducation($id) {
        $influencerId = authInfluencerId();
        InfluencerEducation::where('influencer_id', $influencerId)->where('id', $id)->delete();
        $notify[] = ['success', 'Education remove successfully'];
        return back()->withNotify($notify);
    }

    public function addQualification(Request $request, $id = 0) {
        $request->validate([
            'certificate'  => 'required|string',
            'organization' => 'required|string',
            'summary'      => 'nullable|string',
            'year'         => 'required|date_format:Y',
        ]);

        $influencerId = authInfluencerId();

        if ($id) {
            $education    = InfluencerQualification::where('influencer_id', $influencerId)->findOrFail($id);
            $notification = 'Qualification updated successfully';
        } else {
            $education                = new InfluencerQualification();
            $education->influencer_id = $influencerId;
            $notification             = 'Qualification added successfully';
        }

        $education->certificate  = $request->certificate;
        $education->organization = $request->organization;
        $education->summary      = $request->summary;
        $education->year         = $request->year;
        $education->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function removeQualification($id) {
        $influencerId = authInfluencerId();
        InfluencerQualification::where('influencer_id', $influencerId)->where('id', $id)->delete();
        $notify[] = ['success', 'Qualification remove successfully'];
        return back()->withNotify($notify);
    }

    public function submitPassword(Request $request) {

        $passwordValidation = Password::min(6);
        $general            = gs();

        if ($general->secure_password) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', $passwordValidation],
        ]);

        $user = authInfluencer();

        if (Hash::check($request->current_password, $user->password)) {
            $password       = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = ['success', 'Password changes successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The password doesn\'t match!'];
            return back()->withNotify($notify);
        }

    }

}
