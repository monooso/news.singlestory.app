@component('mail::layout')
    <table cellpadding="0" cellspacing="0" style="max-width: 600px;">
        <tr>
            <td class="has-text-centered">
                {{ Illuminate\Mail\Markdown::parse($slot) }}
            </td>
        </tr>
    </table>
@endcomponent
