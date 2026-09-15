<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Influencer\Auth')->name('influencer.')->group(function () {

    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->name('logout');
    });

    Route::controller('RegisterController')->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register')->middleware('registration.status');
        Route::post('check-mail', 'checkUser')->name('checkUser');
    });

    Route::controller('ForgotPasswordController')->group(function () {
        Route::get('password/reset', 'showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'sendResetCodeEmail')->name('password.email');
        Route::get('password/code-verify', 'codeVerify')->name('password.code.verify');
        Route::post('password/verify-code', 'verifyCode')->name('password.verify.code');
    });
    Route::controller('ResetPasswordController')->group(function () {
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });
});

Route::middleware('influencer')->name('influencer.')->group(function () {
    //authorization
    Route::namespace('Influencer')->controller('AuthorizationController')->group(function () {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'emailVerification')->name('verify.email');
        Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify-g2fa', 'g2faVerification')->name('go2fa.verify');
    });

    Route::middleware(['influencer.check'])->group(function () {

        Route::get('influencer-data', 'Influencer\InfluencerController@influencerData')->name('data');
        Route::post('influencer-data-submit', 'Influencer\InfluencerController@influencerDataSubmit')->name('data.submit');

        Route::middleware('influencer.registration.complete')->namespace('Influencer')->group(function () {

            Route::controller('InfluencerController')->group(function () {
                Route::get('dashboard', 'home')->name('home');

                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                //KYC
                Route::get('kyc-form', 'kycForm')->name('kyc.form');
                Route::get('kyc-data', 'kycData')->name('kyc.data');
                Route::post('kyc-submit', 'kycSubmit')->name('kyc.submit');

                Route::get('transactions', 'transactions')->name('transactions');

                Route::get('attachment-download/{fil_hash}', 'attachmentDownload')->name('attachment.download');
            });

            //Profile setting
            Route::controller('ProfileController')->group(function () {
                Route::get('profile-setting', 'profile')->name('profile.setting');
                Route::post('profile-setting', 'submitProfile');
                Route::post('submit-skill', 'submitSkill')->name('skill');

                Route::post('add-language/{id?}', 'addLanguage')->name('language.add');
                Route::post('remove-language/{language}', 'removeLanguage')->name('language.remove');

                Route::post('add-education/{id?}', 'addEducation')->name('add.education');
                Route::post('remove-education/{id}', 'removeEducation')->name('remove.education');

                Route::post('add-qualification/{id?}', 'addQualification')->name('add.qualification');
                Route::post('remove-qualification/{id}', 'removeQualification')->name('remove.qualification');

                Route::post('add/socialLink/{id?}', 'addSocialLink')->name('add.socialLink');
                Route::post('remove-socialLink/{id}', 'removeSocialLink')->name('remove.socialLink');

                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
            });

            // Withdraw
            Route::controller('WithdrawController')->prefix('withdraw')->name('withdraw')->group(function () {
                Route::middleware('kyc')->group(function () {
                    Route::get('/', 'withdrawMoney');
                    Route::post('/', 'withdrawStore')->name('.money');
                    Route::get('preview', 'withdrawPreview')->name('.preview');
                    Route::post('preview', 'withdrawSubmit')->name('.submit');
                });
                Route::get('history', 'withdrawLog')->name('.history');
            });

            // Service
            Route::controller('ServiceController')->prefix('service')->name('service.')->group(function () {

                Route::middleware('kyc')->group(function () {
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store/{id?}', 'store')->name('store');
                    Route::get('/edit/{id}', 'edit')->name('edit');
                });

                Route::get('/all', 'all')->name('all');
                Route::get('/pending', 'pending')->name('pending');
                Route::get('/approved', 'approved')->name('approved');
                Route::get('/rejected', 'rejected')->name('rejected');
                Route::get('/orders/{id}', 'orders')->name('orders');
            });

            Route::controller('ConversationController')->prefix('conversation')->name('conversation.')->group(function () {
                Route::middleware('kyc')->group(function () {
                    Route::get('/index', 'index')->name('index');
                    Route::post('/store/{id}', 'store')->name('store');
                    Route::get('/view/{id}', 'view')->name('view');
                    Route::get('/message', 'message')->name('message');
                });

            });

            Route::controller('HiringController')->prefix('hirings')->name('hiring.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/pending', 'pending')->name('pending');
                Route::get('/inprogress', 'inprogress')->name('inprogress');
                Route::get('/job-done', 'jobDone')->name('jobDone');
                Route::get('/completed', 'completed')->name('completed');
                Route::get('/reported', 'reported')->name('reported');
                Route::get('/cancelled', 'cancelled')->name('cancelled');

                Route::middleware('kyc')->group(function () {
                    Route::get('/detail/{id}','detail')->name('detail');
                    Route::post('accept/status/{id}', 'acceptStatus')->name('accept.status');
                    Route::post('jobDone/status/{id}', 'jobDoneStatus')->name('jobDone.status');
                    Route::post('cancel/status/{id}', 'cancelStatus')->name('cancel.status');

                    Route::get('/conversation/{id}', 'conversation')->name('conversation.view');
                    Route::post('/conversation/store/{id}', 'conversationStore')->name('conversation.store');
                    Route::get('/message', 'conversationMessage')->name('conversation.message');
                });

            });

            Route::controller('OrderController')->prefix('orders')->name('service.order.')->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::get('/pending', 'pending')->name('pending');
                Route::get('/inprogress', 'inprogress')->name('inprogress');
                Route::get('/job-done', 'jobDone')->name('jobDone');
                Route::get('/completed', 'completed')->name('completed');
                Route::get('/reported', 'reported')->name('reported');
                Route::get('/cancelled', 'cancelled')->name('cancelled');

                Route::middleware('kyc')->group(function () {
                    Route::get('/detail/{id}','detail')->name('detail');

                    Route::post('accept/status/{id}', 'orderAccept')->name('accept.status');
                    Route::post('jobDone/status/{id}', 'jobDoneStatus')->name('jobDone.status');
                    Route::post('cancel/status/{id}', 'cancelOrder')->name('cancel.status');

                    Route::get('/conversation/{id}', 'conversation')->name('conversation.view');
                    Route::post('/conversation/store/{id}', 'conversationStore')->name('conversation.store');
                    Route::get('/message', 'conversationMessage')->name('conversation.message');
                });
            });

            Route::controller('TicketController')->prefix('ticket')->group(function () {
                Route::get('all', 'supportTicket')->name('ticket');
                Route::get('new', 'openSupportTicket')->name('ticket.open');
                Route::post('create', 'storeSupportTicket')->name('ticket.store');
                Route::get('view/{ticket}', 'viewTicket')->name('ticket.view');
                Route::post('reply/{ticket}', 'replyTicket')->name('ticket.reply');
                Route::post('close/{ticket}', 'closeTicket')->name('ticket.close');
                Route::get('download/{ticket}', 'ticketDownload')->name('ticket.download');
            });
        });
    });
});
