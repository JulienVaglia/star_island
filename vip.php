<html>

<head>


    <link rel="stylesheet" href="assets/css/vip.css">
    <link type="text/css" rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Karla' rel='stylesheet' type='text/css'>
</head>


    <div class="slider-container">

        <div class="slider-content">

            <div class="slider-single">
                <img class="slider-single-image" src="assets/img/Loading_2.png" alt="1" />
            </div>

            <div class="slider-single">
                <img class="slider-single-image" src="assets/img/Loading1.png" alt="2" />
            </div>

            <div class="slider-single">
                <img class="slider-single-image" src="assets/img/Loading_2.png" alt="3" />
            </div>


            <div class="slider-single">
                <img class="slider-single-image" src="assets/img/Plan_de_travail_1-1.png" alt="4" />
            </div>


            <div class="slider-single">
                <img class="slider-single-image" src="assets/img/amanda.png" alt="5" />
            </div>

            <div class="slider-single">
                <img class="slider-single-image" src="assets/img/Plan_de_travail_1-4.png" alt="6" />
            </div>
        </div>
    </div>
    <script>
        const repeat = false;
        const noArrows = false;
        const noBullets = false;


        const container = document.querySelector('.slider-container');
        var slide = document.querySelectorAll('.slider-single');
        var slideTotal = slide.length - 1;
        var slideCurrent = -1;

        function initBullets() {
            if (noBullets) {
                return;
            }
            const bulletContainer = document.createElement('div');
            bulletContainer.classList.add('bullet-container')
            slide.forEach((elem, i) => {
                const bullet = document.createElement('div');
                bullet.classList.add('bullet')
                bullet.id = `bullet-index-${i}`
                bullet.addEventListener('click', () => {
                    goToIndexSlide(i);
                })
                bulletContainer.appendChild(bullet);
                elem.classList.add('proactivede');
            })
            container.appendChild(bulletContainer);
        }

        function initArrows() {
            if (noArrows) {
                return;
            }
            const leftArrow = document.createElement('a')
            const iLeft = document.createElement('i');
            iLeft.classList.add('fa')
            iLeft.classList.add('fa-arrow-left')
            leftArrow.classList.add('slider-left')
            leftArrow.appendChild(iLeft)
            leftArrow.addEventListener('click', () => {
                slideLeft();
            })
            const rightArrow = document.createElement('a')
            const iRight = document.createElement('i');
            iRight.classList.add('fa')
            iRight.classList.add('fa-arrow-right')
            rightArrow.classList.add('slider-right')
            rightArrow.appendChild(iRight)
            rightArrow.addEventListener('click', () => {
                slideRight();
            })
            container.appendChild(leftArrow);
            container.appendChild(rightArrow);
        }

        function slideInitial() {
            initBullets();
            initArrows();
            setTimeout(function() {
                slideRight();
            }, 500);
        }

        function updateBullet() {
            if (!noBullets) {
                document.querySelector('.bullet-container').querySelectorAll('.bullet').forEach((elem, i) => {
                    elem.classList.remove('active');
                    if (i === slideCurrent) {
                        elem.classList.add('active');
                    }
                })
            }
            checkRepeat();
        }

        function checkRepeat() {
            if (!repeat) {
                if (slideCurrent === slide.length - 1) {
                    slide[0].classList.add('not-visible');
                    slide[slide.length - 1].classList.remove('not-visible');
                    if (!noArrows) {
                        document.querySelector('.slider-right').classList.add('not-visible')
                        document.querySelector('.slider-left').classList.remove('not-visible')
                    }
                } else if (slideCurrent === 0) {
                    slide[slide.length - 1].classList.add('not-visible');
                    slide[0].classList.remove('not-visible');
                    if (!noArrows) {
                        document.querySelector('.slider-left').classList.add('not-visible')
                        document.querySelector('.slider-right').classList.remove('not-visible')
                    }
                } else {
                    slide[slide.length - 1].classList.remove('not-visible');
                    slide[0].classList.remove('not-visible');
                    if (!noArrows) {
                        document.querySelector('.slider-left').classList.remove('not-visible')
                        document.querySelector('.slider-right').classList.remove('not-visible')
                    }
                }
            }
        }

        function slideRight() {
            if (slideCurrent < slideTotal) {
                slideCurrent++;
            } else {
                slideCurrent = 0;
            }

            if (slideCurrent > 0) {
                var preactiveSlide = slide[slideCurrent - 1];
            } else {
                var preactiveSlide = slide[slideTotal];
            }
            var activeSlide = slide[slideCurrent];
            if (slideCurrent < slideTotal) {
                var proactiveSlide = slide[slideCurrent + 1];
            } else {
                var proactiveSlide = slide[0];

            }

            slide.forEach((elem) => {
                var thisSlide = elem;
                if (thisSlide.classList.contains('preactivede')) {
                    thisSlide.classList.remove('preactivede');
                    thisSlide.classList.remove('preactive');
                    thisSlide.classList.remove('active');
                    thisSlide.classList.remove('proactive');
                    thisSlide.classList.add('proactivede');
                }
                if (thisSlide.classList.contains('preactive')) {
                    thisSlide.classList.remove('preactive');
                    thisSlide.classList.remove('active');
                    thisSlide.classList.remove('proactive');
                    thisSlide.classList.remove('proactivede');
                    thisSlide.classList.add('preactivede');
                }
            });
            preactiveSlide.classList.remove('preactivede');
            preactiveSlide.classList.remove('active');
            preactiveSlide.classList.remove('proactive');
            preactiveSlide.classList.remove('proactivede');
            preactiveSlide.classList.add('preactive');

            activeSlide.classList.remove('preactivede');
            activeSlide.classList.remove('preactive');
            activeSlide.classList.remove('proactive');
            activeSlide.classList.remove('proactivede');
            activeSlide.classList.add('active');

            proactiveSlide.classList.remove('preactivede');
            proactiveSlide.classList.remove('preactive');
            proactiveSlide.classList.remove('active');
            proactiveSlide.classList.remove('proactivede');
            proactiveSlide.classList.add('proactive');

            updateBullet();
        }

        function slideLeft() {
            if (slideCurrent > 0) {
                slideCurrent--;
            } else {
                slideCurrent = slideTotal;
            }

            if (slideCurrent < slideTotal) {
                var proactiveSlide = slide[slideCurrent + 1];
            } else {
                var proactiveSlide = slide[0];
            }
            var activeSlide = slide[slideCurrent];
            if (slideCurrent > 0) {
                var preactiveSlide = slide[slideCurrent - 1];
            } else {
                var preactiveSlide = slide[slideTotal];
            }
            slide.forEach((elem) => {
                var thisSlide = elem;
                if (thisSlide.classList.contains('proactive')) {
                    thisSlide.classList.remove('preactivede');
                    thisSlide.classList.remove('preactive');
                    thisSlide.classList.remove('active');
                    thisSlide.classList.remove('proactive');
                    thisSlide.classList.add('proactivede');
                }
                if (thisSlide.classList.contains('proactivede')) {
                    thisSlide.classList.remove('preactive');
                    thisSlide.classList.remove('active');
                    thisSlide.classList.remove('proactive');
                    thisSlide.classList.remove('proactivede');
                    thisSlide.classList.add('preactivede');
                }
            });

            preactiveSlide.classList.remove('preactivede');
            preactiveSlide.classList.remove('active');
            preactiveSlide.classList.remove('proactive');
            preactiveSlide.classList.remove('proactivede');
            preactiveSlide.classList.add('preactive');

            activeSlide.classList.remove('preactivede');
            activeSlide.classList.remove('preactive');
            activeSlide.classList.remove('proactive');
            activeSlide.classList.remove('proactivede');
            activeSlide.classList.add('active');

            proactiveSlide.classList.remove('preactivede');
            proactiveSlide.classList.remove('preactive');
            proactiveSlide.classList.remove('active');
            proactiveSlide.classList.remove('proactivede');
            proactiveSlide.classList.add('proactive');

            updateBullet();
        }

        function goToIndexSlide(index) {
            const sliding = (slideCurrent > index) ? () => slideRight() : () => slideLeft();
            while (slideCurrent !== index) {
                sliding();
            }
        }

        slideInitial();
    </script>

</body>

</html>