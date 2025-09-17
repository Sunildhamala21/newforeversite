<?php

namespace App\Livewire;

use Livewire\Component;

class CookieConsentBanner extends Component
{
    public function render()
    {
        if (! request()->hasCookie('cookie_consent')) {
            $showCookieBanner = 'true';
        } else {
            $showCookieBanner = 'false';
        }

        return view('livewire.cookie-consent-banner', [
            'showCookieBanner' => $showCookieBanner,
        ]);
    }
}
