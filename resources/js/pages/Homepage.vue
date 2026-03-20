<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Header from '@/components/Header.vue';

const categories = [
    {
        name: 'Safety Glasses',
        type: 'glasses',
        route: '/products/glasses',
        description: 'Eye protection for every environment',
        image: 'https://res.cloudinary.com/globusgroup/image/upload/w_400,h_400,f_auto,c_pad/PIM/871c8c4d%2F6605539e53b14266f200004f%2FRLY00602_P_I_FL_RLY_NavigatorXPolarised_0324.jpg',
    },
    {
        name: 'Work Gloves',
        type: 'gloves',
        route: '/products/gloves',
        description: 'Hand protection for all industries',
        image: 'https://res.cloudinary.com/globusgroup/image/upload/w_400,h_400,f_auto,c_pad/PIM/3b2eddd7%2F664c63ba90cf585517000034%2FBMG00713_P_I_LR_BMK_BMG713.png',
    },
    {
        name: 'Respiratory Protection',
        type: 'respiratory',
        route: '/products/respiratory',
        description: 'Breathe safely in any condition',
        image: 'https://res.cloudinary.com/globusgroup/image/upload/w_400,h_400,f_auto,c_pad/PIM/abcaf7d2%2F651688acf54a047ca600001a%2FMMSS-ALP-S3V-ALPHAS_P_I_F_ALP_S3V.png',
    },
];

</script>

<template>
    <Head title="Product Catalog">
        <link rel="stylesheet" href="https://use.typekit.net/tmb4lmh.css" />
    </Head>

    <div class="page">
        <!-- Header -->
        <Header />

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero__content container">
                <h1 class="hero__title">
                    Safety Equipment<br />
                    <span class="hero__title-accent">You Can Trust</span>
                </h1>
                <div class="hero__actions">
                    <a href="/products" class="btn btn--primary btn--lg">
                        Browse All Products
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/>
                            <path d="m12 5 7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section id="categories" class="categories">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Product Categories</h2>
                </div>
                
                <div class="categories__grid">
                    <a
                        v-for="category in categories"
                        :key="category.type"
                        :href="category.route"
                        class="product-card"
                    >
                        <div class="product-card__image-container">
                            <img 
                                :src="category.image" 
                                :alt="category.name"
                                class="product-card__image"
                            />
                        </div>
                        <div class="product-card__content">
                            <h3 class="product-card__title">{{ category.name }}</h3>
                            <p class="product-card__description">{{ category.description }}</p>
                        </div>
                        <div class="product-card__actions">
                            <span class="product-card__button">View Products</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- New Products Section -->
        <section class="new-products">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">New Products</h2>
                </div>
                
                <div class="new-products__content">
                    <a href="/products/new" class="btn btn--primary btn--lg">
                        See New Products
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/>
                            <path d="m12 5 7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
      
    </div>
</template>

<style>

/* Hero Section */
.hero {
    position: relative;
    background: linear-gradient(135deg, var(--color-globus-light-grey) 0%, #e8eef3 100%);
    clip-path: ellipse(150% 100% at 50% 0%);
    padding: 80px 0 120px;
}

@media (min-width: 768px) {
    .hero {
        padding: 100px 0 160px;
    }
}

.hero__content {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.hero__eyebrow {
    display: inline-block;
    padding: 6px 16px;
    margin-bottom: 24px;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--color-globus-blue);
    background-color: rgba(0, 111, 185, 0.1);
    border-radius: 9999px;
}

.hero__title {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.15;
    color: var(--color-globus-grey);
    margin-bottom: 24px;
}

@media (min-width: 768px) {
    .hero__title {
        font-size: 3.5rem;
    }
}

.hero__title-accent {
    color: var(--color-globus-blue);
}

.hero__description {
    font-size: 1.125rem;
    line-height: 1.6;
    color: var(--color-globus-mid-grey);
    margin-bottom: 32px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.hero__actions {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    justify-content: center;
}

/* Section Headers */
.section-header {
    text-align: center;
    margin-bottom: 48px;
}

.section-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--color-globus-grey);
    margin-bottom: 12px;
}

@media (min-width: 768px) {
    .section-title {
        font-size: 2.25rem;
    }
}

.section-description {
    font-size: 1.125rem;
    color: var(--color-globus-mid-grey);
    max-width: 600px;
    margin: 0 auto;
}

/* Categories Section */
.categories {
    padding: 80px 0;
    background-color: var(--color-white);
}

@media (min-width: 768px) {
    .categories {
        padding: 100px 0;
    }
}

.categories__grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 24px;
}

@media (min-width: 640px) {
    .categories__grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .categories__grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Product Card */
.product-card {
    display: flex;
    flex-direction: column;
    background: var(--color-white);
    text-decoration: none;
    color: inherit;
    transition: transform 0.3s ease;
}

.product-card:hover {
    transform: translateY(-4px);
}

.product-card__image-container {
    position: relative;
    width: 100%;
    aspect-ratio: 1 / 1;
    background: var(--color-globus-light-grey);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    margin-bottom: 16px;
    overflow: hidden;
}

.product-card__image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.5s ease;
}

.product-card:hover .product-card__image {
    transform: scale(1.05);
}

.product-card__content {
    flex: 1;
    text-align: left;
    margin-bottom: 16px;
}

.product-card__title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--color-globus-grey);
    margin: 0 0 8px;
}

.product-card__description {
    font-size: 0.875rem;
    color: var(--color-globus-mid-grey);
    margin: 0;
    line-height: 1.5;
}

.product-card__actions {
    display: flex;
}

.product-card__button {
    flex: 1;
    padding: 12px 20px;
    background-color: var(--color-globus-light-grey);
    color: var(--color-globus-grey);
    text-align: center;
    font-size: 0.875rem;
    font-weight: 400;
    border: 2px solid transparent;
    border-radius: var(--radius-md);
    transition: all 0.2s ease;
}

.product-card:hover .product-card__button {
    border-color: var(--color-globus-blue);
    color: var(--color-globus-blue);
}

/* New Products Section */
.new-products {
    padding: 80px 0;
    background-color: var(--color-globus-light-grey);
}

@media (min-width: 768px) {
    .new-products {
        padding: 100px 0;
    }
}

.new-products__content {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Footer */
.footer {
    padding: 48px 0;
    background-color: var(--color-white);
    border-top: 1px solid #e5e7eb;
}

.footer__content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    text-align: center;
}

@media (min-width: 640px) {
    .footer__content {
        flex-direction: row;
        justify-content: space-between;
        text-align: left;
    }
}

.footer__brand {
    display: flex;
    align-items: center;
    gap: 12px;
}

.footer__logo-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background-color: var(--color-globus-blue);
    color: var(--color-white);
    font-weight: 700;
    font-size: 0.875rem;
    border-radius: var(--radius-sm);
}

.footer__logo-text {
    font-weight: 600;
    color: var(--color-globus-grey);
}

.footer__note {
    font-size: 0.875rem;
    color: var(--color-globus-mid-grey);
    margin: 0;
}
</style>
