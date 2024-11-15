function toggleDropdown(id, element) {
    // Toggle the display of the dropdown
    const dropdown = document.getElementById(id);
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    
    // Toggle the rotation of the arrow
    const arrow = element.querySelector('.arrow');
    arrow.classList.toggle('rotate');
}