const rkit_dropdown_content = document.querySelectorAll('.rkit-navmenu-container');

window.onresize = resize;
window.onload = resize;

function resize() {
    const rkit_dropdown_content = document.querySelectorAll('.rkit-navmenu-container');
    rkit_dropdown_content.forEach(element => {
        var responsive = element.getAttribute('data-responsive-breakpoint');
        var id_key = element.getAttribute('data-key');
        const rkit_navmenu = document.querySelectorAll('.rkit-navmenu-menu' + id_key);
        if (window.innerWidth > responsive) {
            rkit_navmenu.forEach(e => {
                if (e.style.maxHeight === '0px') {
                    e.style.maxHeight = 'none';
                }
                e.classList.add('rkit-navmenu-padding');
            });
        } else {
            rkit_navmenu.forEach(e => {
                if (e.style.maxHeight === 'none') {
                    e.style.maxHeight = '0px';
                }
                e.classList.remove('rkit-navmenu-padding');
            });
        }
    });
}

function show_menu(id_key) {
    const rkit_navmenu_menu = document.querySelectorAll('.rkit-navmenu-menu' + id_key);
    rkit_navmenu_menu.forEach(element => {
        if (element.style.maxHeight === '0px') {
            element.style.maxHeight = (element.scrollHeight * 5) + 'px';
            element.classList.add('rkit-navmenu-padding');
            const icon_open = document.querySelectorAll('.rkit-icon-open' + id_key);
            icon_open.forEach(i => {
                i.style.transform = 'rotate(90deg)';
                i.style.opacity = '0';
                i.style.maxHeight = '0px';
            });
            const icon_close = document.querySelectorAll('.rkit-icon-close' + id_key);
            icon_close.forEach(i => {
                i.style.transform = 'rotate(0deg)';
                i.style.opacity = '1';
                i.style.maxHeight = i.scrollHeight + 'px';
            });
        } else {
            element.style.maxHeight = '0px';
            element.classList.remove('rkit-navmenu-padding');
            const icon_open = document.querySelectorAll('.rkit-icon-open' + id_key);
            icon_open.forEach(i => {
                i.style.transform = 'rotate(0deg)';
                i.style.opacity = '1';
                i.style.maxHeight = i.scrollHeight + 'px';
            });
            const icon_close = document.querySelectorAll('.rkit-icon-close' + id_key);
            icon_close.forEach(i => {
                i.style.transform = 'rotate(90deg)';
                i.style.opacity = '0';
                i.style.maxHeight = '0px';
            });
        }
    })
}