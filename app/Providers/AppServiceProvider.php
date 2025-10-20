<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SmtpSetting;
use Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //SMTP override with database value
        try {
            if(\Schema::hasTable('smtp_settings')) {
                $smtpSetting = SmtpSetting::first();

                if($smtpSetting) {
                    Config::set('mail.mailers.smtp', [
                        'transport' => $smtpSetting->mailer,
                        'host' => $smtpSetting->host,
                        'port' => $smtpSetting->port,
                        'username' => $smtpSetting->username,
                        'password' => $smtpSetting->password,
                        'encryption' => $smtpSetting->encryption,
                    ]);

                    Config::set('mail.default', 'smtp');

                    Config::set('mail.from', [
                        'address' => $smtpSetting->sender,
                        'name' => 'Nex>ERP',
                    ]);                    
                }
            }
        } catch (\Exception $e) {
            // Log or ignore during early boot
        }        
    }
}