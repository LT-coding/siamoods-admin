@php
    $socials=App\Models\SocialMedia::get();
@endphp
<tr style="border-top-color:#edeff1;border-top-style:solid;border-top-width:1px">
    <td style="background-color:#757f83;border-collapse:collapse;color:#fff;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:20px 30px 20px 30px">
        <table align="left" width="250" style="border-collapse:collapse">
            <tbody>
            <tr>
                <th style="border:medium;border-bottom-color:#edeff1;border-collapse:collapse;color:#fff!important;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px!important;font-weight:600;margin:0px;text-align:center;text-transform:uppercase">
                    Կոնտակտային տվյալներ
                </th>
            </tr>
            <tr>
                <td style="border-collapse:collapse;color:#fff;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:5px;text-align:center">
                    Արշակունյաց 34/3, Երևան
                </td>
            </tr>
            </tbody>
        </table>
        <table align="right" width="250" style="border-collapse:collapse">
            <tbody>
            <tr>
                <th style="border:medium;border-bottom-color:#edeff1;border-collapse:collapse;color:#fff!important;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px!important;font-weight:600;margin:0px;text-align:center;text-transform:uppercase">
                    Մենք սոցիալական ցանցերում
                </th>
            </tr>
            <tr>
                <td style="border-collapse:collapse;color:#fff;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:5px">
                    <table align="center" cellpadding="0" cellspacing="0"
                           style="border-collapse:collapse">
                        <tbody>
                        <tr>
                            @foreach($socials as $social)
                                <td style="border-collapse:collapse;color:#fff;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:0px 10px 0px 0px">
                                    <a href="{{$social->url}}"
                                       rel="noopener noreferrer" style="color:#aeafaf"
                                       target="_blank"
                                       >
                                        <img height="30"
                                            src="{{$social->image}}"
                                            width="30" style="border:medium;text-decoration:none" alt="social">
                                    </a></td>
                            @endforeach

                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>
<tr>
    <td style="border-collapse:collapse;color:#333333;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:0px 30px 10px 30px">
        <table width="100%" style="border-collapse:collapse">
            <tbody>
            <tr>
                <td style="border-collapse:collapse;color:#333333;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding-bottom:0!important;padding-left:0;padding-right:0;padding-top:10px">
                    ©&nbsp;SiaMoods
                </td>
                <td align="right"
                    style="border-collapse:collapse;color:#333333;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding-bottom:0!important;padding-left:0;padding-right:0;padding-top:10px">
                    Շնորհակալություն մեր խանութից օգտվելու համար:
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>
