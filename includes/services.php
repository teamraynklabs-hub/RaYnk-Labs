<?php
/**
 * Services section with modal forms.
 *
 * Each service card opens a Bootstrap modal that submits to submit_form.php,
 * tagging the request with the service title via the origin_title field.
 */

declare(strict_types=1);

$services = [
    ['title' => 'Web Development',      'description' => 'Custom websites and portals tailored to your goals.'],
    ['title' => 'Mobile App Design',    'description' => 'Intuitive app experiences for iOS and Android.'],
    ['title' => 'AI Automation',        'description' => 'Automate workflows with smart AI co-pilots.'],
    ['title' => 'Brand Identity',       'description' => 'Logos, kits, and storytelling for standout brands.'],
    ['title' => 'Product Strategy',     'description' => 'Roadmaps, feature planning, and MVP validation.'],
    ['title' => 'Tech Consulting',      'description' => 'Architecture reviews and scaling strategies.'],
];

/**
 * Generate a slug-safe ID for modal targeting.
 */
$slugify = static function (string $title): string {
    $slug = preg_replace('/[^a-z0-9]+/i', '-', strtolower($title)) ?? '';
    return trim($slug, '-') ?: 'service';
};
?>

<section id="services" class="py-5 bg-dark text-white">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-uppercase text-info fw-semibold mb-2">What We Do</p>
            <h2 class="fw-bold">Services that drive outcomes</h2>
            <p class="text-white-50 mb-0">Pick a service and tell us what you need—we’ll take it from there.</p>
        </div>
        <div class="row g-4">
            <?php foreach ($services as $service): ?>
                <?php $modalId = 'service-' . $slugify($service['title']); ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 bg-black border-secondary shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-info"><?= htmlspecialchars($service['title']); ?></h5>
                            <p class="card-text flex-grow-1 text-white-50"><?= htmlspecialchars($service['description']); ?></p>
                            <button class="btn btn-primary mt-3" type="button"
                                    data-bs-toggle="modal" data-bs-target="#<?= $modalId; ?>">
                                Get Service
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="<?= $modalId; ?>" tabindex="-1" aria-labelledby="<?= $modalId; ?>Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-dark text-white border-secondary">
                            <div class="modal-header border-secondary">
                                <h5 class="modal-title" id="<?= $modalId; ?>Label">Request: <?= htmlspecialchars($service['title']); ?></h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/includes/submit_form.php" method="POST" class="needs-validation" novalidate>
                                <div class="modal-body">
                                    <input type="hidden" name="type" value="service">
                                    <input type="hidden" name="origin_title" value="<?= htmlspecialchars($service['title']); ?>">
                                    <div class="mb-3">
                                        <label class="form-label" for="name-<?= $modalId; ?>">Full Name</label>
                                        <input class="form-control" type="text" id="name-<?= $modalId; ?>" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="email-<?= $modalId; ?>">Email</label>
                                        <input class="form-control" type="email" id="email-<?= $modalId; ?>" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="phone-<?= $modalId; ?>">Phone</label>
                                        <input class="form-control" type="tel" id="phone-<?= $modalId; ?>" name="phone" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="message-<?= $modalId; ?>">Project Details</label>
                                        <textarea class="form-control" id="message-<?= $modalId; ?>" name="message" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-secondary">
                                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit Request</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

