<?php

// Default values
$bikes = $bikes ?? [];
$pagination = $pagination ?? [];
$pageTitle = 'Bike Rental Dashboard';

// Get query parameters
$search = $_GET['search'] ?? '';
$type = $_GET['type'] ?? '';
$minPrice = isset($_GET['minPrice']) ? (float)$_GET['minPrice'] : '';
$maxPrice = isset($_GET['maxPrice']) ? (float)$_GET['maxPrice'] : '';
$available = $_GET['available'] ?? '';
$sortBy = $_GET['sortBy'] ?? 'name';
$sortDir = $_GET['sortDir'] ?? 'asc';
$page = $pagination['current_page'] ?? 1;

// Build bike types for filter
$bikeTypes = [
    'mountain' => 'Mountain Bike',
    'road' => 'Road Bike',
    'cruiser' => 'Cruiser',
    'hybrid' => 'Hybrid',
    'bmx' => 'BMX',
    'electric' => 'Electric',
];

$priceRanges = [
    ['min' => 0, 'max' => 20, 'label' => 'Under $20'],
    ['min' => 20, 'max' => 40, 'label' => '$20 - $40'],
    ['min' => 40, 'max' => 60, 'label' => '$40 - $60'],
    ['min' => 60, 'max' => PHP_INT_MAX, 'label' => '$60+'],
];

// Build query string for pagination
$queryParams = [];
if ($search !== '') $queryParams['search'] = urlencode($search);
if ($type !== '') $queryParams['type'] = urlencode($type);
if ($minPrice !== '') $queryParams['minPrice'] = $minPrice;
if ($maxPrice !== '') $queryParams['maxPrice'] = $maxPrice;
if ($available !== '') $queryParams['available'] = $available;
$queryParams['sortBy'] = $sortBy;
$queryParams['sortDir'] = $sortDir;
$baseQuery = '?' . http_build_query($queryParams);

// Start output buffering for content
ob_start();
?>

<!-- Hero Section -->
<div class="mb-5">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 3rem 30px; border-radius: 8px; color: white;">
        <h1 class="mb-2"><i class="fas fa-bicycle"></i> Bike Rental Dashboard</h1>
        <p class="lead mb-0">Discover and rent the perfect bike for your adventure</p>
    </div>
</div>

<!-- Filter and Search Section -->
<div class="filter-section">
    <form method="GET" action="/" id="filterForm">
        <!-- Search Bar -->
        <div class="mb-4">
            <label class="filter-label">Search</label>
            <div class="input-group">
                <span class="input-group-text" style="border: 2px solid #e5e7eb; background: white;">
                    <i class="fas fa-search"></i>
                </span>
                <input 
                    type="text" 
                    class="form-control search-input" 
                    name="search" 
                    placeholder="Search by bike name, type, or description..." 
                    value="<?php echo htmlspecialchars($search); ?>"
                >
            </div>
        </div>

        <!-- Filters Row -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <label class="filter-label">Bike Type</label>
                <select class="form-select" name="type">
                    <option value="">All Types</option>
                    <?php foreach ($bikeTypes as $key => $label): ?>
                        <option value="<?php echo $key; ?>" <?php echo $type === $key ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($label); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3 mb-3">
               <label class="filter-label">Sort By</label>
                <select class="form-select" name="sortBy">
                    <option value="name" <?php echo $sortBy === 'name' ? 'selected' : ''; ?>>Name</option>
                    <option value="price" <?php echo $sortBy === 'price' ? 'selected' : ''; ?>>Price</option>
                    <option value="type" <?php echo $sortBy === 'type' ? 'selected' : ''; ?>>Type</option>
                </select>
            </div> 

            <div class="col-md-3 mb-3">
                <label class="filter-label">Order</label>
                <select class="form-select" name="sortDir">
                    <option value="asc" <?php echo $sortDir === 'asc' ? 'selected' : ''; ?>>Ascending</option>
                    <option value="desc" <?php echo $sortDir === 'desc' ? 'selected' : ''; ?>>Descending</option>
                </select>
            </div> 

            <!-- <div class="col-md-3 mb-3">
                <label class="filter-label">Availability</label>
                <select class="form-select" name="available">
                    <option value="">All</option>
                    <option value="true" <?php echo $available === 'true' ? 'selected' : ''; ?>>Available Only</option>
                    <option value="false" <?php echo $available === 'false' ? 'selected' : ''; ?>>Unavailable Only</option>
                </select>
            </div> -->
        </div>

  

        <!-- Buttons -->
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
                <a href="/" class="btn btn-outline-secondary">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Results Info -->
