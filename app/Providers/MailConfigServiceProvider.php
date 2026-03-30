<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\EmailSetting;
class   MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
   /* public function boot(): void
    {
        try {
            $setting = EmailSetting::first();

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

        } catch (\Exception $e) {
            // Avoid crash if table not created yet
        }
    }*/
}
