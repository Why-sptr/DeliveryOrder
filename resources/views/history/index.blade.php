@extends('layouts.app')

@section('content')
<section class="section dashboard">
    <style>
        input#dateRange,
        input#dateRange:focus {
            border: none;
            outline: none;
            color: white;
        }
    </style>
    <div class="row">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @elseif (session('warning'))
        <div class="alert alert-danger">
            {{ session('warning') }}
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3">
                    <h5 class="card-title">Manage Reservations</h5>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#reservationModal">
                        Add Reservation
                    </button>
                    <div class="mt-4 mt-md-0 ms-md-auto" style="width: max-content;">
                        <label for="dateRange" class="btn btn-sm btn-light text-dark fw-600 d-flex align-items-center px-4">
                            <input placeholder="Pick date range" class="bg-transparent text-dark fw-600 cursor-pointer"
                                id="dateRange" />
                            <i class="bi bi-calendar-event-fill"></i>
                        </label>
                        <input type="hidden" id="start_date">
                        <input type="hidden" id="end_date">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table" id="reservationTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Reservation Date</th>
                                <th>Reservation/PO</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Name</th>
                                <th>Badge</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Edit Reservasi -->
        @foreach ($reservations as $reservation)
        <div class="modal fade" id="reservationModalEdit{{ $reservation->id }}" tabindex="-1" aria-labelledby="reservationModalLabel{{ $reservation->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reservationModalLabel{{ $reservation->id }}">Edit Reservation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('reservation.update', $reservation->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="reservation_date">Reservation Date</label>
                                <input type="date" name="reservation_date" class="form-control" value="{{ $reservation->reservation_date }}" required>
                            </div>
                            <div class="form-group">
                                <label for="no_reservation">Reservation/PO</label>
                                <input type="text" name="no_reservation" class="form-control" value="{{ $reservation->no_reservation }}" required>
                            </div>
                            <div class="form-group">
                                <label for="item">Item</label>
                                <input type="number" name="item" class="form-control" value="{{ $reservation->item }}" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="{{ $reservation->quantity }}" required>
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

        <!-- Modal Create Reservasi -->
        <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reservationModalLabel">Add Reservation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('reservation.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="reservation_date">Reservation Date</label>
                                <input type="date" name="reservation_date" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="no_reservation">Reservation/PO</label>
                                <input type="text" name="no_reservation" class="form-control" required>
                            </div>
                            <div id="item-rows">
                                <div class="row g-3 align-items-center item-row">
                                    <div class="col-md-6">
                                        <label for="item[]" class="form-label">Item</label>
                                        <input type="number" name="item[]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="quantity[]" class="form-label">Quantity</label>
                                        <input type="number" name="quantity[]" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary mt-3" id="add-row">Add More</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('add-row').addEventListener('click', function() {
                const rowHtml = `
                    <div class="row g-3 align-items-center item-row mt-2">
                        <div class="col-md-6">
                            <label for="item[]" class="form-label">Item</label>
                            <input type="number" name="item[]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="quantity[]" class="form-label">Quantity</label>
                            <input type="number" name="quantity[]" class="form-control" required>
                        </div>
                    </div>`;
                document.getElementById('item-rows').insertAdjacentHTML('beforeend', rowHtml);
            });
        </script>
    </div>
</section>
@endsection