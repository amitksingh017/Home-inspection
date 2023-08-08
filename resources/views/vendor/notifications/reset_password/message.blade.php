<tr>
    <td class="content-cell message-title">
        {{ \Illuminate\Support\Str::replace('APP_NOTIFICATION_TITLE_NAME', config('app.app_notification_title_name'), __('email_messages.reset_password.message-title')) }}
    </td>
</tr>
<tr>
    <td class="content-cell message-first_name">
        {{ __('email_messages.reset_password.message-hi') }} {{ $first_name }},
    </td>
</tr>
<tr>
    <td class="content-cell">
        {{ __('email_messages.reset_password.message-text-row-1') }}
    </td>
</tr>
<tr>
    <td class="content-cell">
        {{ __('email_messages.reset_password.message-text-row-2') }}
    </td>
</tr><tr>
    <td class="content-cell">
        {{ __('email_messages.reset_password.message-text-row-3') }}
    </td>
</tr><tr>
    <td class="content-cell">
        {{ __('email_messages.reset_password.message-text-row-4') }}
    </td>
</tr>
<tr>
    <td class="content-cell message-link-reset-password">
        <a href="{{ $url }}" target="_blank" class="set-password">{{ __('email_messages.reset_password.message-text-link') }}</a>
    </td>
</tr>
<tr>
    <td class="content-cell">
        {{ __('email_messages.reset_password.message-text-row-5') }}
    </td>
</tr>
<tr>
    <td class="content-cell message-text-thanks" style="text-align: left">
        {{ __('email_messages.reset_password.message-thanks') }}
    </td>
</tr>
<tr>
    <td class="content-cell" style="text-align: left">
        <a href="{{ config('app.app_notification_footer_url') }}">{{ config('app.app_notification_footer_name') }}</a>
    </td>
</tr>
