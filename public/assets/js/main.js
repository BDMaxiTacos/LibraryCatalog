$('.select2-multiple').select2({
    placeholder: '---',
    allowClear: true
});

const toastElList = document.querySelectorAll('.toast')
const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl))

let bookNav = document.querySelector('.nav-tabs.book-tabs');
if(bookNav){
    let tabs = bookNav.querySelectorAll('.nav-link');

    tabs.forEach((tab) => {
        tab.addEventListener('click', (e) => changeTab(e, tabs));
    });
}

function changeTab(e, tabs){
    tabs.forEach((tab) => {
        if(e.target == tab){
            tab.classList.add('active');
            $(`#${tab.dataset.target}`)[0].style.display = 'block';
        }else{
            tab.classList.remove('active');
            $(`#${tab.dataset.target}`)[0].style.display = 'none';
        }
    });
}

let ratingStars = document.querySelector('#add-comment');
if(ratingStars){
    let stars = ratingStars.querySelectorAll('.bi-star');

    stars.forEach((star) => {
        star.addEventListener('click', (e) => setRating(e, stars));
    });

    stars.forEach((star) => {
        star.addEventListener('mouseover', (e) => setFill(e, stars));
    });

    stars.forEach((star) => {
        star.addEventListener('mouseleave', (e) => removeFill(e, stars));
    });
}

function setRating(e, stars){
    let targetDone = false;
    stars.forEach((star) => {
        if(!targetDone){
            star.classList.add('bi-star-fill');
            star.classList.add('locked');
            star.classList.remove('bi-star');
            if(star == e.target){
                targetDone = true;
            }
        }else{
            star.classList.add('bi-star');
            star.classList.remove('bi-star-fill');
            star.classList.remove('locked');
        }
    });
    document.getElementById('comment_rating').value = e.target.dataset.value;
}

function setFill(e, stars){
    let targetDone = false;
    if(!e.target.classList.contains('locked')){
        stars.forEach((star) => {
            if(!targetDone && !star.classList.contains('locked')){
                star.classList.add('bi-star-fill');
                star.classList.remove('bi-star');
                if(star == e.target){
                    targetDone = true;
                }
            }
        });
    }
}

function removeFill(e, stars){
    let targetDone = false;
    if(!e.target.classList.contains('locked')){
        stars.forEach((star) => {
            if(!targetDone && !star.classList.contains('locked')){
                star.classList.add('bi-star');
                star.classList.remove('bi-star-fill');
                if(star == e.target){
                    targetDone = true;
                }
            }
        });
    }
}