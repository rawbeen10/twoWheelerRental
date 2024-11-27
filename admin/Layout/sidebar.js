function toggleDropdown(id, element) {
    const dropdown = document.getElementById(id);
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    
    const arrow = element.querySelector('.arrow');
    arrow.classList.toggle('rotate');
}