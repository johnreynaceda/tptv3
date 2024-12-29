<table align="left">
    <thead>
        <tr style="background-color: #106c3b; color: white">
            <th style="background-color: #106c3b; color: white">Permit Number</th>
            <th style="background-color: #106c3b; color: white">Full Name</th>
            <th style="background-color: #106c3b; color: white">Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td align="left" width="40">{{ $user->permit->examinee_number ?? 'N/A' }}</td>
                <td align="left" width="40">{{ $user->personal_information->fullName() ?? 'N/A' }}</td>
                <td align="left" width="40">{{ $user->email }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
