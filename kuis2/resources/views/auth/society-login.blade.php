<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Seeker Platform - Login</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Job Seekers Platform</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>
    <!-- S: Header -->
    <header class="jumbotron">
        <div class="container text-center">
            <h1 class="display-4">Job Seekers Platform</h1>
        </div>
    </header>
    <!-- E: Header -->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="{{ route('society.login') }}" class="card card-default">
                    @csrf
                    <div class="card-header">
                        <h4 class="mb-0">Login</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row align-items-center">
                            <div class="col-4 text-right">
                                <label for="id_card_number">ID Card Number</label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="id_card_number" name="id_card_number" class="form-control" required maxlength="8">
                                @error('id_card_number')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <div class="col-4 text-right">
                                <label for="password">Password</label>
                            </div>
                            <div class="col-8">
                                <input type="password" id="password" name="password" class="form-control" required>
                                @error('password')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row align-items-center mt-4">
                            <div class="col-4"></div>
                            <div class="col-8">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- S: Footer -->
<footer>
    <div class="container">
        <div class="text-center py-4 text-muted">
            Copyright &copy; 2025 - Web Tech ID
        </div>
    </div>
</footer>
<!-- E: Footer -->

</body>
</html>