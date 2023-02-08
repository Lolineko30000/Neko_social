

//-----------------------------------------

//sidebar
const menuItems = document.querySelectorAll('.menu-item');
//messages
const messagesNotification = document.querySelector('#messages-notification');
const messages = document.querySelector('.messages');
const message = document.querySelectorAll('.message');
const messageSearch = document.querySelector('#messages-search');
//Theme
const theme = document.querySelector('#theme');
const themeModal = document.querySelector('.customize-theme');
const fontSize = document.querySelectorAll('.choose-size span');
var root = document.querySelector(':root');
const colorPallette = document.querySelectorAll('.choose-color span');
const Bg1 = document.querySelector('.bg-1');
const Bg2 = document.querySelector('.bg-2');
const Bg3 = document.querySelector('.bg-3');

//remove active claas form all menu items
const changeActiveItem = () => {
    menuItems.forEach(item => {
        item.classList.remove('active');
    })
}
menuItems.forEach(item => {
    item.addEventListener('click', () => {
        changeActiveItem();
        item.classList.add('active');
        if(item.id != 'notifications'){
            document.querySelector('.notifications-popup').style.display = 'none';
        }else{
            window.location.href = "notificaciones.php";
          //document.querySelector('.notifications-popup').style.display = 'block';
          //document.querySelector('#notifications .notification-count').style.display = 'none';
        }
    })
})
menuItems.forEach(item => {
    item.addEventListener('click', () => {
        if(item.id == 'home'){
            window.location.href = "index.php";
        }
    })
})
menuItems.forEach(item => {
    item.addEventListener('click', () => {
        if(item.id == 'sub-photo'){
            window.location.href = "mi_cuenta.php";
        }
    })
})
menuItems.forEach(item => {
    item.addEventListener('click', () => {
        if(item.id == 'password'){
            window.location.href = "cambiar_contrasenia.php";
            //console.out("pan");
        }
    })
})
menuItems.forEach(item => {
    item.addEventListener('click', () => {
        if(item.id == 'profile'){
            window.location.href = "perfil.php";
        }
    })
})
menuItems.forEach(item => {
    item.addEventListener('click', () => {
        if(item.id == 'out'){
            window.location.href = "index.php?none=True";
        }
    })
})

//MESSAGES
//seaches chats
/*
const searchMessage = () => {
    const val = messageSearch.value.toLowerCase();
    message.forEach(user => {
        let name = user.querySelector('h5').textContent.toLowerCase();
        if(name.indexOf(val) != -1){
            user.style.display = 'flex';
        }else{
            user.style.display = 'none';
        }
    })
}
//search chat
//messageSearch.addEventListener('keyup',searchMessage);

//higthlight message card when message menu is clicked
messagesNotification.addEventListener('click', () => {
    messages.style.boxShadow = '0 0 1rem var(--color-primary)';
    messagesNotification.querySelector('.notification-count').style.display = 'none';
    setTimeout(() => {
        messages.style.boxShadow = 'none';
    },2000);
})*/
//theme/display customization
const openThemeModal=()=>{
    themeModal.style.display='grid';
}
//close modal
const closeThemeModal = (e) => {
    if(e.target.classList.contains('customize-theme')){
        themeModal.style.display = 'none';
    }
}

//close modal
themeModal.addEventListener('click', closeThemeModal);

theme.addEventListener('click', openThemeModal);


//fonts
//remove active class from spans or font size selectors
const removeSizeSelector = () => {
    fontSize.forEach(item => {
        item.classList.remove('active');
    })
}
fontSize.forEach(size => {
    size.addEventListener('click', () => {
        removeSizeSelector();
        let fontSize;
        size.classList.toggle('active');

        if(size.classList.contains('font-size-1')){
            fontSize = '10px';
            root.style.setProperty('----sticky-top-left','5.4rem');
            root.style.setProperty('----sticky-top-rigth','5.4rem');
        }else if(size.classList.contains('font-size-2')){
            fontSize = '13px';
            root.style.setProperty('----sticky-top-left','5.4rem');
            root.style.setProperty('----sticky-top-rigth','-7rem');
        }else if(size.classList.contains('font-size-3')){
            fontSize = '16px';
            root.style.setProperty('----sticky-top-left','-2rem');
            root.style.setProperty('----sticky-top-rigth','-17rem');
        }else if(size.classList.contains('font-size-4')){
            fontSize = '19px';
            root.style.setProperty('----sticky-top-left','-5rem');
            root.style.setProperty('----sticky-top-rigth','5.4rem');
        }else if(size.classList.contains('font-size-5')){
            fontSize = '22px';
            root.style.setProperty('----sticky-top-left','-12rem');
            root.style.setProperty('----sticky-top-rigth','-35rem');
        }
        document.querySelector('html').style.fontSize = fontSize;
    })


})

//changes primary color
//remove active class from colors
const changeAtiveColorClass = () => {
    colorPallette.forEach(colorPicker=>{
        colorPicker.classList.remove('active');
    })
}
colorPallette.forEach(color => {
    color.addEventListener('click', () => {
        let primaryHue;
        changeAtiveColorClass();
        if(color.classList.contains('color-1')){
            primaryHue = 252;
        }else if(color.classList.contains('color-2')){
            primaryHue = 52;
        }else if(color.classList.contains('color-3')){
            primaryHue = 352;
        }else if(color.classList.contains('color-4')){
            primaryHue = 152;
        }else if(color.classList.contains('color-5')){
            primaryHue = 202;
        }
        color.classList.add('active');
        root.style.setProperty('--primary-color-hue', primaryHue);
    })
})

//theme background values
let ligthColorLightness;
let whiteColorLightness;
let darkColorLightness;

//changes background color
const changeBG = () => {
    root.style.setProperty('--light-color-lightness', ligthColorLightness);
    root.style.setProperty('--white-color-lightness', whiteColorLightness);
    root.style.setProperty('--dark-color-lihtness', darkColorLightness);
}
Bg1.addEventListener('click', () => {
    Bg1.classList.add('active');
    Bg2.classList.remove('active');
    Bg3.classList.remove('active');
    window.location.reload();
})
Bg2.addEventListener('click', () => {
    darkColorLightness = '95%';
    ligthColorLightness = '20%';
    whiteColorLightness = '15%';
    //add active class to bg2
    Bg2.classList.add('active');
    //remove active class from bg1 and bg3
    Bg1.classList.remove('active');
    Bg3.classList.remove('active');
    changeBG();
})
Bg3.addEventListener('click', () => {
    darkColorLightness = '95%';
    ligthColorLightness = '10%';
    whiteColorLightness = '0%';
    //add active class to bg3
    Bg3.classList.add('active');
    //remove active class from bg1 and bg2
    Bg1.classList.remove('active');
    Bg2.classList.remove('active');
    changeBG();
})
