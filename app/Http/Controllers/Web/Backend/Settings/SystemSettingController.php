<?php

namespace App\Http\Controllers\Web\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Exception;

class SystemSettingController extends Controller
{
    public function systemSetting()
    {
        $setting = SystemSetting::first();
        return view('backend.layout.setting.systemSetting', compact('setting'));
    }

    public function systemSettingUpdate(Request $request)
    {
        

        $request->validate([
            'system_title' => 'required|string|max:150',
            'system_short_title' => 'nullable|string|max:100',
            'tag_line' => 'nullable|string|max:255',
            'company_name' => 'required|string|max:150',
            'phone_code' => 'required|string|max:5',
            'phone_number' => 'required|string|max:15|regex:/^\d+$/',
            'email' => 'required|email|max:150',
            'copyright_text' => 'nullable|string|max:500',
        ]);

        $setting = SystemSetting::first();

        if (!$setting) {
            $setting = new SystemSetting();
        }

        if ($request->hasFile('logo')) {

            if ($setting->logo && file_exists(public_path('uploads/setting/system/' . $setting->logo))) {
                unlink(public_path('uploads/setting/system/' . $setting->logo));
            }

            $logo = $request->file('logo');
            $systemLogo = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('uploads/setting/system/'), $systemLogo);
            $setting->logo = $systemLogo;
        }
        if ($request->hasFile('minilogo')) {

            if ($setting->minilogo && file_exists(public_path('uploads/setting/system/' . $setting->minilogo))) {
                unlink(public_path('uploads/setting/system/' . $setting->minilogo));
            }

            $minilogo = $request->file('minilogo');
            $systemMiniLogo = time() . '_' . $minilogo->getClientOriginalName();
            $minilogo->move(public_path('uploads/setting/system/'), $systemMiniLogo);
            $setting->minilogo = $systemMiniLogo;
        }
        if ($request->hasFile('favicon')) {

            if ($setting->favicon && file_exists(public_path('uploads/setting/system/' . $setting->favicon))) {
                unlink(public_path('uploads/setting/system/' . $setting->favicon));
            }

            $favicon = $request->file('favicon');
            $systemFavicon = time() . '_' . $favicon->getClientOriginalName();
            $favicon->move(public_path('uploads/setting/system/'), $systemFavicon);
            $setting->favicon = $systemFavicon;
        }

        $setting->system_title       = $request->system_title;
        $setting->system_short_title = $request->system_short_title;
        $setting->tag_line           = $request->tag_line;
        $setting->company_name       = $request->company_name;
        $setting->phone_code         = $request->phone_code;
        $setting->phone_number       = $request->phone_number;
        $setting->email              = $request->email;
        $setting->copyright_text          = $request->copyright_text;

        $setting->save();

        return redirect()->back()->with('success', 'System settings updated successfully.');
    }

    public function adminSetting()
    {
        $setting = SystemSetting::first();
        return view('backend.layout.setting.adminSetting', compact('setting'));
    }

    public function adminSettingUpdate(Request $request)
    {

        $request->validate([
            'admin_title' => 'nullable|string|max:150',
            'admin_short_title' => 'nullable|string|max:100',
            'admin_copyright_text' => 'nullable|string|max:500',
        ]);

        $admin_setting = SystemSetting::first();
        if (!$admin_setting) {
            $admin_setting = new SystemSetting();
        }

        if ($request->hasFile('admin_logo')) {

            if ($admin_setting->admin_logo && file_exists(public_path('uploads/setting/admin/' . $admin_setting->admin_logo))) {
                unlink(public_path('uploads/setting/admin/' . $admin_setting->admin_logo));
            }

            $admin_logo = $request->file('admin_logo');
            $adminLogo = time() . '_' . $admin_logo->getClientOriginalName();
            $admin_logo->move(public_path('uploads/setting/admin/'), $adminLogo);
            $admin_setting->admin_logo = $adminLogo;
        }
        if ($request->hasFile('admin_mini_logo')) {

            if ($admin_setting->admin_mini_logo && file_exists(public_path('uploads/setting/admin/' . $admin_setting->admin_mini_logo))) {
                unlink(public_path('uploads/setting/admin/' . $admin_setting->admin_mini_logo));
            }

            $admin_mini_logo = $request->file('admin_mini_logo');
            $adminMiniLogo = time() . '_' . $admin_mini_logo->getClientOriginalName();
            $admin_mini_logo->move(public_path('uploads/setting/admin/'), $adminMiniLogo);
            $admin_setting->admin_mini_logo = $adminMiniLogo;
        }
        if ($request->hasFile('admin_favicon')) {

            if ($admin_setting->admin_favicon && file_exists(public_path('uploads/setting/admin/' . $admin_setting->admin_favicon))) {
                unlink(public_path('uploads/setting/admin/' . $admin_setting->admin_favicon));
            }

            $admin_favicon = $request->file('admin_favicon');
            $adminFavicon = time() . '_' . $admin_favicon->getClientOriginalName();
            $admin_favicon->move(public_path('uploads/setting/admin/'), $adminFavicon);
            $admin_setting->admin_favicon = $adminFavicon;
        }



        $admin_setting->admin_title = $request->admin_title;
        $admin_setting->admin_short_title = $request->admin_short_title;
        $admin_setting->admin_copyright_text = $request->admin_copyright_text;
        $admin_setting->save();

        return redirect()->back()->with('success', 'Admin settings updated successfully.');
    }



    public function mail()
    {

        return view('backend.layout.setting.mail');
    }


    public function mailstore(Request $request)
    {
        $request->validate([
            'mail_mailer' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|string',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|string',
            'mail_from_address' => 'required|string',
        ]);
        try {
            $envContent = File::get(base_path('.env'));
            $lineBreak = "\n";
            $envContent = preg_replace([
                '/MAIL_MAILER=(.*)\s/',
                '/MAIL_HOST=(.*)\s/',
                '/MAIL_PORT=(.*)\s/',
                '/MAIL_USERNAME=(.*)\s/',
                '/MAIL_PASSWORD=(.*)\s/',
                '/MAIL_ENCRYPTION=(.*)\s/',
                '/MAIL_FROM_ADDRESS=(.*)\s/',
            ], [
                'MAIL_MAILER=' . $request->mail_mailer . $lineBreak,
                'MAIL_HOST=' . $request->mail_host . $lineBreak,
                'MAIL_PORT=' . $request->mail_port . $lineBreak,
                'MAIL_USERNAME=' . $request->mail_username . $lineBreak,
                'MAIL_PASSWORD=' . $request->mail_password . $lineBreak,
                'MAIL_ENCRYPTION=' . $request->mail_encryption . $lineBreak,
                'MAIL_FROM_ADDRESS=' . '"' . $request->mail_from_address . '"' . $lineBreak,
            ], $envContent);

            if ($envContent !== null) {
                File::put(base_path('.env'), $envContent);
            }
            return back()->with('success', 'Updated successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update');
        }

        return redirect()->back();
    }
}
