@component('mail::message')
{{ __lang('You have been invited to join the :team team!', ['team' => $invitation->team->name]) }}

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
{{ __lang('If you do not have an account, you may create one by clicking the button below. After creating an account, you may click the invitation acceptance button in this email to accept the team invitation:') }}

@component('mail::button', ['url' => route('register')])
{{ __lang('Create Account') }}
@endcomponent

{{ __lang('If you already have an account, you may accept this invitation by clicking the button below:') }}

@else
{{ __lang('You may accept this invitation by clicking the button below:') }}
@endif


@component('mail::button', ['url' => $acceptUrl])
{{ __lang('Accept Invitation') }}
@endcomponent

{{ __lang('If you did not expect to receive an invitation to this team, you may discard this email.') }}
@endcomponent
