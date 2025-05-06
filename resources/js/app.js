import './bootstrap';
import Alpine from 'alpinejs';

document.addEventListener('alpine:init', () => {
  Alpine.store('sidebar', {
      open: window.innerWidth >= 1024 ? 
            (localStorage.getItem('sidebar-open') !== 'false') : 
            false,
      mobileOpen: false,
      
      toggle() {
          if (window.innerWidth < 1024) {
              this.mobileOpen = !this.mobileOpen;
          } else {
              this.open = !this.open;
              localStorage.setItem('sidebar-open', this.open);
          }
      },
      
      close() {
          if (window.innerWidth < 1024) {
              this.mobileOpen = false;
          } else {
              this.open = false;
              localStorage.setItem('sidebar-open', false);
          }
      },
      
      init() {
          // Set initial state based on screen size
          if (window.innerWidth >= 1024) {
              this.open = localStorage.getItem('sidebar-open') !== 'false';
          }
          
          // Handle window resize
          window.addEventListener('resize', () => {
              if (window.innerWidth >= 1024) {
                  this.mobileOpen = false;
              } else {
                  this.open = false;
              }
          });
      }
  });
});

window.Alpine = Alpine;
Alpine.start();