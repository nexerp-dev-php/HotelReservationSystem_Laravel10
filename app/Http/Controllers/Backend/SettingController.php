<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmtpSetting;

class SettingController extends Controller
{
    public function SmtpSetting() {
        $smtp = SmtpSetting::find(1);

        return view('backend.setting.smtp_setting', compact('smtp'));
    }

    public function StoreSmtpSetting(Request $request) {
        $smtp = SmtpSetting::find($request->id);

        $smtp->mailer = $request->mailer;
        $smtp->host = $request->host;
        $smtp->port = $request->port;
        $smtp->username = $request->username;
        $smtp->password = $request->password;
        $smtp->encryption = $request->encryption;
        $smtp->sender = $request->sender;
        $smtp->save();

        $notification = array(
            'message' => 'SMTP Setting Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
