import Alpine from "alpinejs"

document.addEventListener("alpine:init", () => {
  Alpine.store("sidebar", {
    open: localStorage.getItem("sidebar-open") !== "false",
    toggle() {
      this.open = !this.open
      localStorage.setItem("sidebar-open", this.open)
    },
  })
})

// Mobile sidebar toggle
document.addEventListener("DOMContentLoaded", () => {
  const mobileToggle = document.querySelector('[x-data="{ sidebarOpen: false }"]')
  if (mobileToggle) {
    const button = mobileToggle.querySelector("button")
    const sidebar = document.querySelector(".sidebar-container")

    if (button && sidebar) {
      button.addEventListener("click", () => {
        const isOpen = sidebar.classList.contains("translate-x-0")
        if (isOpen) {
          sidebar.classList.remove("translate-x-0")
          sidebar.classList.add("-translate-x-full")
        } else {
          sidebar.classList.add("translate-x-0")
          sidebar.classList.remove("-translate-x-full")
        }
      })
    }
  }
})
