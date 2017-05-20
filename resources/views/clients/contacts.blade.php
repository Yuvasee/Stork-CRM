<ul class="list-unstyled">
    <li><i class="fa fa-building" aria-hidden="true"></i> <i class="fa fa-phone" aria-hidden="true"></i> {{ $client->phone_number }} <i class="fa fa-envelope" aria-hidden="true"></i> {{ $client->email }}</li>
    @foreach ($client->contactPersons as $contactPerson)
        <li><i class="fa fa-user-circle-o" aria-hidden="true"></i> {{ $contactPerson->name }}
                @if ($contactPerson->phone_work)
                    <i class="fa fa-phone" aria-hidden="true"></i> {{ $contactPerson->phone_work }}
                @endif
                @if ($contactPerson->email)
                    <i class="fa fa-envelope" aria-hidden="true"></i> {{ $contactPerson->email }}
                @endif
        </li>
    @endforeach
</ul>
