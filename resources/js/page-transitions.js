// page-transition.js
class PageTransition {
    constructor() {
        this.isTransitioning = false;
        this.init();
    }

    init() {
        // Create transition elements
        this.createTransitionElements();
        
        // Handle all internal links
        this.attachLinkListeners();
        
        // Handle browser back/forward
        window.addEventListener('popstate', (e) => {
            if (e.state && e.state.url) {
                this.navigateToPage(e.state.url, false);
            }
        });
        
        // Initial page load animation (fade in)
        this.animatePageEnter();
    }

    createTransitionElements() {
        // Create slide overlay
        const slide = document.createElement('div');
        slide.className = 'page-transition-slide';
        document.body.appendChild(slide);
        
        this.slide = slide;
        
        // Create wrapper for page content (excluding navbar, including main and footer)
        const wrapper = document.createElement('div');
        wrapper.className = 'page-transition-wrapper';
        
        // Move all body children into wrapper (except navbar and slide)
        const children = Array.from(document.body.children).filter(child => 
            child !== slide && 
            child.id !== 'navbar' &&
            !child.classList.contains('page-transition-slide')
        );
        
        children.forEach(child => {
            wrapper.appendChild(child);
        });
        
        document.body.insertBefore(wrapper, slide);
        
        this.mainContent = wrapper;
        this.navbar = document.getElementById('navbar');
    }

    animatePageExit(callback) {
        if (this.isTransitioning) return;
        this.isTransitioning = true;
        
        // Add transitioning class to body
        document.body.classList.add('transitioning');
        
        // Animate main content (perspective scale down)
        if (this.mainContent) {
            this.mainContent.style.transition = 'transform 1.2s cubic-bezier(0.76, 0, 0.24, 1), opacity 1.2s cubic-bezier(0.76, 0, 0.24, 1)';
            this.mainContent.style.transform = 'scale(0.9) translateY(-150px)';
            this.mainContent.style.opacity = '0.5';
        }
        
        // Animate navbar separately (keep it in view but fade and scale)
        if (this.navbar) {
            this.navbar.style.transition = 'transform 1.2s cubic-bezier(0.76, 0, 0.24, 1), opacity 1.2s cubic-bezier(0.76, 0, 0.24, 1)';
            this.navbar.style.opacity = '0.5';
        }
        
        // Animate slide up from bottom
        this.slide.style.transition = 'transform 1s cubic-bezier(0.76, 0, 0.24, 1)';
        this.slide.style.transform = 'translateY(0)';
        
        // Call callback when animation is done
        setTimeout(() => {
            if (callback) callback();
        }, 1200);
    }

    animatePageEnter() {
        // Start with content hidden
        if (this.mainContent) {
            this.mainContent.style.opacity = '0';
            this.mainContent.style.transition = 'opacity 0.7s ease';
        }
        
        // Fade in content
        requestAnimationFrame(() => {
            if (this.mainContent) {
                this.mainContent.style.opacity = '1';
            }
            
            // Reset navbar
            if (this.navbar) {
                this.navbar.style.opacity = '1';
            }
        });
        
        // Reset slide to bottom
        this.slide.style.transition = 'none';
        this.slide.style.transform = 'translateY(100vh)';
        
        // Reset main content transform
        if (this.mainContent) {
            setTimeout(() => {
                this.mainContent.style.transition = 'none';
                this.mainContent.style.transform = 'scale(1) translateY(0)';
                this.mainContent.style.opacity = '1';
            }, 500);
        }
        
        // Reset navbar transform
        if (this.navbar) {
            setTimeout(() => {
                this.navbar.style.transition = '';
                this.navbar.style.transform = '';
                this.navbar.style.opacity = '';
            }, 500);
        }
        
        // Remove transitioning class
        setTimeout(() => {
            document.body.classList.remove('transitioning');
            this.isTransitioning = false;
        }, 500);
    }

    attachLinkListeners() {
        document.addEventListener('click', (e) => {
            // Check if click is on a link or inside a link
            const link = e.target.closest('a');
            
            if (!link) return;
            
            const href = link.getAttribute('href');
            
            // Debug log
            console.log('Link clicked:', href, 'from element:', link);
            
            if (!href || href === '#' || this.isTransitioning) {
                console.log('Skipping link - href:', href, 'isTransitioning:', this.isTransitioning);
                return;
            }
            
            // Check if it's an internal link
            const isInternal = this.isInternalLink(href);
            console.log('Is internal link?', isInternal);
            
            if (isInternal && 
                !link.hasAttribute('target') &&
                !link.hasAttribute('download')) {
                
                e.preventDefault();
                e.stopPropagation();
                console.log('✓ Navigating with transition to:', href);
                this.navigateToPage(href);
            } else {
                console.log('Not triggering transition - target:', link.hasAttribute('target'), 'download:', link.hasAttribute('download'));
            }
        }, true); // Use capture phase
    }

    isInternalLink(href) {
        // Handle relative paths
        if (!href.startsWith('http://') && 
            !href.startsWith('https://') && 
            !href.startsWith('mailto:') && 
            !href.startsWith('tel:')) {
            return true;
        }
        
        // Handle absolute URLs - check if same origin
        try {
            const url = new URL(href, window.location.origin);
            return url.origin === window.location.origin;
        } catch (e) {
            return false;
        }
    }

    navigateToPage(url, pushState = true) {
        if (this.isTransitioning) return;
        
        console.log('Starting transition to:', url);
        
        // Animate exit
        this.animatePageExit(() => {
            console.log('Transition complete, navigating...');
            // Navigate to new page
            if (pushState && window.history.pushState) {
                window.history.pushState({ url }, '', url);
            }
            
            // Force navigation
            window.location.href = url;
        });
    }
}

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', () => {
    console.log('PageTransition initializing...');
    window.pageTransition = new PageTransition();
    console.log('PageTransition initialized successfully');
});

// Backup initialization if DOMContentLoaded already fired
if (document.readyState === 'loading') {
    // Still loading, wait for DOMContentLoaded
} else {
    // DOM already loaded
    console.log('DOM already loaded, initializing PageTransition immediately');
    window.pageTransition = new PageTransition();
}