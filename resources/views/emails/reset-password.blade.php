@component('mail::message')
# {{ __lang('emails.reset_password.subject') }}

{{ __lang('emails.reset_password.greeting') }}

{{ __lang('emails.reset_password.intro') }}

@component('mail::button', ['url' => $resetUrl])
{{ __lang('emails.reset_password.action') }}
@endcomponent

{{ str_replace(':count', $count, __lang('emails.reset_password.outro')) }}

{{ __lang('emails.reset_password.trouble_text') }}

{{ $resetUrl }}

{{ __lang('emails.reset_password.regards') }},<br>
{{ config('app.name') }}
@endcomponent