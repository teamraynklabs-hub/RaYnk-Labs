<?php
/**
 * Meetups & Podcasts section with signup form.
 */

declare(strict_types=1);

$events = [
    ['title' => 'Weekly Tech Meetup', 'badge' => 'Free', 'time' => 'Saturdays • 6 PM IST', 'type' => 'meetup'],
    ['title' => 'Builders Podcast',   'badge' => 'Free', 'time' => 'Fridays • 8 PM IST',   'type' => 'podcast'],
];

$originTitle = 'Meetups & Podcasts';
?>

<section id="meetups" class="py-5 bg-black text-white">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-uppercase text-success fw-semibold mb-2">Events</p>
            <h2 class="fw-bold">Meetups & Podcasts</h2>
            <p class="text-white-50 mb-0">Share demos, learn from founders, and listen to stories from the Ranky Labs network.</p>
        </div>
        <div class="row g-4">
            <?php foreach ($events as $event): ?>
                <div class="col-md-6">
                    <div class="card h-100 bg-dark border-secondary shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-success text-dark"><?= htmlspecialchars($event['badge']); ?></span>
                                <small class="text-uppercase text-white-50"><?= htmlspecialchars($event['type']); ?></small>
                            </div>
                            <h5 class="card-title"><?= htmlspecialchars($event['title']); ?></h5>
                            <p class="text-info mb-3"><?= htmlspecialchars($event['time']); ?></p>
                            <p class="text-white-50 flex-grow-1">Share your details and we will send you the calendar invite plus event resources.</p>
                            <button class="btn btn-outline-success mt-3" data-bs-toggle="modal" data-bs-target="#meetupModal">
                                Register Interest
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<div class="modal fade" id="meetupModal" tabindex="-1" aria-labelledby="meetupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="meetupModalLabel"><?= htmlspecialchars($originTitle); ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/includes/submit_form.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="type" value="meetup">
                    <input type="hidden" name="origin_title" value="<?= htmlspecialchars($originTitle); ?>">
                    <div class="mb-3">
                        <label class="form-label" for="meetup-name">Full Name</label>
                        <input class="form-control" type="text" id="meetup-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="meetup-email">Email</label>
                        <input class="form-control" type="email" id="meetup-email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="meetup-phone">Phone</label>
                        <input class="form-control" type="tel" id="meetup-phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="meetup-message">What do you want to participate in?</label>
                        <textarea class="form-control" id="meetup-message" name="message" rows="4" placeholder="E.g., Demo my app, co-host podcast, attend workshop" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit Interest</button>
                </div>
            </form>
        </div>
    </div>
</div>

