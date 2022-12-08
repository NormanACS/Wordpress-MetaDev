function ionosHelperReuseFeaturedLink() {
    let featuredLink = document.querySelector('.filter-links a[data-sort="popular"]')
    featuredLink.setAttribute('data-sort', 'ionos');
    featuredLink.innerText = 'IONOS'
    window.history.pushState('', '', location.pathname + '?browse=ionos')
}
ionosHelperReuseFeaturedLink()

/*
function ionosHelperCreateNewLink(name, sort) {
    let bar = document.querySelector('.filter-links');
    let li = document.createElement('LI');
    let a = document.createElement('A');
    a.setAttribute('data-sort', 'featured');
    a.innerText = 'Featured';
    a.href = '#';
    li.append(a);
    bar.prepend(li);
}
ionosHelperCreateNewLink('Test', 'test')
*/