@component('mail::message')
# Application Status Update

Dear {{ $application->full_name }},

Your application for the **{{ $application->election->title }}** election has been reviewed.

@if ($application->status === 'approved')
    🎉 **Congratulations! Your Election Application Has Been Approved** 🎉

    We are thrilled to inform you that your application for the **{{ $application->election->title }}** election has been successfully approved! You are now a confirmed candidate.

    We wish you the best of luck in your campaign. Further instructions and important dates will be communicated to you shortly.

@elseif ($application->status === 'rejected')
    **Update: Your Election Application Status**

    We regret to inform you that your application for the **{{ $application->election->title }}** election was not approved at this time.

    We understand this may be disappointing. We encourage you to review the election guidelines and requirements for future opportunities.

    If you have any questions or would like to understand the decision further, please do not hesitate to contact our support team.

@else
    Your application status is: **{{ ucfirst($application->status) }}**.
@endif

Thank you for your interest in participating.

Thanks,<br>
{{ config('app.name') }}
@endcomponent