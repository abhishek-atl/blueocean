<table cellpadding="5" cellspacing="5" width="100%" border="0" align="center" bgcolor="#e7e7e7">
    <tr align="center">
        <td colspan="2">
            <img src="{{ asset('assets/img/mail/email_confirmations_logo.jpg') }}">
        </td>
    </tr>
    <tr align="center" bgcolor="#ffffff">
        <td colspan="2" style="padding-top: 40px; padding-bottom:40px;">
            <p>Hello {{ $user->first_name }}!</p>
            <p>Your password has been updated successfully!</p>
        </td>
    </tr>
</table>