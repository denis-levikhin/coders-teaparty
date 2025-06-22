document.addEventListener('DOMContentLoaded', function () {
    if (window.innerWidth > 1024) {
        function createStars(i) {
            for (var i; i; i--) {
                drawStars();
            }
        }

        function drawStars() {
            var tmpStar = document.createElement('figure')
            tmpStar.className = "star";
            tmpStar.style.opacity = 0;
            tmpStar.style.top = 100 * Math.random() + '%';
            tmpStar.style.left = 100 * Math.random() + '%';
            document.getElementById('sky').appendChild(tmpStar);
        }

        function selectStars() {
            stars = document.querySelectorAll(".star");
        }

        function animateStars() {
            Array.prototype.forEach.call(stars, function (el, i) {
                TweenMax.to(el, Math.random() * 0.5 + 0.5, { opacity: Math.random(), onComplete: animateStars });
            });
        }

        createStars(150);
        selectStars();
        animateStars();
    }
}, false);