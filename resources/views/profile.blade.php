@extends('layouts.app')

@section('content')

<section class="section profile">
    <div class="row">
        <div class="col-xl-4">

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://via.placeholder.com/150' }}" alt="Profile" class="rounded-circle mb-3" width="100">
                    <h2>{{ Auth::user()->name }}</h2>
                    <h3>{{ Auth::user()->email }}</h3>
                </div>
            </div>

        </div>

        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                    @if (session('password_success'))
                    <div class="alert alert-success">
                        {{ session('password_success') }}
                    </div>
                    @endif
                    @if (session('password_error'))
                    <div class="alert alert-danger">
                        {{ session('password_error') }}
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2">

                        <!-- Edit Profile Tab -->
                        <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                            @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                    <div class="col-md-8 col-lg-9">
                                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://via.placeholder.com/150' }}" alt="Profile" class="rounded-circle mb-3" width="100">
                                        <div class="pt-2">
                                            <input type="file" name="avatar" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="name" type="text" class="form-control" id="fullName" value="{{ Auth::user()->name }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control" id="Email" value="{{ Auth::user()->email }}" required>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <form action="{{ route('profile.update.password') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="new_password" type="password" class="form-control" id="newPassword" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="new_password_confirmation" type="password" class="form-control" id="renewPassword" required>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </form>
                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </div>
</section>
@endsection