<x-app-layout>
    <br/>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('product.create') }}"> Create New product</a>
            </div>
        </div>
        <br/>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->status ? 'Acitve' : 'Inactive' }}</td>
            <td>
                <form action="{{ route('product.destroy', $product->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('product.show', $product->id) }}">Show</a>
                    @if($isAdmin)
                        <a class="btn btn-primary" href="{{ route('product.edit', $product->id) }}">Edit</a>

                        @csrf
                        @method('DELETE')
        
                        <button type="submit" class="btn btn-warning">Delete</button>
                    @endif
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $products->links() !!}
</x-app-layout>