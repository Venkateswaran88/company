<x-app-layout>
    <br/>
    @if($isAdmin)
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('company.create') }}"> Create New company</a>
                </div>
            </div>
            <br/>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Website</th>
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($companies as $company)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $company->name }}</td>
            <td>{{ $company->email }}</td>
            <td>{{ $company->phone }}</td>
            <td>{{ $company->website }}</td>
            <td>{{ $company->status ? 'Acitve' : 'Inactive' }}</td>
            <td>
                <form action="{{ route('company.destroy', $company->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('company.show', $company->id) }}">Show</a>
                    @if($isAdmin)
                    <a class="btn btn-primary" href="{{ route('company.edit', $company->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')
    
                    <button type="submit" class="btn btn-warning">Delete</button>
                    @endif
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $companies->links() !!}
</x-app-layout>