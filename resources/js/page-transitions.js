/**
 * Modern Page Transition System
 * Smooth, elegant transitions between pages
 */

class ModernPageTransition {
    constructor() {
        this.isTransitioning = false;
        this.transitionDuration = 800; // milliseconds
        this.init();
    }

    init() {
        // Only run on non-admin pages
        if (this.isAdminPage()) {
            console.log('Admin page detected - transitions disabled');
            return;
        }

        this.createOverlay();
        this.attachEventListeners();
        this.handleInitialLoad();
        
        console.log('✓ Page transitions initialized');
    }

    isAdminPage() {
        return window.location.pathname.startsWith('/admin') || 
               document.body.classList.contains('admin-layout') ||
               document.body.dataset.layout === 'admin';
    }

    createOverlay() {
        // Create transition overlay
        const overlay = document.createElement('div');
        overlay.id = 'pageTransitionOverlay';
        overlay.innerHTML = `
            <div class="transition-content">
                <div class="transition-logo">
                    <img src="/images/Jauxsh.png" alt="Logo">
                </div>
                <div class="transition-loader">
                    <div class="loader-bar"></div>
                </div>
            </div>
        `;
        document.body.appendChild(overlay);
        this.overlay = overlay;

        // Add styles
        this.addStyles();
    }

    addStyles() {
        if (document.getElementById('pageTransitionStyles')) return;

        const styles = document.createElement('style');
        styles.id = 'pageTransitionStyles';
        styles.textContent = `
            #pageTransitionOverlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: linear-gradient(135deg, #d8e8e7 0%, #b8d8d6 100%);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            #pageTransitionOverlay.active {
                opacity: 1;
                pointer-events: auto;
            }

            .transition-content {
                text-align: center;
                transform: scale(0.9);
                opacity: 0;
                transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1) 0.2s;
            }

            #pageTransitionOverlay.active .transition-content {
                transform: scale(1);
                opacity: 1;
            }

            .transition-logo {
                width: 80px;
                height: 80px;
                margin: 0 auto 30px;
                animation: float 2s ease-in-out infinite;
            }

            .transition-logo img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                filter: drop-shadow(0 4px 12px rgba(31, 172, 153, 0.3));
            }

            .transition-loader {
                width: 200px;
                height: 3px;
                background: rgba(0, 0, 0, 0.1);
                border-radius: 3px;
                overflow: hidden;
                margin: 0 auto;
            }

            .loader-bar {
                width: 0%;
                height: 100%;
                background: linear-gradient(90deg, #1fac99ff, #179383);
                border-radius: 3px;
                transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            }

            #pageTransitionOverlay.active .loader-bar {
                width: 100%;
            }

            @keyframes float {
                0%, 100% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-10px);
                }
            }

            /* Fade out current page content */
            body.page-transitioning main {
                opacity: 0.7;
                transform: scale(0.98);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Keep navbar visible during transition */
            body.page-transitioning #navbar {
                opacity: 0.8;
                transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Hide sliders during transition */
            body.page-transitioning #shopSlider,
            body.page-transitioning #cartSlider {
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
        `;
        document.head.appendChild(styles);
    }

    handleInitialLoad() {
        // Fade in the page on initial load
        document.body.style.opacity = '0';
        
        requestAnimationFrame(() => {
            document.body.style.transition = 'opacity 0.5s ease';
            document.body.style.opacity = '1';
            
            setTimeout(() => {
                document.body.style.transition = '';
            }, 500);
        });
    }

    attachEventListeners() {
        // Intercept all link clicks
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            
            if (!link) return;

            const href = link.getAttribute('href');
            
            // Skip if:
            // - No href or just hash
            // - Already transitioning
            // - Has data-no-transition attribute
            // - External link
            // - Has target attribute (opens in new tab)
            // - Has download attribute
            // - Is a mailto or tel link
            // - Triggers sliders (contains # or javascript)
            if (!href || 
                href === '#' || 
                this.isTransitioning ||
                link.hasAttribute('data-no-transition') ||
                link.hasAttribute('target') ||
                link.hasAttribute('download') ||
                href.startsWith('mailto:') ||
                href.startsWith('tel:') ||
                href.includes('javascript:') ||
                !this.isInternalLink(href)) {
                return;
            }

            // Check if link is inside a slider or triggers slider functions
            const onclick = link.getAttribute('onclick');
            if (onclick && (onclick.includes('Slider') || onclick.includes('event.preventDefault'))) {
                return;
            }

            // Prevent default and start transition
            e.preventDefault();
            e.stopPropagation();
            
            this.navigate(href);
        }, true);

        // Handle browser back/forward buttons
        window.addEventListener('popstate', (e) => {
            if (!this.isTransitioning) {
                this.navigate(window.location.href, false);
            }
        });
    }

    isInternalLink(href) {
        // Check if it's a relative URL
        if (!href.startsWith('http://') && !href.startsWith('https://')) {
            return true;
        }

        // Check if it's the same domain
        try {
            const url = new URL(href);
            return url.hostname === window.location.hostname;
        } catch (e) {
            return false;
        }
    }

    async navigate(url, updateHistory = true) {
        if (this.isTransitioning) return;
        
        console.log('→ Navigating to:', url);
        
        this.isTransitioning = true;

        // Close any open sliders before transition
        this.closeSliders();

        // Start transition
        await this.transitionOut();

        // Update history if needed
        if (updateHistory) {
            window.history.pushState({ path: url }, '', url);
        }

        // Navigate to new page
        window.location.href = url;
    }

    closeSliders() {
        // Close shop slider if open
        if (typeof closeShopSlider === 'function') {
            closeShopSlider();
        }

        // Close cart slider if open
        if (typeof closeCartSlider === 'function') {
            closeCartSlider();
        }

        // Hide backdrop
        if (typeof hideBackdrop === 'function') {
            hideBackdrop();
        }
    }

    transitionOut() {
        return new Promise((resolve) => {
            // Add transitioning class to body
            document.body.classList.add('page-transitioning');

            // Show overlay
            this.overlay.classList.add('active');

            // Wait for transition to complete
            setTimeout(() => {
                resolve();
            }, this.transitionDuration);
        });
    }

    // Public method to disable transitions for specific navigation
    static disableNext() {
        if (window.modernPageTransition) {
            window.modernPageTransition.skipNext = true;
        }
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.modernPageTransition = new ModernPageTransition();
    });
} else {
    window.modernPageTransition = new ModernPageTransition();
}

// Export for use in other scripts
window.ModernPageTransition = ModernPageTransition;