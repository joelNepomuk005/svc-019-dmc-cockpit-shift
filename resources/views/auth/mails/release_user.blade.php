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
                        <p>Sehr geehrte/r {{$user->sex == 'male' ? 'Herr' : 'Frau'}} {{ $user->last_name }},<br><br>

                            vielen Dank für Ihr Interesse am DMC-Cockpit und den Kampagnen Sparkassen-Card mit Co-Badge Debit Mastercard.<br><br>
                            Wir haben Ihren Zugang freigeschaltet.<br><br>
                            Sie können sich mit den hinterlegten Login-Daten auf <a href="{{env('APP_URL')}}">www.dmc-cockpit.de</a> <p>einloggen.</p>
                        <br><br>
                        <p>Bei Fragen rund um die DMC stehen wir Ihnen gerne zur Verfügung.</p><br>
                        <p>Freundliche Grüße<br><br>
                            Ihr Team vom DMC-Aktionsbüro
                        </p><br>
                        <p>Telefon: +49 345 57292-5236<br>
                        E-Mail: dmc@s-markt-mehrwert.de<br>
                        c/o S-Markt & Mehrwert GmbH & Co. KG<br>
                            Ein Unternehmen der Sparkassen-Finanzgruppe</p><br<br>
                        <p>
                            Sitz der Gesellschaft: Halle (Saale)<br>
                            Registergericht: Stendal<br>
                            Handelsregister: HRA 31780<br>
                        </p><br>
                        <p>
                            Bankverbindung:<br>
                            Saalesparkasse<br>
                            IBAN: DE27 8005 3762 0386 3026 37<br>
                            BIC: NOLADE21HAL<br>
                            USt- ID- Nr: DE179831299<br>
                        </p><br>
                        <p>
                            Persönlich haftende Gesellschafterin:<br>
                            S-Markt & Mehrwert Geschäftsführungsgesellschaft mbH<br>
                            Geschäftsführung:<br>
                            André Pallinger (Sprecher), Christina Martin
                        </p><br>
                        <small>Haftungshinweis<br>
                            Sofern die S-Markt & Mehrwert GmbH & Co. KG mittels eines Hyperlinks auf andere Internetseiten verweist,<br> die Angebote und Inhalte Dritter darstellen, macht sie sich die dortigen Daten und Inhalte nicht zu eigen und übernimmt keine Haftung.<br> Dies gilt auch, soweit Internetseiten von der S-Markt & Mehrwert GmbH & Co. KG<br> ohne deren Wissen von Internetseiten Dritter angelinkt werden können.
                        </small>


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
