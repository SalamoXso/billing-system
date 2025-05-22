// Toggle sidebar on mobile
document.addEventListener("DOMContentLoaded", () => {
  const sidebarToggle = document.getElementById("sidebar-toggle")
  const sidebar = document.querySelector(".sidebar")

  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener("click", () => {
      sidebar.classList.toggle("open")
    })
  }

  // Close sidebar when clicking outside on mobile
  document.addEventListener("click", (event) => {
    if (
      window.innerWidth <= 768 &&
      sidebar &&
      !sidebar.contains(event.target) &&
      sidebarToggle &&
      !sidebarToggle.contains(event.target) &&
      sidebar.classList.contains("open")
    ) {
      sidebar.classList.remove("open")
    }
  })
})
