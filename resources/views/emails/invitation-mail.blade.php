<p>Dear Colleague,</p>
<p>
You have been invited to register and start using the {{ config('app.name') }} toolkit.
Click <a href="{{$invitation->link}}">here </a> and follow the instructions to get started.
</p>

<p>
*The account is exclusively for your official use. DO NOT share your login details with anyone.
</p>
<p>
This invitation will expire at {{$invitation->expires_at}}.
Please make sure you register before then as the link will not work after that.*
</p>
<br>
<br>
Best regards,<br>
{{ config('app.name') }} Manager
