<center>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td align="left">
                    <div>
                        <img src="{{ asset('/assets/img/mail/email_confirmations_logo.jpg')}}" alt="BlueOcean" />
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="text-align: left"><strong>NEW THERAPIST APPLICATION</strong></p>
    <table width="100%" cellpadding="5" cellspacing="1" border="0">
        <tbody>
            <tr>
                <td align="left">First name:</td>
                <td align="left">{{ $application['first_name'] }}</td>
            </tr>
            <tr>
                <td align="left">Last name:</td>
                <td align="left">{{ $application['last_name'] }}</td>
            </tr>
            <tr>
                <td align="left">Email:</td>
                <td align="left">{{ $application['email'] }}</td>
            </tr>
            <tr>
                <td align="left">Mobile:</td>
                <td align="left">{{ $application['mobile'] }}</td>
            </tr>
            <tr>
                <td align="left">IP:</td>
                <td align="left">{{ $application['ip'] }}</td>
            </tr>
            <tr>
                <td align="left">SYSTEM:</td>
                <td align="left">{{ $application['user_agent'] ?? '' }}</td>
            </tr>
        </tbody>
    </table>
</center>
