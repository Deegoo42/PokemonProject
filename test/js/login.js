let Rbutton = document.querySelector('#registerP');
let inlog = document.querySelector('#inloggen')
let Ibutton = document.querySelector('#inloggenP');
let registreer = document.querySelector('#registreren');

Rbutton.addEventListener('click', function() {
    inlog.classList.add('hide');
    registreer.classList.remove('hide');
    Ibutton.classList.remove('hide');
    Rbutton.classList.add('hide');
});
Ibutton.addEventListener('click', function() {
    inlog.classList.remove('hide');
    registreer.classList.add('hide');
    Ibutton.classList.add('hide');
    Rbutton.classList.remove('hide');
});