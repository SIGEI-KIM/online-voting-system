@component('mail::message')
# Your Vote Has Been Cast

Thank you for participating in the **{{ $election }}**.

You have successfully voted for **{{ $candidate }}**.

Your vote has been recorded.

@component('mail::button', ['url' => config('app.url')])
Go to Voting Site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent