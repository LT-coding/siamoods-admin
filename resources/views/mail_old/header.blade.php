@php
$logo=\App\Models\Customization::where('name','logo')->first();
@endphp
<tr>
    <td style="border-collapse:collapse;color:#333333;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:10px 30px 20px 30px">
        <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
            <tbody>
            <tr>
                <td style="border-collapse:collapse;color:#333333;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px">
                    <a href="{{route('home')}}"
                       rel="noopener noreferrer" style="color:#aeafaf" target="_blank">
                        <img
                            alt="SiaMoods" height="84" width="266"
                            src="{{$logo?$logo->value:''}}"
                            style="border:medium;text-decoration:none">
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>
