<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $subject }}</title>
</head>
<body style="font-family: Arial, sans-serif; font-size: 14px;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color: #EDF2F6; padding: 20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #fff; border: 1px solid #ddd; border-radius: 3px;">
                <tr>
                    <td align="center" style="padding: 20px;">
                    </td>
                    <h1 style="margin-top: 0.0cm;box-sizing: border-box;"><a style="font-size: 13.5pt; color: rgb(61,72,82);" href="{{env('APP_URL')}}">{{env('APP_NAME')}}</a></h1>
                </tr>
                <tr>
                    <td style="padding: 0pt 24.0pt 24.0pt 24.0pt;box-sizing: border-box;">
                        <h1 style="margin-top: 0.0cm;box-sizing: border-box;"><span style="font-size: 13.5pt;font-family: &quot;Segoe UI&quot; , sans-serif;color: rgb(61,72,82);">Neuregistrierung eines SK-Mitarbeiters</span></h1>
                        <span style="color: black;">{{$content}}</span>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding: 20px;">
                        <a style="    color: white; border-radius: 4px; border: solid rgb(45,55,72) 6pt; padding: 0cm;background: rgb(45,55,72);text-decoration: none;" class="button" href="{{env('APP_URL')}}">Jetzt freigeben</a>
                    </td>
                </tr>
            </table>
            <table width="600" cellpadding="0" cellspacing="0" >
                <tr>
                    <td align="center" style="padding: 20px; background-color: #EDF2F6; font-size: 12px;">
                        <p>© {{date('Y')}} {{env('APP_NAME')}}. Alle Rechte vorbehalten.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
<style>
    .h1 {
        font-size: 13.5pt;
        font-family: "Segoe UI" , sans-serif;
        color: rgb(61,72,82);
    }

</style>
</html>
