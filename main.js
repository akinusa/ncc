import './style.css'

// Load Header
function loadHeader() {
  const header = `
    <nav class="nav-container">
      <a href="index.html" class="logo">
        🛡️ NCC Unit
      </a>

      <button class="mobile-menu-btn" aria-label="Toggle navigation">☰</button>

      <div class="nav-links">
        <a href="index.html">Home</a>
        <a href="about.html">About</a>
        <a href="activities.html">Activities</a>
        <a href="gallery.html">Gallery</a>
        <a href="news.html">News</a>
        <a href="contact.html">Contact</a>
        <a href="enrollment.html">Join NCC</a>
        <a href="login.php">Cadet Login</a>
        <a href="admin-login.php">Admin</a>
      </div>
    </nav>
  `;

  document.querySelector("header").innerHTML = header;

  // Highlight active link
  const currentPage = window.location.pathname.split("/").pop();
  const links = document.querySelectorAll(".nav-links a");

  links.forEach(link => {
    if (link.getAttribute("href") === currentPage) {
      link.classList.add("active");
    }
  });

  // Mobile toggle
  const menuBtn = document.querySelector(".mobile-menu-btn");
  const navLinks = document.querySelector(".nav-links");

  menuBtn.addEventListener("click", () => {
    navLinks.classList.toggle("active");
  });
}


// Load Footer
function loadFooter() {
  const footer = `
    <div class="footer-content">
      <div class="footer-section">
        <h3>About NCC</h3>
        <p>
          Developing character, comradeship, discipline and leadership
          among the youth of India.
        </p>
      </div>

      <div class="footer-section">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="enrollment.html">Join NCC</a></li>
          <li><a href="login.php">Cadet Login</a></li>
          <li><a href="admin-login.php">Admin Panel</a></li>
        </ul>
      </div>

      <div class="footer-section">
        <h3>Contact</h3>
        <p>📍 College Campus</p>
        <p>📧 ncc@college.edu</p>
        <p>📞 +91 98765 43210</p>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; ${new Date().getFullYear()} College NCC Unit. All Rights Reserved.</p>
    </div>
  `;

  document.querySelector("footer").innerHTML = footer;
}


// Initialize
document.addEventListener("DOMContentLoaded", () => {
  if (document.querySelector("header")) loadHeader();
  if (document.querySelector("footer")) loadFooter();
});