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
                <td align="left">NAME:</td>
                <td align="left">{{ $application['name'] }}</td>
            </tr>
            <tr>
                <td align="left">EMAIL:</td>
                <td align="left">{{ $application['email'] }}</td>
            </tr>
            <tr>
                <td align="left">MOBILE:</td>
                <td align="left">{{ $application['mobile'] }}</td>
            </tr>
            <tr>
                <td align="left">ADDRESS:</td>
                <td align="left">{{ $application['address'] }}</td>
            </tr>
            <tr>
                <td align="left">HAPPY TO TRAVEL:</td>
                <td align="left">{{ ucfirst($application['travel']) }}</td>
            </tr>
            <tr>
                <td align="left">WORK PREFERENCE:</td>
                <td align="left">{{ ucfirst($application['fulltime']) }}</td>
            </tr>
            <tr>
                <td align="left">FAVOURITE MASSAGE STYLES:</td>
                <td align="left">{{ $application['favourite_massage_style'] }}</td>
            </tr>
            <tr>
                <td align="left">EXPERIENCE:</td>
                <td align="left">{{ $application['massage_love_reason'] }}</td>
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
