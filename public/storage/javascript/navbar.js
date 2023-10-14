document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.querySelector(".navbar ul")
    const hamburger = document.querySelector(".navbar .hamburger")

    const close = document.querySelector('.navbarHeader .close')

    const overlay = document.querySelector('.navbar .overlay')

    hamburger.onclick = () => {
        navbar.classList.add('show')
    }
    close.onclick = () => {
        navbar.classList.remove('show')
    }

    overlay.onclick = close.onclick
})