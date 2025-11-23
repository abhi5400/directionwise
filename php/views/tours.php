<?php
/**
 * Tours Listing Page View
 */
?>

<section class="section tours-listing">
    <div class="container">
        <div class="section-header">
            <h1>Our Tours</h1>
            <p>Explore our range of luxury tours and experiences in Dubai and Abu Dhabi</p>
        </div>

        <?php if (empty($tours)): ?>
        <div class="empty-state">
            <p>No tours available at the moment. Please check back later.</p>
        </div>
        <?php else: ?>
        <div class="tours-grid">
            <?php foreach ($tours as $tour): ?>
            <article class="tour-card">
                <a href="/tour/<?php echo htmlspecialchars($tour['slug'] ?? $tour['id']); ?>" class="tour-card-link">
                    <div class="tour-card-image">
                        <picture>
                            <?php if (!empty($tour['image_webp'])): ?>
                            <source srcset="/assets/images/tours/<?php echo htmlspecialchars($tour['image_webp']); ?>" type="image/webp">
                            <?php endif; ?>
                            <img src="/assets/images/tours/<?php echo htmlspecialchars($tour['image'] ?? 'placeholder.jpg'); ?>" 
                                 alt="<?php echo htmlspecialchars($tour['title']); ?>" 
                                 loading="lazy" 
                                 width="400" 
                                 height="225">
                        </picture>
                    </div>
                    <div class="tour-card-content">
                        <div class="tour-card-meta">
                            <span class="tour-duration"><?php echo htmlspecialchars($tour['duration'] ?? 'N/A'); ?></span>
                            <?php if (!empty($tour['tags'])): ?>
                            <span class="tour-tags">
                                <?php echo htmlspecialchars(implode(', ', array_slice($tour['tags'], 0, 2))); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <h2 class="tour-card-title"><?php echo htmlspecialchars($tour['title']); ?></h2>
                        <p class="tour-card-excerpt"><?php echo htmlspecialchars($tour['excerpt'] ?? ''); ?></p>
                        <div class="tour-card-footer">
                            <span class="tour-price">From <?php echo htmlspecialchars($tour['currency'] ?? 'USD'); ?> <?php echo number_format($tour['price_from'] ?? 0, 2); ?></span>
                            <span class="tour-cta">View Details →</span>
                        </div>
                    </div>
                </a>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

