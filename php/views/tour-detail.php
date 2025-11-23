<?php
/**
 * Tour Detail Page View
 */
$skipDefaultSchema = true;
?>

<section class="section tour-detail">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="Breadcrumb" class="breadcrumb">
            <ol>
                <li><a href="/">Home</a></li>
                <li><a href="/tours">Tours</a></li>
                <li aria-current="page"><?php echo htmlspecialchars($tour['title']); ?></li>
            </ol>
        </nav>

        <article class="tour-detail-content">
            <div class="tour-detail-header">
                <div class="tour-detail-image">
                    <picture>
                        <?php if (!empty($tour['image_webp'])): ?>
                        <source srcset="/assets/images/tours/<?php echo htmlspecialchars($tour['image_webp']); ?>" type="image/webp">
                        <?php endif; ?>
                        <img src="/assets/images/tours/<?php echo htmlspecialchars($tour['image'] ?? 'placeholder.jpg'); ?>" 
                             alt="<?php echo htmlspecialchars($tour['title']); ?>" 
                             loading="eager" 
                             width="1200" 
                             height="675">
                    </picture>
                </div>
                <div class="tour-detail-info">
                    <h1><?php echo htmlspecialchars($tour['title']); ?></h1>
                    <p class="tour-excerpt"><?php echo htmlspecialchars($tour['excerpt'] ?? ''); ?></p>
                    <div class="tour-meta">
                        <div class="tour-meta-item">
                            <strong>Duration:</strong>
                            <span><?php echo htmlspecialchars($tour['duration'] ?? 'N/A'); ?></span>
                        </div>
                        <div class="tour-meta-item">
                            <strong>Price From:</strong>
                            <span class="tour-price-large"><?php echo htmlspecialchars($tour['currency'] ?? 'USD'); ?> <?php echo number_format($tour['price_from'] ?? 0, 2); ?></span>
                        </div>
                        <?php if (!empty($tour['tags'])): ?>
                        <div class="tour-meta-item">
                            <strong>Categories:</strong>
                            <span><?php echo htmlspecialchars(implode(', ', $tour['tags'])); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <a href="/contact#booking" class="btn btn-primary btn-large">Book This Tour</a>
                </div>
            </div>

            <div class="tour-detail-body">
                <div class="tour-description">
                    <h2>Overview</h2>
                    <div class="tour-description-content">
                        <?php echo $tour['description'] ?? '<p>No description available.</p>'; ?>
                    </div>
                </div>

                <?php if (!empty($tour['itinerary']) && is_array($tour['itinerary'])): ?>
                <div class="tour-itinerary">
                    <h2>Itinerary</h2>
                    <ol class="itinerary-list">
                        <?php foreach ($tour['itinerary'] as $item): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($item['time'] ?? ''); ?></strong>
                            <p><?php echo htmlspecialchars($item['activity'] ?? ''); ?></p>
                        </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
                <?php endif; ?>

                <?php if (!empty($tour['inclusions'])): ?>
                <div class="tour-inclusions">
                    <h2>What's Included</h2>
                    <ul class="inclusions-list">
                        <?php 
                        $inclusions = is_array($tour['inclusions']) ? $tour['inclusions'] : explode("\n", $tour['inclusions']);
                        foreach ($inclusions as $inclusion): 
                        ?>
                        <li><?php echo htmlspecialchars(trim($inclusion)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (!empty($tour['exclusions'])): ?>
                <div class="tour-exclusions">
                    <h2>What's Not Included</h2>
                    <ul class="exclusions-list">
                        <?php 
                        $exclusions = is_array($tour['exclusions']) ? $tour['exclusions'] : explode("\n", $tour['exclusions']);
                        foreach ($exclusions as $exclusion): 
                        ?>
                        <li><?php echo htmlspecialchars(trim($exclusion)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </article>

        <?php if (!empty($relatedTours)): ?>
        <section class="related-tours">
            <h2>Related Tours</h2>
            <div class="tours-grid">
                <?php foreach ($relatedTours as $relatedTour): ?>
                <article class="tour-card">
                    <a href="/tour/<?php echo htmlspecialchars($relatedTour['slug'] ?? $relatedTour['id']); ?>" class="tour-card-link">
                        <div class="tour-card-image">
                            <picture>
                                <?php if (!empty($relatedTour['image_webp'])): ?>
                                <source srcset="/assets/images/tours/<?php echo htmlspecialchars($relatedTour['image_webp']); ?>" type="image/webp">
                                <?php endif; ?>
                                <img src="/assets/images/tours/<?php echo htmlspecialchars($relatedTour['image'] ?? 'placeholder.jpg'); ?>" 
                                     alt="<?php echo htmlspecialchars($relatedTour['title']); ?>" 
                                     loading="lazy" 
                                     width="400" 
                                     height="225">
                            </picture>
                        </div>
                        <div class="tour-card-content">
                            <h3 class="tour-card-title"><?php echo htmlspecialchars($relatedTour['title']); ?></h3>
                            <p class="tour-card-excerpt"><?php echo htmlspecialchars($relatedTour['excerpt'] ?? ''); ?></p>
                            <div class="tour-card-footer">
                                <span class="tour-price">From <?php echo htmlspecialchars($relatedTour['currency'] ?? 'USD'); ?> <?php echo number_format($relatedTour['price_from'] ?? 0, 2); ?></span>
                            </div>
                        </div>
                    </a>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </div>
</section>

<!-- JSON-LD for Tour -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "TouristTrip",
  "name": "<?php echo htmlspecialchars($tour['title']); ?>",
  "description": "<?php echo htmlspecialchars($tour['excerpt'] ?? $tour['title']); ?>",
  "tourBookingPage": "<?php echo BASE_URL; ?>/contact#booking",
  "provider": {
    "@type": "TravelAgency",
    "name": "Direction Wise Tourism LLC",
    "telephone": "+971528492942"
  },
  "offers": {
    "@type": "Offer",
    "price": "<?php echo $tour['price_from'] ?? 0; ?>",
    "priceCurrency": "<?php echo $tour['currency'] ?? 'USD'; ?>",
    "availability": "https://schema.org/InStock"
  },
  "duration": "<?php echo htmlspecialchars($tour['duration'] ?? ''); ?>"
}
</script>

<!-- BreadcrumbList Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "<?php echo BASE_URL; ?>/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Tours",
      "item": "<?php echo BASE_URL; ?>/tours"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "<?php echo htmlspecialchars($tour['title']); ?>",
      "item": "<?php echo BASE_URL; ?>/tour/<?php echo htmlspecialchars($tour['slug'] ?? $tour['id']); ?>"
    }
  ]
}
</script>

