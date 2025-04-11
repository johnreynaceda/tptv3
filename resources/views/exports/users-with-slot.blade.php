<table>
    <thead>
        <tr style="background-color: #106c3b; color: white">
            <th>Examinee Number</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Extension</th>
            <th>Phone Number</th>
            <th>Email Address</th>
            <th>Sex</th>
            <th>Permanent Address</th>
            <th>Date of Birth</th>
            <th>Age</th>
            <th>Tribe</th>
            <th>Religion</th>
            <th>School Address</th>
            <th>Track or Strand</th>
            <th>First Priority Program</th>
            <th>Second Priority Program</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            @php
                $info = $user->personal_information;
                $school = $user->school_information;
                $programs = $user->program_choices->sortByDesc('is_priority')->values();
                $firstProgram = $programs[0]->program->name ?? null;
                $secondProgram = $programs[1]->program->name ?? null;
            @endphp
            <tr>
                <td>{{ $user->permit->examinee_number ?? 'N/A' }}</td>
                <td>{{ $info->first_name ?? 'N/A' }}</td>
                <td>{{ $info->middle_name ?? 'N/A' }}</td>
                <td>{{ $info->last_name ?? 'N/A' }}</td>
                <td>{{ $info->extension ?? 'N/A' }}</td>
                <td>{{ $info->phone_number ?? 'N/A' }}</td>
                <td>{{ $user->email ?? 'N/A' }}</td>
                <td>{{ $info->sex ?? 'N/A' }}</td>
                <td>{{ $info->permanent_address ?? 'N/A' }}</td>
                <td>{{ $info->formatted_date_of_birth ?? $info->date_of_birth ?? 'N/A' }}</td>
                <td>{{ $info->age ?? 'N/A' }}</td>
                <td>{{ $info->tribe ?? 'N/A' }}</td>
                <td>{{ $info->religion ?? 'N/A' }}</td>
                <td>{{ $school->previous_school_address ?? 'N/A' }}</td>
                <td>{{ $school->track_and_strand_taken ?? 'N/A' }}</td>
                <td>{{ $firstProgram ?? 'N/A' }}</td>
                <td>{{ $secondProgram ?? 'N/A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
