@extends('layouts.mail')

@section('content')
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" bgcolor="#eeeeee">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                <tr>
                    <td align="center" style="padding: 35px;" bgcolor="#c95518">
                        <h1 style="font-size: 28px; color: #fff; font-family: Arial, sans-serif;">Confirmation de Réservation</h1>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding: 20px 35px; background-color: #ffffff;">
                        <img src="https://img.icons8.com/carbon-copy/100/000000/checked-checkbox.png" width="100" height="100" alt="Confirmation">
                        <h2 style="font-family: Arial, sans-serif; color: #333;">Merci {{ $data['client_name'] }} !</h2>
                        <p style="font-family: Arial, sans-serif; color: #555; font-size: 16px;">
                            Votre réservation a été bien enregistrée. Voici les détails :
                        </p>

                        <table width="100%" style="margin-top: 20px; font-family: Arial, sans-serif;">
                            <tr>
                                <td><strong>Numéro :</strong></td>
                                <td>{{ $data['booking_id'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date :</strong></td>
                                <td>{{ $data['date'] }}</td>
                            </tr>
                            <tr>
                                <td><strong>Heure :</strong></td>
                                <td>{{ $data['time'] }}</td>
                            </tr>
                            <tr>
                                <td><strong>Services :</strong></td>
                                <td>
                                    <ul>
                                        @foreach($data['services'] as $service)
                                            <li>{{ $service }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Montant total :</strong></td>
                                <td>{{ $data['total_price'] ?? '0' }} DA</td>
                            </tr>
                        </table>

                        <p style="margin-top: 30px; font-family: Arial, sans-serif; color: #888; font-size: 14px;">
                            Nous vous contacterons pour confirmer les détails restants. Merci pour votre confiance.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="center" bgcolor="#c95518" style="padding: 20px; color: #fff; font-family: Arial, sans-serif;">
                        © {{ date('Y') }} ONX Studio — Tous droits réservés.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
