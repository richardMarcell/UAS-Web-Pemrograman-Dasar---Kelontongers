const navLainnya = document.querySelector(".navLainnya");
const navigasi = document.getElementById("navigasi");



navLainnya.addEventListener("click", function () {
  this.classList.toggle("active");
  navigasi.classList.toggle("navActive");
});

function loadPage(page) {
  $.ajax({
    url: 'load_page.php?page=' + page,
    type: 'GET',
    success: function(response) {
      $('.storesBox').html(response);
    }
  });
}