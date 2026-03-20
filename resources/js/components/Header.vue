<template>
    <header class="header">
        <div class="header__main">
            <div class="container header__main-inner">
                <a href="/" class="header__logo">
                    <span class="header__logo-text">
                        <img src="https://globusgroup.ams3.cdn.digitaloceanspaces.com/globusgroup/image/logos/GLOBUS-LOGO-GREY-DIGITAL.svg" alt="Globus Group Logo" class="header__logo-image">
                    </span>
                </a>
            </div>
        </div>
        <nav class="header__nav">
            <div class="container">
                <ul class="header__nav-list">
                    <li><a href="/products" class="header__nav-link">Products</a></li>
                    <li><a href="#" class="header__nav-link">Brands</a></li>
                    <li><a href="#" class="header__nav-link">Resources</a></li>
                    <li><a href="#" class="header__nav-link">About</a></li>
                    <li><a href="#" class="header__nav-link">Contact</a></li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<style scoped>
/* Header */
.header {
    position: sticky;
    top: 0;
    z-index: 100;
}

.header__main {
    background-color: var(--color-white);
    border-bottom: 1px solid #e5e7eb;
}

.header__main-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 20px;
    padding-bottom: 20px;
    gap: 1.5rem;
}

.header__logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
    color: var(--color-globus-grey);
}

.header__logo-text {
    height: 24px;
}

.header__logo-text img {
    height: 100%;
}

.header__nav {
    background-color: var(--color-globus-grey);
    border-bottom: 4px solid var(--color-globus-blue);
    display: none;
}

@media (min-width: 768px) {
    .header__nav {
        display: block;
    }
}

.header__nav-list {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 64px;
    padding: 0;
    margin: 0;
    list-style: none;
}

.header__nav-link {
    display: flex;
    align-items: center;
    height: 100%;
    padding: 10px 30px;
    color: var(--color-white);
    font-size: 14px;
    text-decoration: none;
    transition: background-color var(--transition-fast);
}

.header__nav-link:hover {
    background-color: var(--color-globus-grey-hover);
}
</style>
