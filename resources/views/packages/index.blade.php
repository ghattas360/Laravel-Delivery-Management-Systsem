@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Packages</h2>
        <a href="{{ route('packages.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Create New Package
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($packages->isEmpty())
        <div class="alert alert-info">
            You haven't created any packages yet.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Dimensions</th>
                        <th>Weight</th>
                        <th>Properties</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packages as $package)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($package->picture)
                                    <img src="{{ Storage::url($package->picture) }}" 
                                         alt="Package Image" 
                                         class="img-thumbnail" 
                                         width="80"
                                         onclick="window.open('{{ Storage::url($package->picture) }}', '_blank')"
                                         style="cursor: pointer">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>
                                {{ $package->height }} × {{ $package->width }} × {{ $package->depth }} 
                                <small class="text-muted">{{ $package->measurement_unit }}</small>
                            </td>
                            <td>
                                {{ $package->weight }} 
                                <small class="text-muted">{{ $package->weight_unit }}</small>
                            </td>
                            <td>
                                @if($package->is_breakable)
                                    <span class="badge badge-warning">Fragile</span>
                                @endif
                                @if($package->is_flammable)
                                    <span class="badge badge-danger">Flammable</span>
                                @endif
                                @if($package->has_fluid)
                                    <span class="badge badge-info">Liquid</span>
                                @endif
                            </td>
                    <td>
    <div class="btn-group btn-group-sm" role="group">
        <a href="{{ route('packages.edit', $package->id) }}" 
           class="btn btn-outline-primary"
           title="Edit">
            <i class="fas fa-edit"></i>
        </a>

        <a href="{{ route('requests.create', $package->id) }}"
           class="btn btn-outline-info"
           title="Find Driver">
            <i class="fas fa-truck"></i>
        </a>

        <form action="{{ route('packages.destroy', $package->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="btn btn-outline-danger"
                    title="Delete"
                    onclick="return confirm('Are you sure you want to delete this package?')">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </div>
</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .img-thumbnail {
        transition: transform 0.2s;
    }
    .img-thumbnail:hover {
        transform: scale(1.1);
    }
    .badge {
        margin-right: 3px;
    }
</style>
@endsection

@section('scripts')
@if(session('success'))
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    </script>
@endif
@endsection