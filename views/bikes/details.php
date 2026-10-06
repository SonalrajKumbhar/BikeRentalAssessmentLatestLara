<?php

// Default values
$bike = $bike ?? null;
$pageTitle = $bike ? htmlspecialchars($bike->getName()) . ' - Bike Details' : 'Bike Details';

ob_start();
?>

<!-- Back Button -->
<div class="mb-4">
    <a href="/" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Back to Bikes
    </a>
</div>

<?php if ($bike): ?>
    <!-- Bike Details -->
    <div class="row">
        <!-- Image -->
        <div class="col-lg-6 mb-4">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 3rem; border-radius: 8px; color: white; text-align: center;">
                <i class="fas fa-bicycle" style="font-size: 6rem; opacity: 0.8;"></i>
            </div>
        </div>

        <!-- Details -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body p-4">
                    <!-- Title -->
                    <h1 class="mb-3"><?php echo htmlspecialchars($bike->getName()); ?></h1>

                    <!-- Type Badge -->
                    <div class="mb-3">
                        <span class="badge bg-primary fs-6">
                            <?php echo htmlspecialchars($bike->getType()); ?>
                        </span>
                    </div>

                    <!-- Availability -->
                    <div class="mb-4">
                        <strong>Status:</strong>
                        <?php if ($bike->isAvailable()): ?>
                            <span class="badge bg-success ms-2">Available</span>
                        <?php else: ?>
                            <span class="badge bg-danger ms-2">Unavailable</span>
                        <?php endif; ?>
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <h2 style="color: #2563eb;">
                            $<?php echo number_format($bike->getPrice(), 2); ?>/day
                        </h2>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p><?php echo nl2br(htmlspecialchars($bike->getDescription())); ?></p>
                    </div>

                    <!-- Specs -->
                    <div class="mb-4">
                        <h5>Specifications</h5>
                        <table class="table">
                            <tr>
                                <td><strong>Bike ID:</strong></td>
                                <td><?php echo $bike->getId(); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Type:</strong></td>
                                <td><?php echo htmlspecialchars($bike->getType()); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Daily Rate:</strong></td>
                                <td>$<?php echo number_format($bike->getPrice(), 2); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <?php echo $bike->isAvailable() ? '<span class="badge bg-success">Available</span>' : '<span class="badge bg-danger">Unavailable</span>'; ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Action Buttons -->
                    <div class="gap-2 d-flex">
                        <?php if ($bike->isAvailable()): ?>
                            <button class="btn btn-primary btn-lg flex-grow-1">
                                <i class="fas fa-shopping-cart"></i> Rent This Bike
                            </button>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-lg flex-grow-1" disabled>
                                <i class="fas fa-lock"></i> Currently Unavailable
                            </button>
                        <?php endif; ?>
                        <button class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Bikes -->
    <div class="mt-5">
        <h3 class="mb-4">Similar Bikes</h3>
        <!-- Would show other bikes of the same type -->
        <p class="text-muted">Browse other <?php echo htmlspecialchars($bike->getType()); ?> bikes available for rental.</p>
    </div>

<?php else: ?>
    <!-- Bike Not Found -->
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> Bike not found.
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
