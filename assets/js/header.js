document.addEventListener("DOMContentLoaded", () => {
    const sunIcon = document.getElementById("sun-icon");
    const navbarToggler = document.querySelector(".navbar-toggler");
    const navbarNav = document.querySelector(".navbar-nav");
    const modeToggle = document.getElementById("mode-toggle");
  
    // Function to toggle dark mode
    const toggleDarkMode = () => {
      const isDarkMode =
        document.documentElement.getAttribute("data-theme") === "dark";
      document.documentElement.setAttribute(
        "data-theme",
        isDarkMode ? "light" : "dark"
      );
      sunIcon.style.color = isDarkMode ? "black" : "yellow";
    };
  
    // Toggle dark mode on sun icon click
    modeToggle.addEventListener("click", toggleDarkMode);
  
    // Toggle navbar on navbar toggler click
    navbarToggler.addEventListener("click", () => {
      navbarNav.classList.toggle("active");
    });
  });
  