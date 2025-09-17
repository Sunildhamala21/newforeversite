{{-- <div class="g-recaptcha" style="margin-bottom: 10px;" data-sitekey="{{ config('constants.google_recaptcha') }}">
</div> --}}
@push('scripts')
<script src="https://www.google.com/recaptcha/api.js?render={{ config('constants.recaptcha.sitekey') }}"></script>
{{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}
<script type="text/javascript">
    grecaptcha.ready(function () {
        grecaptcha.execute('{{ config("constants.recaptcha.sitekey") }}', {
                action: 'contact'
            }).then(function (token) {
            if (token) {
                document.getElementById('recaptcha').value = token;
            }
        });
    });
</script>
@endpush
