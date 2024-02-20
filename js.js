document.addEventListener("DOMContentLoaded", function() {
    var header = document.getElementById('header');

    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) { // Здесь вы можете изменить значение для того, чтобы анимация начиналась при другом значении скролла
            header.classList.add('active');
        } else {
            header.classList.remove('active');
        }
    });
});
