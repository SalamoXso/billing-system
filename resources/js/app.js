import './bootstrap';
import Alpine from 'alpinejs';



window.Alpine = Alpine;

Alpine.start();

// Initialize Alpine.js store on page load
document.addEventListener("DOMContentLoaded", () => {
  if (window.Alpine) {
    window.Alpine.store("sidebar").init()
  }
})
