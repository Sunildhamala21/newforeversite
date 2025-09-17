<div class="fixed bottom-0 left-0 right-0 py-3 text-sm text-gray-600 bg-accent/90 z-100" x-cloak x-data="{ show: {{ $showCookieBanner }} }"
    x-show="show">
    <div class="container relative flex items-center justify-between gap-3">
        <div>
            We use cookies to enhance your experience on our website. By continuing to browse, you agree to our use of
            cookies.
            <button class="px-3 py-1 ml-4 text-xs text-white rounded bg-primary"
                x-on:click="document.cookie=`cookie_consent=1;path=/;max-age=31556952`;show=false">Accept</button>
        </div>
        <button class="cursor-pointer size-10" x-on:click="document.cookie=`cookie_consent=0;path=/`;show=false">
            <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor">
                <path
                    d="M168.49,104.49,145,128l23.52,23.51a12,12,0,0,1-17,17L128,145l-23.51,23.52a12,12,0,0,1-17-17L111,128,87.51,104.49a12,12,0,0,1,17-17L128,111l23.51-23.52a12,12,0,0,1,17,17ZM236,128A108,108,0,1,1,128,20,108.12,108.12,0,0,1,236,128Zm-24,0a84,84,0,1,0-84,84A84.09,84.09,0,0,0,212,128Z">
                </path>
            </svg>
        </button>
    </div>
</div>
