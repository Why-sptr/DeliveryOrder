@extends('layouts.app')

@section('content')
<section class="section dashboard">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Manage ID Badges</h5>
                <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#idBadgeModal">Add ID Badge</button>
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Badge Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($badges as $badge)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $badge->badge_name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#idBadgeModalEdit{{ $badge->id }}">Edit</button>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#idBadgeModalDelete{{ $badge->id }}">Delete</button>
                                    <div class="modal fade" id="idBadgeModalDelete{{ $badge->id }}" tabindex="-1" aria-labelledby="idBadgeModalLabelDelete{{ $badge->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="idBadgeModalLabelDelete{{ $badge->id }}">Delete ID Badge</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this ID Badge?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <form action="{{ route('id-badges.destroy', $badge->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Edit ID Badge -->
        @foreach ($badges as $badge)
        <div class="modal fade" id="idBadgeModalEdit{{ $badge->id }}" tabindex="-1" aria-labelledby="idBadgeModalLabel{{ $badge->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="idBadgeModalLabel{{ $badge->id }}">Edit ID Badge</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('id-badges.update', $badge->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="badge_name">Badge Name</label>
                                <input type="text" name="badge_name" class="form-control" value="{{ $badge->badge_name }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        <!-- Modal Create ID Badge -->
        <div class="modal fade" id="idBadgeModal" tabindex="-1" aria-labelledby="idBadgeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="idBadgeModalLabel">Add ID Badge</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('id-badges.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="badge_name">Badge Name</label>
                                <input type="text" name="badge_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection