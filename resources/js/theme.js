// Theme toggle functionality
document.addEventListener("DOMContentLoaded", () => {
  const themeToggle = document.getElementById("theme-toggle")
  const html = document.documentElement

  // Check for saved theme preference or use system preference
  const savedTheme = localStorage.getItem("theme")
  const systemPrefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches

  // Apply the theme
  if (savedTheme === "dark" || (!savedTheme && systemPrefersDark)) {
    html.classList.add("dark")
  } else {
    html.classList.remove("dark")
  }

  // Toggle theme when button is clicked
  if (themeToggle) {
    themeToggle.addEventListener("click", () => {
      html.classList.toggle("dark")

      // Save preference to localStorage
      if (html.classList.contains("dark")) {
        localStorage.setItem("theme", "dark")
      } else {
        localStorage.setItem("theme", "light")
      }
    })
  }
})
