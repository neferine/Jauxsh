/**
 * Page Transitions Script
 * Direction-aware page transitions for smooth navigation
 */

document.addEventListener('DOMContentLoaded', function() {
    const transition = document.getElementById('page-transition');
    const pageWrapper = document.getElementById('page-wrapper');
    const body = document.body;
    const navbar = document.getElementById('navbar');
    
    // Store navigation history for back/forward detection
    let navigationStack = [];
    let currentPath = window.location.pathname;
    
    // Page hierarchy for intelligent direction detection
    const pageHierarchy = {
        '/': 0,
        '/home': 0,
        '/shop': 1,
        '/products': 1,
        '/categories': 1,
        '/about': 2,
        '/contact': 2,
        '/cart': 3,
        '/checkout': 4,
        '/profile': 2,
        '/orders': 3
    };
    
    // Fade in page on load
    setTimeout(() => {
        body.classList.add('loaded');
    }, 100);

    /**
     * Determine transition direction based on navigation context
     */
    function getTransitionDirection(fromPath, toPath, isBack = false) {
        // Check if it's a back navigation
        if (isBack) {
            return { page: 'slide-right', overlay: 'from-left' };
        }
        
        // Get hierarchy levels
        const fromLevel = pageHierarchy[fromPath] ?? 1;
        const toLevel = pageHierarchy[toPath] ?? 1;
        
        // Navigation rules:
        // - Forward in hierarchy: slide left (new page from right)
        // - Backward in hierarchy: slide right (new page from left)
        // - Same level: fade transition
        // - Cart/Checkout: slide up (modal-like)
        
        if (toPath.includes('/cart') || toPath.includes('/checkout')) {
            return { page: 'slide-up', overlay: 'from-bottom' };
        }
        
        if (fromPath.includes('/cart') || fromPath.includes('/checkout')) {
            return { page: 'slide-down', overlay: 'from-top' };
        }
        
        if (toLevel > fromLevel) {
            return { page: 'slide-left', overlay: 'from-right' };
        } else if (toLevel < fromLevel) {
            return { page: 'slide-right', overlay: 'from-left' };
        } else {
            return { page: 'fade-out', overlay: 'fade-in' };
        }
    }

    /**
     * Execute page transition - Optimized for performance
     */
    function executeTransition(destination, direction) {
        // Start transition
        transition.style.pointerEvents = 'auto';
        body.classList.add('transitioning');
        
        // Apply direction class to old page
        body.classList.add(direction.page);
        
        // Fade in overlay
        requestAnimationFrame(() => {
            transition.classList.add('active');
        });
        
        // Navigate to new page (faster timing)
        setTimeout(() => {
            window.location.href = destination;
        }, 400);
    }

    /**
     * Handle link clicks with direction detection
     */
    function handleLinkClick(e) {
        const link = e.target.closest('a');
        
        if (link && 
            link.href && 
            link.href.startsWith(window.location.origin) && 
            !link.href.includes('#') &&
            link.target !== '_blank' &&
            !link.hasAttribute('download')) {
            
            e.preventDefault();
            const destination = link.href;
            const destinationPath = new URL(destination).pathname;
            
            // Detect if this is a back navigation
            const isBackNavigation = navigationStack.includes(destinationPath);
            
            // Get transition direction
            const direction = getTransitionDirection(
                currentPath, 
                destinationPath, 
                isBackNavigation
            );
            
            // Update navigation stack
            if (!isBackNavigation) {
                navigationStack.push(currentPath);
            }
            
            // Execute transition
            executeTransition(destination, direction);
        }
    }

    // Attach to navbar links
    if (navbar) {
        navbar.addEventListener('click', handleLinkClick);
    }

    // Optional: Attach to all internal links on the page
    // Uncomment to enable transitions for all links, not just navbar
    /*
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && !link.closest('#navbar')) {
            handleLinkClick(e);
        }
    });
    */

    // Handle browser back/forward buttons
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            // Reset all transition states
            transition.classList.remove('active');
            transition.style.pointerEvents = 'none';
            body.classList.remove('transitioning', 'slide-left', 'slide-right', 'slide-up', 'slide-down', 'fade-out');
            body.classList.add('loaded');
            pageWrapper.style.transform = '';
            pageWrapper.style.opacity = '';
        }
    });

    // Reset transition on page unload
    window.addEventListener('beforeunload', function() {
        transition.classList.remove('active');
        body.classList.remove('transitioning');
    });

    // Store current path on load
    sessionStorage.setItem('lastPath', currentPath);
});