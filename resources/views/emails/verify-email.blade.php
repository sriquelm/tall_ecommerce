@component('mail::message')
# {{ __lang('emails.verify_email.subject') }}

{{ __lang('emails.verify_email.greeting') }}

{{ __lang('emails.verify_email.intro') }}

@component('mail::button', ['url' => $verificationUrl])
{{ __lang('emails.verify_email.action') }}
@endcomponent

{{ __lang('emails.verify_email.outro') }}

{{ __lang('emails.verify_email.trouble_text') }}

{{ $verificationUrl }}

{{ __lang('emails.verify_email.regards') }},<br>
{{ config('app.name') }}

@slot('subcopy')
{{ __lang('emails.verify_email.subcopy_text') }} {{ $verificationUrl }}
@endslot
@endcomponent