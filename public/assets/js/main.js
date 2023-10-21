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