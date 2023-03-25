const navLainnya = document.querySelector(".navLainnya");
const navigasi = document.getElementById("navigasi");



navLainnya.addEventListener("click", function () {
  this.classList.toggle("active");
  navigasi.classList.toggle("navActive");
});
