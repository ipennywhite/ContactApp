<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ContactApp - Contacts</title>
    <!-- Simple styling for readability -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Contacts List</h2>
            <a href="{{ route('contacts.create') }}" class="btn btn-primary">Add New Contact</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped mb-0">
                    <thead>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Company</th>
        <th>Address</th>
        <th class="text-end">Actions</th>
    </tr>
</thead>
<tbody>
    @forelse($contacts as $contact)
        <tr>
            <td>{{ $contact->first_name }}</td>
            <td>{{ $contact->last_name }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->phone ?? 'N/A' }}</td>
            <td>{{ $contact->company ? $contact->company->name : 'No Company' }}</td>
            <td>{{ $contact->address }}</td>
            <td class="text-end">
                <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this contact?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-muted py-4">No contacts found. Create your first one!</td>
        </tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>