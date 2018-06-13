<template>
    <article class="vd-card">
        <div class="vd-card__hero" :style="{backgroundImage: 'url('+backgroundImage+')'}"></div>
        <div class="vd-card__content">
            <div class="vd-card__title">{{ recipe.title }}</div>
            <div class="vd-card__author">{{ recipe.user.full_name }}</div>
        </div>
        <div class="vd-card__avatar"></div>
    </article>
</template>

<script>
    export default {
        props: {
            recipe: {
                type: Object,
                required: true,
                default: {},
            }
        },

        computed: {
            backgroundImage() {
                return this.recipe.image ? this.recipe.image : 'https://source.unsplash.com/600x500/?meal';
            }
        },
    }
</script>