<div class="mb-4">
    <p class="text-muted">
        Showing <strong><?php echo count($bikes); ?></strong> of 
        <strong><?php echo $pagination['total'] ?? 0; ?></strong> bikes
        <span class="ms-2">
            (Page <?php echo $pagination['current_page'] ?? 1; ?> of 
            <?php echo $pagination['total_pages'] ?? 1; ?>)
        </span>
    </p>
</div>

<!-- Bikes Grid -->
<?php if (empty($bikes)): ?>
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-inbox"></i>
        </div>
        <div class="empty-state-title">No Bikes Found</div>
        <p class="empty-state-text">
            Try adjusting your search or filter criteria to find available bikes.
        </p>
    </div>
<?php else: ?>
    <div class="row g-4 mb-5">
        <?php foreach ($bikes as $bike): ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card bike-card">
                    <!-- Card Image with Availability Badge -->
                    <div class="bike-card-image">
                        <span class="badge-availability <?php echo $bike['available'] ? 'available' : 'unavailable'; ?>">
                            <?php echo $bike['available'] ? 'Available' : 'Unavailable'; ?>
                        </span>
                        <i class="fas fa-bicycle"></i>
                    </div>

                    <!-- Card Body -->
                    <div class="bike-card-body p-4">
                        <div class="bike-type-badge">
                            <?php echo htmlspecialchars($bike['type']); ?>
                        </div>
                        
                        <h5 class="bike-card-title">
                            <?php echo htmlspecialchars($bike['name']); ?>
                        </h5>

                        <p class="bike-description">
                            <?php 
                            $desc = htmlspecialchars($bike['description']);
                            echo strlen($desc) > 80 ? substr($desc, 0, 80) . '...' : $desc;
                            ?>
                        </p>

                        <div class="bike-price">
                            $<?php echo number_format($bike['price'], 2); ?>/day
                        </div>

                        <!-- Action Buttons -->
                        <div class="btn-group d-grid gap-2" role="group">
                            <button type="button" class="btn btn-details btn-sm">
                                <i class="fas fa-info-circle"></i> Details
                            </button>
                            <button 
                                type="button" 
                                class="btn btn-rent btn-sm text-white"
                                <?php echo !$bike['available'] ? 'disabled' : ''; ?>
                            >
                                <i class="fas fa-shopping-cart"></i> Rent Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if (($pagination['total_pages'] ?? 1) > 1): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <!-- Previous Button -->
                <?php if ($pagination['has_previous'] ?? false): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo $baseQuery . '&page=' . ($pagination['current_page'] - 1); ?>">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link"><i class="fas fa-chevron-left"></i> Previous</span>
                    </li>
                <?php endif; ?>

                <!-- Page Numbers -->
                <?php 
                $totalPages = $pagination['total_pages'] ?? 1;
                $currentPage = $pagination['current_page'] ?? 1;
                
                // Show first page
                if ($currentPage > 3): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo $baseQuery . '&page=1'; ?>">1</a>
                    </li>
                    <?php if ($currentPage > 4): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif;
                endif;

                // Show pages around current
                for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++):
                    if ($i === $currentPage):
                ?>
                    <li class="page-item active">
                        <span class="page-link"><?php echo $i; ?></span>
                    </li>
                <?php else: ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo $baseQuery . '&page=' . $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endif;
                endfor;

                // Show last page
                if ($currentPage < $totalPages - 2): 
                    if ($currentPage < $totalPages - 3): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo $baseQuery . '&page=' . $totalPages; ?>"><?php echo $totalPages; ?></a>
                    </li>
                <?php endif; ?>

                <!-- Next Button -->
                <?php if ($pagination['has_next'] ?? false): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo $baseQuery . '&page=' . ($pagination['current_page'] + 1); ?>">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Next <i class="fas fa-chevron-right"></i></span>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
