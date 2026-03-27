<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailSetting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Mail\OrderPlacedMail;

class EmailSettingController extends Controller
{
    public function index()
    {
        $setting = EmailSetting::latest()->first();
        return view('admin.Email.email_settings', compact('setting'));
    }

    // Save settings
    public function store(Request $request)
    {
        EmailSetting::updateOrCreate(
            ['id' => $request->id],
            $request->all()
        );

        return back()->with('success', 'Settings saved!');
    }

    // Test mail
  /*  public function test()
    {
     EmailSetting::create([
            'mailer' => Config::get('mail.default'),
            'host' => Config::get('mail.mailers.smtp.host'),
            'port' => Config::get('mail.mailers.smtp.port'),
            'username' => Config::get('mail.mailers.smtp.username'),
            'password' => Config::get('mail.mailers.smtp.password'),
            'encryption' => Config::get('mail.mailers.smtp.encryption'),
            'from_email' => Config::get('mail.from.address'),
            'from_name' => Config::get('mail.from.name'),
        ]);
        $setting = EmailSetting::latest()->first();

        if ($setting) {
            Config::set('mail.default', $setting->mailer);
            Config::set('mail.mailers.smtp.host', $setting->host);
            Config::set('mail.mailers.smtp.port', $setting->port);
            Config::set('mail.mailers.smtp.username', $setting->username);
            Config::set('mail.mailers.smtp.password', $setting->password);
            Config::set('mail.mailers.smtp.encryption', $setting->encryption);

            Config::set('mail.from.address', $setting->from_email);
            Config::set('mail.from.name', $setting->from_name);
        }

        try {

            // ✅ REAL ORDER (BEST)
            $order = \App\Models\Order::with('items')->latest()->first();

            if (!$order) {
                return "No order found!";
            }

            Mail::to($order->email)->send(new OrderPlacedMail($order));

            return redirect("/admin/email-settings");

        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }*/
    public function test()
    {
        // Check if an EmailSetting already exists with the same 'from_email' or other unique field
        $existing = EmailSetting::where('from_email', Config::get('mail.from.address'))->first();

        if (!$existing) {
            // Only create a new record if it doesn't exist
            EmailSetting::create([
                'mailer'     => Config::get('mail.default'),
                'host'       => Config::get('mail.mailers.smtp.host'),
                'port'       => Config::get('mail.mailers.smtp.port'),
                'username'   => Config::get('mail.mailers.smtp.username'),
                'password'   => Config::get('mail.mailers.smtp.password'),
                'encryption' => Config::get('mail.mailers.smtp.encryption'),
                'from_email' => Config::get('mail.from.address'),
                'from_name'  => Config::get('mail.from.name'),
            ]);
        }

        // Get the latest (or existing) setting
        $setting = EmailSetting::latest()->first();

        if ($setting) {
            Config::set('mail.default', $setting->mailer);
            Config::set('mail.mailers.smtp.host', $setting->host);
            Config::set('mail.mailers.smtp.port', $setting->port);
            Config::set('mail.mailers.smtp.username', $setting->username);
            Config::set('mail.mailers.smtp.password', $setting->password);
            Config::set('mail.mailers.smtp.encryption', $setting->encryption);
            Config::set('mail.from.address', $setting->from_email);
            Config::set('mail.from.name', $setting->from_name);
        }

        try {
            $order = \App\Models\Order::with('items')->latest()->first();

            if (!$order) {
                return "No order found!";
            }

            Mail::to($order->email)->send(new OrderPlacedMail($order));

            return redirect("/admin/email-settings")
                ->with('success', 'Email sent successfully!');

        } catch (\Exception $e) {
            // Redirect to the email settings page on error
            return redirect('/admin/email-settings')
                ->with('error', 'Error sending email: ' . $e->getMessage());
        }
    }
}
