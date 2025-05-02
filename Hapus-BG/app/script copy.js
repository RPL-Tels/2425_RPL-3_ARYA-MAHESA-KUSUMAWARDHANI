

document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll("section");
    const navLinks = document.querySelectorAll("header nav a");
  
    window.addEventListener("scroll", function () {
      let current = "";
  
      sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
  
        if (pageYOffset >= sectionTop - sectionHeight / 3) {
          current = section.getAttribute("id");
        }
      });
  
      navLinks.forEach((a) => {
        a.classList.remove("selected");
        if (a.getAttribute("href").slice(1) === current) {
          a.classList.add("selected");
        }
      });
    });
  });
