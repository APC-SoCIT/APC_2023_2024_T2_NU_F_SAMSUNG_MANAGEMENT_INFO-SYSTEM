function toggleDropdown() {
	var dropdownContent = document.getElementById("dropdownContent");
	dropdownContent.style.display = (dropdownContent.style.display === "block") ? "none" : "block";

	var dpdownicon = document.querySelector(".dropdown-icon");
	dpdownicon.classList.toggle('rotated');
}
