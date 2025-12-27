/**
 * Singlo Star Rating Hover Effect
 * Implements hover-to-fill star rating functionality
 */

(function() {
    'use strict';

    function initStarRatingHover() {
        const starContainers = document.querySelectorAll('.stars-outer');
        
        starContainers.forEach(function(container) {
            const starsInner = container.querySelector('.stars-inner');
            const starsHover = container.querySelector('.stars-hover');
            const interactSpans = container.querySelectorAll('.stars-interact span');
            const originalRating = parseFloat(container.getAttribute('data-rating')) || 0;
            const originalWidth = (originalRating / 5) * 100;
            
            if (!starsInner || !starsHover || !interactSpans.length) {
                return;
            }

            interactSpans.forEach(function(span) {
                span.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.getAttribute('data-val'));
                    const width = (rating / 5) * 100;
                    starsHover.style.width = width + '%';
                });

                span.addEventListener('click', function() {
                    const rating = parseInt(this.getAttribute('data-val'));
                    const postId = this.closest('.singlo-star-rating')?.getAttribute('data-post-id');
                    const nonce = this.closest('.singlo-star-rating')?.getAttribute('data-nonce');
                    
                    if (postId && nonce && typeof jQuery !== 'undefined' && typeof ajaxurl !== 'undefined') {
                        jQuery.ajax({
                            url: ajaxurl,
                            type: 'POST',
                            data: {
                                action: 'singlo_rate_post',
                                post_id: postId,
                                rating: rating,
                                nonce: nonce
                            },
                            success: function(response) {
                                if (response.success) {
                                    const newAvg = response.data.new_avg;
                                    const newCount = response.data.new_count;
                                    const newWidth = (newAvg / 5) * 100;
                                    
                                    starsInner.style.width = newWidth + '%';
                                    container.setAttribute('data-rating', newAvg);
                                    
                                    const ratingValueEl = container.closest('.singlo-star-rating')?.querySelector('.TT9eCd');
                                    const reviewCountEl = container.closest('.singlo-star-rating')?.querySelector('.g1rdde');
                                    
                                    if (ratingValueEl) {
                                        ratingValueEl.innerHTML = newAvg + ' <i class="google-material-icons notranslate ERwvGb" aria-hidden="true" style="font-style: normal; margin-left: 2px;">★</i>';
                                    }
                                    
                                    if (reviewCountEl) {
                                        reviewCountEl.textContent = newCount + ' reviews';
                                    }
                                    
                                    alert(response.data.message || 'Thank you for your rating!');
                                }
                            }
                        });
                    }
                });
            });

            container.addEventListener('mouseleave', function() {
                starsHover.style.width = '0%';
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initStarRatingHover);
    } else {
        initStarRatingHover();
    }
})();
