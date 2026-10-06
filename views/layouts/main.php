<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Bike Rental System'); ?></title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #f59e0b;
            --dark-bg: #1f2937;
            --light-bg: #f9fafb;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: #374151;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .bike-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .bike-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .bike-card-image {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            position: relative;
            overflow: hidden;
        }

        .bike-card-image i {
            opacity: 0.8;
        }

        .badge-availability {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-availability.available {
            background-color: #10b981;
            color: white;
        }

        .badge-availability.unavailable {
            background-color: #ef4444;
            color: white;
        }

        .bike-card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .bike-card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .bike-type-badge {
            display: inline-block;
            background-color: var(--light-bg);
            color: var(--primary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
            width: fit-content;
        }

        .bike-description {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
            flex: 1;
        }

        .bike-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .btn-rent {
            background-color: var(--primary-color);
            border: none;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn-rent:hover {
            background-color: var(--secondary-color);
            transform: scale(1.02);
        }

        .btn-details {
            background-color: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            font-weight: 600;
        }

        .btn-details:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .filter-section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .search-input {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        .filter-label {
            font-weight: 600;
            color: #374151;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .empty-state-icon {
            font-size: 3rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        .empty-state-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .empty-state-text {
            color: #6b7280;
        }

        .pagination {
            justify-content: center;
            margin-top: 2rem;
        }

        .page-link {
            color: var(--primary-color);
            border-color: #e5e7eb;
        }

        .page-link:hover {
            background-color: var(--light-bg);
            color: var(--secondary-color);
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .loading-spinner.active {
            display: block;
        }

        .sort-container {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-group-sort .btn {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
        }

        @media (max-width: 768px) {
            .filter-section {
                padding: 1.5rem;
            }

            .bike-card-image {
                height: 150px;
            }

            .sort-container {
                flex-direction: column;
            }

            .sort-container .form-select,
            .sort-container .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-bicycle"></i> BikeHub
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Browse Bikes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/api/bikes">API</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            <?php echo $content ?? ''; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5><i class="fas fa-bicycle"></i> BikeHub</h5>
                    <p>Your trusted bike rental service</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="/" class="text-decoration-none text-light">Browse Bikes</a></li>
                        <li><a href="/api/bikes" class="text-decoration-none text-light">API Documentation</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Contact</h6>
                    <p>Email: info@bikehub.com<br>Phone: (555) 123-4567</p>
                </div>
            </div>
            <hr class="bg-secondary">
            <div class="text-center">
                <p class="mb-0">&copy; 2026 BikeHub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
